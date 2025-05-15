<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\CentralLogics\Helpers;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function add_new()
    {
        $rls = AdminRole::whereNotIn('id', [1])->get();
        return view('admin-views.employee.add-new', compact('rls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'nullable|max:100',
            'role_id' => 'required',
            'image' => 'required',
            'email' => 'required|unique:admins',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:admins',
            'password' => ['required', Password::min(8)],
            // 'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],

        ]);

        if ($request->role_id == 1) {
            Toastr::warning('Access denied');
            return back();
        }

        DB::table('admins')->insert([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'zone_id' => 1,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
            'image' => Helpers::upload('admin/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Toastr::success('Employee added successfully');
        return redirect()->route('admin.employee.list');
    }

    function list(Request $request)
    {
        $key = explode(' ', $request['search']);
        $em = Admin::where('role_id', '!=', '1')
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%");
                    $q->orWhere('l_name', 'like', "%{$value}%");
                    $q->orWhere('phone', 'like', "%{$value}%");
                    $q->orWhere('email', 'like', "%{$value}%");
                }
            })->latest()->paginate(config('default_pagination'));
        return view('admin-views.employee.list', compact('em'));
    }

    public function edit($id)
    {
        $e = Admin::where('role_id', '!=', '1')->where(['id' => $id])->first();
        $rls = AdminRole::whereNotIn('id', [1])->get();
        if (auth('admin')->id()  != $e['id']) {
            return view('admin-views.employee.edit', compact('rls', 'e'));
        }
        Toastr::warning('Access Denied!');
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'role_id' => 'required',
            'email' => 'required|unique:admins,email,' . $id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:admins,phone,' . $id,
            'password' => ['nullable', Password::min(8)],
            // 'password' => ['nullable', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        if ($request->role_id == 1) {
            Toastr::warning('Access Denied');
            return back();
        }

        $e = Admin::where('role_id', '!=', 1)->findOrFail($id);
        if ($request['password'] == null) {
            $pass = $e['password'];
        } else {
            if (strlen($request['password']) < 7) {
                Toastr::warning('Password length warning');
                return back();
            }
            $pass = bcrypt($request['password']);
            $e->remember_token = null;
        }

        if ($request->has('image')) {
            $e['image'] = Helpers::update('admin/', $e->image, 'png', $request->file('image'));
        }


        $e->f_name = $request->f_name;
        $e->l_name = $request->l_name;
        $e->phone = $request->phone;
        $e->zone_id = 1;
        $e->email = $request->email;
        $e->role_id = $request->role_id;
        $e->password = $pass;
        $e->image = $e['image'];
        $e->updated_at = now();
        $e->is_logged_in = 0;
        $e->save();

        Toastr::success('Employee updated successfully');
        return redirect()->route('admin.employee.list');
    }

    public function distroy($id)
    {
        $role = Admin::where('role_id', '!=', '1')->where(['id' => $id])->delete();
        Toastr::info('Employee deleted successfully');
        return back();
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $employees = Admin::where('role_id', '!=', '1')
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%");
                    $q->orWhere('l_name', 'like', "%{$value}%");
                    $q->orWhere('phone', 'like', "%{$value}%");
                    $q->orWhere('email', 'like', "%{$value}%");
                }
            })->limit(50)->get();
        return response()->json([
            'view' => view('admin-views.employee.partials._table', compact('employees'))->render(),
            'count' => $employees->count()
        ]);
    }

    function export(Request $request)
    {
        $key = explode(' ', $request['search']);
        $em = Admin::where('role_id', '!=', '1')
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%");
                    $q->orWhere('l_name', 'like', "%{$value}%");
                    $q->orWhere('phone', 'like', "%{$value}%");
                    $q->orWhere('email', 'like', "%{$value}%");
                }
            })->latest()->get();
        $data = [
            'employees' => $em,
            'search' => $request->search ?? null,
        ];

        // if ($request->type == 'excel') {
        //     return Excel::download(new EmployeeListExport($data), 'Employees.xlsx');
        // } else if ($request->type == 'csv') {
        //     return Excel::download(new EmployeeListExport($data), 'Employees.csv');
        // }
    }
}
