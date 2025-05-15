<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DataSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\App;
use App\CentralLogics\Helpers;
use App\Models\Module;
use App\Models\Vendor;
use App\Models\VendorEmployee;

class AdminController extends Controller
{
    public function login($login_url)
    {
        $data = array_column(DataSetting::whereIn('key', [
            'store_employee_login_url',
            'store_login_url',
            'admin_employee_login_url',
            'admin_login_url'
        ])->get(['key', 'value'])->toArray(), 'value', 'key');

        $loginTypes = [
            'admin' => 'admin_login_url',
            'admin_employee' => 'admin_employee_login_url',
            'vendor' => 'store_login_url',
            'vendor_employee' => 'store_employee_login_url'
        ];
        $siteDirections = [
            'admin' => session()?->get('site_direction') ?? 'ltr',
            'admin_employee' => session()?->get('site_direction') ?? 'ltr',
            'vendor' => session()?->get('vendor_site_direction') ?? 'ltr',
            'vendor_employee' => session()?->get('vendor_site_direction') ?? 'ltr'
        ];
        $locals = [
            'admin' => session()?->get('local') ?? 'en',
            'admin_employee' => session()?->get('local') ?? 'en',
            'vendor' => session()?->get('vendor_local') ?? 'en',
            'vendor_employee' => session()?->get('vendor_local') ?? 'en'
        ];
        $role = null;

        $user_type = array_search($login_url, $data);
        abort_if(!$user_type, 404);
        $role = array_search($user_type, $loginTypes, true);

        abort_if($role == null, 404);
        $site_direction = $siteDirections[$role];
        $locale = $locals[$role];
        App::setLocale($locale);
        $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('six_captcha', $custome_recaptcha->getPhrase());

        $email =  null;
        $password = null;
        if (Cookie::has('p_token') && Cookie::has('e_token') && Cookie::has('role')  &&  Cookie::get('role') == $role) {
            $email = Crypt::decryptString(Cookie::get('e_token'));
            $password = Crypt::decryptString(Cookie::get('p_token'));
        }

        return view('auth.login', compact('custome_recaptcha', 'email', 'password', 'role', 'site_direction', 'locale'));
    }
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);
        // $recaptcha = Helpers::get_business_settings('recaptcha');
        // if (isset($recaptcha) && $recaptcha['status'] == 1) {
        //     $request->validate([
        //         'g-recaptcha-response' => [
        //             function ($attribute, $value, $fail) {
        //                 $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
        //                 $response = $value;
        //                 $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
        //                 $response = Http::get($url);
        //                 $response = $response->json();
        //                 if (!isset($response['success']) || !$response['success']) {
        //                     $fail(translate('messages.ReCAPTCHA Failed'));
        //                 }
        //             },
        //         ],
        //     ]);
        // } else if(strtolower(session('six_captcha')) != strtolower($request->custome_recaptcha))
        // {
        //     Toastr::error(translate('messages.ReCAPTCHA Failed'));
        //     return back();
        // }

        if ($request->role == 'admin_employee') {
            $data = Admin::where('email', $request->email)->where('role_id', 1)->exists();
            if ($data) {
                return redirect()->back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['Credentials does not match.']);
            }
        } elseif ($request->role == 'vendor') {
            $vendor = Vendor::where('email', $request->email)->first();
            if ($vendor) {
                if ($vendor->stores[0]->status == 0) {
                    return redirect()->back()->withInput($request->only('email', 'remember'))
                        ->withErrors(['Inactive vendor warning']);
                }
            }
        } elseif ($request->role == 'vendor_employee') {
            $employee = VendorEmployee::where('email', $request->email)->first();
            if ($employee) {
                if ($employee?->store?->status == 0) {
                    return redirect()->back()->withInput($request->only('email', 'remember'))
                        ->withErrors(['Inactive vendor warning']);
                }
            }
        }

        $data = $this->login_attemp($request->role, $request->email, $request->password, $request->remember);

        if ($data == 'admin') {
            $admin = Admin::find(auth('admin')->id());
            $admin->is_logged_in = 1;
            $admin->save();
            $modules = Module::Active()->get();
            if (isset($modules) && ($modules->count() > 0)) {

                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('admin.business-settings.business-setup');
        }
        if ($data == 'vendor') {
            return redirect()->route('vendor.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function reloadCaptcha()
    {
        $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('six_captcha', $custome_recaptcha->getPhrase());

        return response()->json([
            'view' => view('auth.custom-captcha', compact('custome_recaptcha'))->render()
        ], 200);
    }

    public function login_attemp($role,$email ,$password, $remember = false){
        $auth= ($role == 'admin_employee' ? 'admin' :$role);
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
                if($auth == 'admin'){
                    return 'admin';
                } else {
                    return 'vendor';
                }
            }
        return false;
    }

    public function logout()
    {
        if(auth('vendor')?->check()){
            $user_link = Helpers::get_login_url('store_login_url');
            auth()->guard('vendor')->logout();
        }
        elseif(auth('vendor_employee')?->check()){
            $user_link = Helpers::get_login_url('store_employee_login_url');
            auth()->guard('vendor_employee')->logout();
        }
        else{
            if(!auth()?->guard('admin')?->user()?->role_id == 1){
                $user_link = Helpers::get_login_url('admin_employee_login_url');
            } else {
                $user_link = Helpers::get_login_url('admin_login_url');
            }
            auth()?->guard('admin')?->logout();
        }
        return redirect()->route('login',[$user_link]);
    }

    public function index()
    {
        return view('auth.login');
    }

    // public function login_attemp($role, $email, $password, $remember = false)
    // {

    //     $auth = ($role == '1' ? 'admin' : $role);
    //     if (auth($auth)->attempt(['email' => $email, 'password' => $password], $remember)) {

    //         // return redirect()->route('vendor.dashboard');
    //         if ($remember) {
    //             Cookie::queue('role', $role, 120);
    //             Cookie::queue('e_token', Crypt::encryptString($email), 120);
    //             Cookie::queue('p_token', Crypt::encryptString($password), 120);
    //         } else {
    //             $user = auth($auth)?->user();
    //             $user?->update([
    //                 'remember_token' => null
    //             ]);
    //             Cookie::forget('role');
    //             Cookie::forget('e_token');
    //             Cookie::forget('p_token');
    //         }
    //         if ($auth == 'admin') {
    //             return 'admin';
    //         } else {
    //             dd('sss');
    //             return 'vendor';
    //         }
    //     }
    //     return false;
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);
    //     $data = $this->login_attemp($request->role, $request->email, $request->password, $request->remember);

    //     if ($data == 'admin') {
    //         $admin = Admin::find(auth('admin')->id());
    //         $admin->is_logged_in = 1;
    //         $admin->save();
    //         return redirect()->route('admin.dashboard');
    //     }
    //     return redirect()->back()->withInput($request->only('email', 'remember'))
    //         ->withErrors(['Credentials does not match.']);

    // }

    // public function logout()
    // {
    //     auth()?->guard('admin')?->logout();
    //     return redirect()->route('login');
    // }
}
