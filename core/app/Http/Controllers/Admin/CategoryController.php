<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FileFormat;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categories()
    {
        $pageTitle = 'All Categories';
        $categories = Category::latest()->with('subcategories')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.category.category',compact('pageTitle','categories','emptyMessage'));
    }

    public function storeCategory(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:191'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->status = 1;
        $category->save();

        $notify[] = ['success', 'Category has been added'];
        return back()->withNotify($notify);
    }

    public function updateCategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:191'
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', 'Category has been Updated'];
        return back()->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $category = Category::findOrFail($request->id);
        $category->status = 1;
        $category->save();

        $notify[] = ['success', $category->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $category = Category::findOrFail($request->id);
        $category->status = 0;
        $category->save();

        $notify[] = ['success', $category->name . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function searchCategory(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Category Search - ' . $search;
        $emptyMessage = 'No data found';
        $categories = Category::where('name', 'like',"%$search%")->with('subcategories')->paginate(getPaginate());

        return view('admin.category.category', compact('pageTitle', 'categories', 'emptyMessage'));
    }

    public function subcategories($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = $category->name.' - Subcategories';
        $subcategories = $category->subCategories()->with('formats')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.category.subcategory',compact('pageTitle','subcategories', 'category','emptyMessage'));
    }

    public function storeSubcategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $category = Category::findOrFail($id);

        $subcategory = new SubCategory();
        $subcategory->category_id = $category->id;
        $subcategory->name = $request->name;
        $subcategory->status = 1;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been added'];
        return back()->withNotify($notify);
    }

    public function updateSubcategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->name = $request->name;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been updated'];
        return back()->withNotify($notify);
    }

    public function subcategoryActivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = 1;
        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been activated'];
        return back()->withNotify($notify);
    }

    public function subcategoryDeactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = 0;
        $subcategory->save();

        $notify[] = ['success', $subcategory->name . ' has been disabled'];
        return back()->withNotify($notify);
    }

    public function searchSubcategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $search = $request->search;

        $pageTitle = 'Subcategory Search - ' . $search;
        $emptyMessage = 'No data found';

        $subcategories = $category->subcategories()->where('name', 'like',"%$search%")->with('formats')->paginate(getPaginate());

        return view('admin.category.subcategory', compact('pageTitle', 'subcategories', 'category', 'emptyMessage'));
    }

    public function formats($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $pageTitle = $subcategory->name.' - File Formats';
        $formats = $subcategory->formats()->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.category.format',compact('pageTitle','formats', 'subcategory','emptyMessage'));
    }

    public function storeFormat(Request $request, $id)
    {

        Validator::extend('alfanum', function($attr, $value){
            return preg_match('/^[\w.-]*$/', $value);
        });

        $request->validate([
            'name' => 'required|alfanum|unique:file_formats,name|max:191',
        ],[
            'name.alfanum' => 'Only alpha numeric value. No space or special char is allowed'
        ]);

        $subcategory = SubCategory::findOrFail($id);

        $format = new FileFormat();
        $format->sub_category_id = $subcategory->id;
        $format->name = $request->name;
        $format->save();

        $notify[] = ['success', 'File Format has been added'];
        return back()->withNotify($notify);
    }

    public function updateFormat(Request $request,$id)
    {
        $format = FileFormat::findOrFail($id);

        Validator::extend('alfanum', function($attr, $value){
            return preg_match('/^[\w.-]*$/', $value);
        });

        $request->validate([
            'name' => 'required|alfanum|unique:file_formats,name|max:191',
        ],[
            'name.alfanum' => 'Only alpha numeric value. No space or special char is allowed'
        ]);

        $format->name = $request->name;
        $format->save();

        $notify[] = ['success', 'File Format has been updated'];
        return back()->withNotify($notify);
    }

    public function searchFormat(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $search = $request->search;

        $pageTitle = 'File Format Search - ' . $search;
        $emptyMessage = 'No data found';

        $formats = $subcategory->formats()->where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.category.format', compact('pageTitle', 'formats', 'subcategory', 'emptyMessage'));
    }
}
