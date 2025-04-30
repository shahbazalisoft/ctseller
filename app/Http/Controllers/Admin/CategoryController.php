<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $key = explode(' ', $request['search']);
        $categories=Category::with('module')->where(['position'=>0])->module(1)
            ->when(isset($key) , function ($q) use($key){
                $q->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%");
                    }
                });
            })
        ->latest()->paginate(config('default_pagination'));
        
        return view('admin-views.category.index',compact('categories'));
    }

    public function add(Request $request)
    {
        return view('admin-views.category.add');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ], [
            'name.required' => 'Name is required!',
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        $category->image = Helpers::upload('category/', 'png', $request->file('image'));
        $category->parent_id = $request->parent_id == null ? 0 : $request->parent_id;
        $category->position = 0;
        $category->module_id = 1;
        $category->save();
        if($category){
            Toastr::success('Category added successfully');
        }else{
            Toastr::error('Something went wrong!');
        }
        return to_route('admin.category.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin-views.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
        ],[
            'name.required'=>'Name is required',
        ]);

        $category = Category::find($id);
        $slug = Str::slug($request->name);
        $category->slug = $category->slug? $category->slug :"{$slug}{$category->id}";
        $category->name = $request->name;
        $category->image = $request->has('image') ? Helpers::update('category/', $category->image, 'png', $request->file('image')) : $category->image;
        $category->save();
        
        Toastr::success('Category updated successfully');
        return back();
    }

    public function status(Request $request)
    {
        $category = Category::find($request->id);
        $category->status = $request->status;
        $category->save();
        Toastr::success('Category status updated');
        return back();
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if ($category->childes->count()==0){
            $category->delete();
            Toastr::success('Category removed');
        }else{
            Toastr::warning('Remove sub categories first!');
        }
        return back();
    }

    public function update_priority(Category $category, Request $request)
    {
        $priority = $request->priority??0;
        $category->priority = $priority;
        $category->save();
        Toastr::success('Category priority updated successfully');
        return back();

    }

    public function get_all(Request $request)
    {
        $data = Category::where('name', 'like', '%'.$request->q.'%')
        ->when($request->module_id, function($query)use($request){
            $query->where('module_id', $request->module_id);
        })->limit(8)->get()

        ->map(function ($category) {
            $data =$category->position == 0 ? 'main': 'sub';
            return [
                'id' => $category->id,
                'text' => $category->name . ' (' .  $data   . ')',
            ];
        });


        $data[]=(object)['id'=>'all', 'text'=>'All'];
        return response()->json($data);
    }

    //SubCategory
    function sub_index(Request $request)
    {
        $key = explode(' ', $request['search']);
        $categories=Category::with(['parent'])->where(['position'=>1])->module(1)
        ->when(isset($key) , function ($q) use($key){
            $q->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        })
        ->latest()->paginate(config('default_pagination'));
        return view('admin-views.category.sub-index',compact('categories'));
    }

    public function sub_add(Request $request)
    {
        $category = Category::with('module')->where(['position'=>0])->module(1)->get();
        return view('admin-views.category.add_sub', compact('category'));
    }

    function sub_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ], [
            'name.required' => 'Name is required!',
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        // $category->image = Helpers::upload('category/', 'png', $request->file('image'));
        $category->parent_id = $request->parent_id == null ? 0 : $request->parent_id;
        $category->position = 1;
        $category->module_id = 1;
        $category->save();
        if($category){
            Toastr::success('Sub Category added successfully');
        }else{
            Toastr::error('Something went wrong!');
        }
        return to_route('admin.category.sub-category');
    }

    public function sub_edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('admin-views.category.edit_sub', compact('category'));
    }
}
