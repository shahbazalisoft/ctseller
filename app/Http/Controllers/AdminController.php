<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_attemp($role, $email, $password, $remember = false)
    {
        
        $auth = ($role == '1' ? 'admin' : $role);
        if (auth($auth)->attempt(['email' => $email, 'password' => $password], $remember)) {
            
            // return redirect()->route('vendor.dashboard');
            if ($remember) {
                Cookie::queue('role', $role, 120);
                Cookie::queue('e_token', Crypt::encryptString($email), 120);
                Cookie::queue('p_token', Crypt::encryptString($password), 120);
            } else {
                $user = auth($auth)?->user();
                $user?->update([
                    'remember_token' => null
                ]);
                Cookie::forget('role');
                Cookie::forget('e_token');
                Cookie::forget('p_token');
            }
            if ($auth == 'admin') {
                return 'admin';
            } else {dd('sss');
                return 'vendor';
            }
        }
        return false;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $data = $this->login_attemp($request->role, $request->email, $request->password, $request->remember);
       
        if ($data == 'admin') {
            $admin = Admin::find(auth('admin')->id());
            $admin->is_logged_in = 1;
            $admin->save();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);

    }

    public function logout()
    {
        auth()?->guard('admin')?->logout();
        return redirect()->route('login');
    }
}
