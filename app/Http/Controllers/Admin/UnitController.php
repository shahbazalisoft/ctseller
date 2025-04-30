<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use Brian2694\Toastr\Facades\Toastr;


class UnitController extends Controller
{
    function index(Request $request)
    {
        // $unit = Unit::paginate(config('default_pagination'));
        $key = explode(' ', $request['search']);

        $unit = Unit::orderBy('unit')
            ->when(isset($key), function ($q) use ($key) {
                $q->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('unit', 'like', "%{$value}%");
                    }
                });
            })
            ->paginate(config('default_pagination'));
        return view('admin-views.unit.index', compact('unit'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'unit' => 'required|unique:units|max:100',
        ], [
            'unit.required' => 'Unit is required!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        
        $unit = new Unit;
        $unit->unit = $request->unit;
        $unit->save();
        return response()->json([], 200);
    }

    public function delete(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $unit->delete();
        Toastr::success('Unit deleted successfully');
        return back();
    }
}
