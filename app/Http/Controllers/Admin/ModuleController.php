<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function show($id)
    {
        $module = Module::findOrFail($id);
        return response()->json(['data'=>config('module.'.$module->module_type),'type'=>$module->module_type]);
    }
}
