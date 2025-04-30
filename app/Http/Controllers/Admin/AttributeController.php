<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    function index(Request $request)
    {
        
        $key = explode(' ', $request['search']);

        $attributes = Attribute::orderBy('name')
            ->when(isset($key), function ($q) use ($key) {
                $q->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%");
                    }
                });
            })
            ->paginate(config('default_pagination'));
        return view('admin-views.attribute.index', compact('attributes'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:attributes|max:100',
        ], [
            'name.required' => 'Name is required!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        
        $attribute = new Attribute;
        $attribute->name = $request->name;
        $attribute->save();
        return response()->json([], 200);
    }

    public function edit($id)
    {
        $attribute = Attribute::withoutGlobalScope('translate')->findOrFail($id);
        return view('admin-views.attribute.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:attributes,name,' . $id,
            'name.0' => 'required',
        ], [
            'name.required' => translate('messages.Name is required!'),
            'name.0.required' => translate('default_data_is_required'),
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name[array_search('default', $request->lang)];
        $attribute->save();
        $default_lang = str_replace('_', '-', app()->getLocale());
        foreach ($request->lang as $index => $key) {
            if ($default_lang == $key && !($request->name[$index])) {
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Attribute',
                            'translationable_id' => $attribute->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $attribute->name]
                    );
                }
            } else {

                if ($request->name[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Attribute',
                            'translationable_id' => $attribute->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $request->name[$index]]
                    );
                }
            }
        }
        Toastr::success(translate('messages.attribute_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $attribute = Attribute::findOrFail($request->id);
        $attribute->translations()->delete();
        $attribute->delete();
        Toastr::success(translate('messages.attribute_deleted_successfully'));
        return back();
    }
}
