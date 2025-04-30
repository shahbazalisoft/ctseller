<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Store;
use App\Models\StoreWallet;
use App\Models\Zone;
use App\Models\TempProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public function list(Request $request)
    {
        $key = explode(' ', $request['search']);
        $zone_id = $request->query('zone_id', 'all');
        $type = $request->query('type', 'all');
        $module_id = $request->query('module_id', 'all');
        $stores = Store::with('vendor', 'module')->whereHas('vendor', function ($query) {
            return $query->where('status', 1);
        })
            ->when(is_numeric($zone_id), function ($query) use ($zone_id) {
                return $query->where('zone_id', $zone_id);
            })
            ->when(is_numeric($module_id), function ($query) use ($request) {
                return $query->module($request->query('module_id'));
            })
            ->when(isset($key), function ($query) use ($key) {
                return $query->where(function ($query) use ($key) {
                    $query->orWhereHas('vendor', function ($q) use ($key) {
                        $q->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('f_name', 'like', "%{$value}%")
                                    ->orWhere('l_name', 'like', "%{$value}%")
                                    ->orWhere('email', 'like', "%{$value}%")
                                    ->orWhere('phone', 'like', "%{$value}%");
                            }
                        });
                    })->orWhere(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('name', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%");
                        }
                    });
                });
            })
            ->module(1)
            ->with('vendor', 'module')->type($type)->latest()->paginate(config('default_pagination'));
        $zone = is_numeric($zone_id) ? Zone::findOrFail($zone_id) : null;
        return view('admin-views.vendor.list', compact('stores', 'zone', 'type'));
    }

    public function view($store_id, $tab = null, $sub_tab = 'cash')
    {
        $key = explode(' ', request()->search);

        $store = Store::find($store_id);
        $wallet = $store->vendor->wallet;
        if (!$wallet) {
            $wallet = new StoreWallet();
            $wallet->vendor_id = $store->vendor->id;
            $wallet->total_earning = 0.0;
            $wallet->total_withdrawn = 0.0;
            $wallet->pending_withdraw = 0.0;
            $wallet->created_at = now();
            $wallet->updated_at = now();
            $wallet->save();
        }
        if ($tab == 'settings') {
            return view('admin-views.vendor.view.settings', compact('store'));
        } else if ($tab == 'order') {
            $orders = Order::where('store_id', $store->id)->latest()
                ->when(isset($key), function ($q) use ($key) {
                    $q->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('id', 'like', "%{$value}%");
                        }
                    });
                })
                ->Notpos()->paginate(10);
            return view('admin-views.vendor.view.order', compact('store', 'orders'));
        } else if ($tab == 'item') {
            if ($sub_tab == 'pending-items' || $sub_tab == 'rejected-items') {

                $foods = TempProduct::withoutGlobalScope(\App\Scopes\StoreScope::class)->where('store_id', $store->id)
                    ->when(isset($key), function ($q) use ($key) {
                        $q->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->where('name', 'like', "%{$value}%");
                            }
                        });
                    })
                    ->when($sub_tab == 'pending-items', function ($q) {
                        $q->where('is_rejected', 0);
                    })
                    ->when($sub_tab == 'rejected-items', function ($q) {
                        $q->where('is_rejected', 1);
                    })
                    ->latest()->paginate(25);
            } else {

                $foods = Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where('store_id', $store->id)
                    ->when(isset($key), function ($q) use ($key) {
                        $q->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->where('name', 'like', "%{$value}%");
                            }
                        });
                    })
                    ->when($sub_tab == 'active-items', function ($q) {
                        $q->where('status', 1);
                    })
                    ->when($sub_tab == 'inactive-items', function ($q) {
                        $q->where('status', 0);
                    })
                    ->latest()->paginate(25);
            }

            return view('admin-views.vendor.view.product', compact('store', 'foods', 'sub_tab'));
        } else if ($tab == 'discount') {
            return view('admin-views.vendor.view.discount', compact('store'));
        } else if ($tab == 'transaction') {
            return view('admin-views.vendor.view.transaction', compact('store', 'sub_tab'));
        } else if ($tab == 'reviews') {
            return view('admin-views.vendor.view.review', compact('store', 'sub_tab'));
        } else if ($tab == 'conversations') {
            $user = UserInfo::where(['vendor_id' => $store->vendor->id])->first();
            if ($user) {
                $conversations = Conversation::with(['sender', 'receiver', 'last_message'])->WhereUser($user->id)
                    ->paginate(8);
            } else {
                $conversations = [];
            }
            return view('admin-views.vendor.view.conversations', compact('store', 'sub_tab', 'conversations'));
        } else if ($tab == 'meta-data') {
            $store = Store::withoutGlobalScope('translate')->findOrFail($store_id);
            return view('admin-views.vendor.view.meta-data', compact('store', 'sub_tab'));
        }
        $store_docs = $store->store_documents ? explode(',', $store->store_documents) : [];
        return view('admin-views.vendor.view.index', compact('store', 'wallet', 'store_docs'));
    }

    public function status(Store $store, Request $request)
    {
        $store->status = $request->status;
        $store->save();
        $vendor = $store->vendor;

        try {
            if ($request->status == 0) {
                $vendor->auth_token = null;
                if (isset($vendor->fcm_token)) {
                    $data = [
                        'title' => 'Suspended',
                        'description' => 'Your account has been suspended',
                        'order_id' => '',
                        'image' => '',
                        'type' => 'block'
                    ];
                    // Helpers::send_push_notif_to_device($vendor->fcm_token, $data);
                    DB::table('user_notifications')->insert([
                        'data' => json_encode($data),
                        'vendor_id' => $vendor->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Toastr::warning('Push notification faild');
        }

        Toastr::success('Store status updated');
        return back();
    }

    public function edit($id)
    {
        if ($id == 2) {
            Toastr::warning('You can not edit this store please add a new store to edit');
            return back();
        }
        $store = Store::findOrFail($id);
        $store->store_document_uploaded = $store->store_documents ? explode(',', $store->store_documents) : [];
        return view('admin-views.vendor.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'name' => 'required|max:191',
            'email' => 'required|unique:vendors,email,' . $store->vendor->id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:vendors,phone,' . $store->vendor->id,
            'zone_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tax' => 'required',
            'password' => ['nullable', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'minimum_delivery_time' => 'required',
            'maximum_delivery_time' => 'required',
            'delivery_time_type' => 'required'
        ], [
            'f_name.required' => translate('messages.first_name_is_required')
        ]);

        if ($request->zone_id) {
            $zone = Zone::query()
                ->whereContains('coordinates', new Point($request->latitude, $request->longitude, POINT_SRID))
                ->where('id', $request->zone_id)
                ->first();
            if (!$zone) {
                $validator->getMessageBag()->add('latitude', translate('messages.coordinates_out_of_zone'));
                return back()->withErrors($validator)
                    ->withInput();
            }
        }
        if ($request->delivery_time_type == 'min') {
            $minimum_delivery_time = (int) $request->input('minimum_delivery_time');
            if ($minimum_delivery_time < 10) {
                $validator->getMessageBag()->add('minimum_delivery_time', translate('messages.minimum_delivery_time_should_be_more_than_10_min'));
                return back()->withErrors($validator)
                    ->withInput();
            }
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $vendor = Vendor::findOrFail($store->vendor->id);
        $vendor->f_name = $request->f_name;
        $vendor->l_name = $request->l_name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->password = strlen($request->password) > 1 ? bcrypt($request->password) : $store->vendor->password;
        $vendor->save();

        $slug = Str::slug($request->name[array_search('default', $request->lang)]);
        $store->slug = $store->slug ? $store->slug : "{$slug}{$store->id}";
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->logo = $request->has('logo') ? Helpers::update('store/', $store->logo, 'png', $request->file('logo')) : $store->logo;
        $store->cover_photo = $request->has('cover_photo') ? Helpers::update('store/cover/', $store->cover_photo, 'png', $request->file('cover_photo')) : $store->cover_photo;
        $store->name = $request->name[array_search('default', $request->lang)];
        $store->address = $request->address[array_search('default', $request->lang)];
        $store->latitude = $request->latitude;
        $store->longitude = $request->longitude;
        $store->zone_id = $request->zone_id;
        $store->tax = $request->tax;
        $store->delivery_time = $request->minimum_delivery_time . '-' . $request->maximum_delivery_time . ' ' . $request->delivery_time_type;
        //Store Documents...
        if (!empty($request->file('store_documents'))) {
            $oldDocs = Store::where('id', $store->id)->pluck('store_documents')->first();
            $oldDocArr = $oldDocs ? explode(',', $oldDocs) : [];
            foreach ($request->store_documents as $img) {
                $extension = $img->extension();
                $file_name = Helpers::upload('store_documents/', $extension, $img);
                $store_documents[] = $file_name;
            }
            $allDocs = array_merge($oldDocArr, $store_documents);
            $store->store_documents = implode(',', $allDocs);
        }
        $store->save();
        $default_lang = str_replace('_', '-', app()->getLocale());
        foreach ($request->lang as $index => $key) {
            if ($default_lang == $key && !($request->name[$index])) {
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $store->name]
                    );
                }
            } else {

                if ($request->name[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type'  => 'App\Models\Store',
                            'translationable_id'    => $store->id,
                            'locale'                => $key,
                            'key'                   => 'name'
                        ],
                        ['value'                 => $request->name[$index]]
                    );
                }
            }
            if ($default_lang == $key && !($request->address[$index])) {
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'address'
                        ],
                        ['value' => $store->address]
                    );
                }
            } else {

                if ($request->address[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type'  => 'App\Models\Store',
                            'translationable_id'    => $store->id,
                            'locale'                => $key,
                            'key'                   => 'address'
                        ],
                        ['value'                 => $request->address[$index]]
                    );
                }
            }
        }
        if ($vendor->userinfo) {
            $userinfo = $vendor->userinfo;
            $userinfo->f_name = $store->name;
            $userinfo->l_name = '';
            $userinfo->email = $store->email;
            $userinfo->image = $store->logo;
            $userinfo->save();
        }
        Toastr::success(translate('messages.store') . translate('messages.updated_successfully'));
        return redirect('admin/store/list');
    }

    public function pending_requests(Request $request)
    {
        $zone_id = $request->query('zone_id', 'all');
        $search_by = $request->query('search_by');
        $key = explode(' ', $search_by);
        $type = $request->query('type', 'all');
        $module_id = $request->query('module_id', 'all');
        $stores = Store::with('vendor', 'module')->whereHas('vendor', function ($query) {
            return $query->where('status', null);
        })
            ->when(is_numeric($zone_id), function ($query) use ($zone_id) {
                return $query->where('zone_id', $zone_id);
            })
            ->when(is_numeric($module_id), function ($query) use ($request) {
                return $query->module($request->query('module_id'));
            })
            ->when($search_by, function ($query) use ($key) {
                return $query->where(function ($query) use ($key) {
                    $query->orWhereHas('vendor', function ($q) use ($key) {
                        $q->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('f_name', 'like', "%{$value}%")
                                    ->orWhere('l_name', 'like', "%{$value}%")
                                    ->orWhere('email', 'like', "%{$value}%")
                                    ->orWhere('phone', 'like', "%{$value}%");
                            }
                        });
                    })->orWhere(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('name', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%");
                        }
                    });
                });
            })
            ->module(1)
            ->type($type)->latest()->paginate(config('default_pagination'));
        $zone = is_numeric($zone_id) ? Zone::findOrFail($zone_id) : null;
        return view('admin-views.vendor.pending_requests', compact('stores', 'zone', 'type', 'search_by'));
    }

    public function deny_requests(Request $request)
    {
        $search_by = $request->query('search_by');
        $key = explode(' ', $search_by);
        $zone_id = $request->query('zone_id', 'all');
        $type = $request->query('type', 'all');
        $module_id = $request->query('module_id', 'all');
        $stores = Store::with('vendor', 'module')->whereHas('vendor', function ($query) {
            return $query->where('status', 0);
        })
            ->when(is_numeric($zone_id), function ($query) use ($zone_id) {
                return $query->where('zone_id', $zone_id);
            })
            ->when(is_numeric($module_id), function ($query) use ($request) {
                return $query->module($request->query('module_id'));
            })
            ->when($search_by, function ($query) use ($key) {
                return $query->where(function ($query) use ($key) {
                    $query->orWhereHas('vendor', function ($q) use ($key) {
                        $q->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('f_name', 'like', "%{$value}%")
                                    ->orWhere('l_name', 'like', "%{$value}%")
                                    ->orWhere('email', 'like', "%{$value}%")
                                    ->orWhere('phone', 'like', "%{$value}%");
                            }
                        });
                    })->orWhere(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('name', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%");
                        }
                    });
                });
            })
            ->module(1)
            ->type($type)->latest()->paginate(config('default_pagination'));
        $zone = is_numeric($zone_id) ? Zone::findOrFail($zone_id) : null;
        return view('admin-views.vendor.deny_requests', compact('stores', 'zone', 'type', 'search_by'));
    }

    public function update_application(Request $request)
    {
        $store = Store::findOrFail($request->id);
        $store->vendor->status = $request->status;
        $store->vendor->save();
        if($request->status) $store->status = 1;
        $store->save();
        try{
            // if($request->status==1){
            //     $mail_status = Helpers::get_mail_status('approve_mail_status_store');
            //     if ( config('mail.status') && $mail_status == '1') {
            //         Mail::to($store?->vendor?->email)->send(new \App\Mail\VendorSelfRegistration('approved', $store->vendor->f_name.' '.$store->vendor->l_name, $store->vendor->f_name));
            //     }
            // }else{
            //     $mail_status = Helpers::get_mail_status('deny_mail_status_store');
            //     if ( config('mail.status') && $mail_status == '1') {
            //         Mail::to($store?->vendor?->email)->send(new \App\Mail\VendorSelfRegistration('denied', $store->vendor->f_name.' '.$store->vendor->l_name, $store->vendor->f_name));
            //     }
            // }
        }catch(\Exception $ex){
            info($ex->getMessage());
        }
        Toastr::success('Application status updated successfully');
        return back();
    }

    public function get_stores(Request $request)
    {
        $zone_ids = isset($request->zone_ids) ? (count($request->zone_ids) > 0 ? $request->zone_ids : []) : 0;
        $data = Store::
            // withOutGlobalScopes()
            // ->
            // join('zones', 'zones.id', '=', 'stores.zone_id')
            // ->
            when($zone_ids, function ($query) use ($zone_ids) {
                $query->whereIn('stores.zone_id', [$zone_ids]);
            })
            ->when($request->module_id, function ($query) use ($request) {
                $query->where('module_id', $request->module_id);
            })
            ->when($request->module_type, function ($query) use ($request) {
                $query->whereHas('module', function ($q) use ($request) {
                    $q->where('module_type', $request->module_type);
                });
            })
            ->where('stores.name', 'like', '%' . $request->q . '%')
            ->limit(8)->get()
            ->map(function ($store) {
                return [
                    'id' => $store->id,
                    'text' => $store->name . ' (' . $store->zone?->name . ')',
                ];
            });
        if (isset($request->all)) {
            $data[] = (object)['id' => 'all', 'text' => 'All'];
        }
        return response()->json($data);
    }
}
