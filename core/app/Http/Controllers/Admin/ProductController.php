<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Products';
        $emptyMessage = 'No product found';
        $products = Product::latest()->with('category')->paginate(getPaginate());
        return view('admin.product.index',compact('pageTitle','products','emptyMessage'));
    }

    public function new()
    {
        $pageTitle = 'Add New Product';

        $categories = Category::where('status','1')->with(['subcategories'=>function($q){
            $q->whereHas('formats')->where('status',1);
        },'subcategories.formats'])->latest()->get();

        return view('admin.product.new',compact('pageTitle','categories'));
    }

    public function store(Request $request)
    {

        $subcategory = SubCategory::where('status',1)->findOrFail($request->sub_category_id);

        $request->validate([
            'image' => ['required',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|max:190',
            'type' => 'required|in:0,1',
            'category_id' => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'file_link' => 'required|in:1,2',
            'link' => 'sometimes|required|url|max:190',
            'file' => ['sometimes','required',new FileTypeValidate($subcategory->formats->pluck('name')->toArray())],
            'price' => 'sometimes|required|numeric|gt:0',
            'info' => 'sometimes|array|min:1',
            'info.*.title' => 'required',
            'info.*.detail' => 'required'
        ]);

        $pImage = null;
        if ($request->hasFile('image')){
            try{
                $location = imagePath()['product']['path'];
                $size = imagePath()['product']['size'];
                $thumb = imagePath()['product']['thumb'];
                $pImage = uploadImage($request->image, $location, $size, '', $thumb);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the image'];
                return back()->withNotify($notify);
            }
        }

        $pFile = null;
        if ($request->hasFile('file')){
            try{
                $location = imagePath()['p_file']['path'];
                $pFile = Str::snake($request->name).'_'.uniqid().time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move($location, $pFile);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the file'];
                return back()->withNotify($notify);
            }
        }

        $product = new Product();
        $product->name = $request->name;
        $product->image = $pImage;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->status = $request->status ? 1:0;
        $product->description = $request->description;
        $product->info = $request->info;
        $product->file = $pFile;
        $product->type = $request->type;
        $product->price = $request->price;
        $product->link = $request->link;
        $product->download = 0;
        $product->save();

        $notify[] = ['success', 'Product added successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $pageTitle = 'Update Product';
        return view('admin.product.edit',compact('pageTitle','product'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => ['nullable',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|max:190',
            'type' => 'required|in:0,1',
            'file_link' => 'required|in:1,2',
            'link' => 'sometimes|required|url|max:190',
            'file' => ['nullable',new FileTypeValidate($product->subcategory->formats->pluck('name')->toArray())],
            'price' => 'sometimes|required|numeric|gt:0',
            'info' => 'sometimes|array|min:1',
            'info.*.title' => 'required',
            'info.*.detail' => 'required'
        ]);


        if ($request->file_link == 1) {
            if ($product->file) {

                $pFile = $product->file;
                if ($request->hasFile('file')){
                    try{
                        $location = imagePath()['p_file']['path'];
                        removeFile($location . '/' . $pFile);
                        $pFile = Str::snake($request->name).'_'.uniqid().time().'.'.$request->file->getClientOriginalExtension();
                        $request->file->move($location, $pFile);

                    }catch(\Exception $exp) {
                        $notify[] = ['error', 'Could not upload the file'];
                        return back()->withNotify($notify);
                    }
                }

            }else{
                $pFile = null;
                if ($request->hasFile('file')){
                    try{
                        $location = imagePath()['p_file']['path'];
                        $pFile = Str::snake($request->name).'_'.uniqid().time().'.'.$request->file->getClientOriginalExtension();
                        $request->file->move($location, $pFile);

                    }catch(\Exception $exp) {
                        $notify[] = ['error', 'Could not upload the file'];
                        return back()->withNotify($notify);
                    }
                }else{
                    $notify[] = ['error', 'You must have to upload a file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($request->file_link == 2) {
            if ($product->file) {

                $pFile = $product->file;
                $location = imagePath()['p_file']['path'];
                removeFile($location . '/' . $pFile);

            }
            $pFile = null;
        }


        $pImage = $product->image;
        if ($request->hasFile('image')){
            try{
                $location = imagePath()['product']['path'];
                $size = imagePath()['product']['size'];
                $thumb = imagePath()['product']['thumb'];
                $pImage = uploadImage($request->image, $location, $size, $product->image, $thumb);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the image'];
                return back()->withNotify($notify);
            }
        }

        $product->name = $request->name;
        $product->image = $pImage;
        $product->status = $request->status ? 1:0;
        $product->description = $request->description;
        $product->info = $request->info;
        $product->file = $pFile;
        $product->type = $request->type;
        $product->price = $request->price;
        $product->link = $request->link;
        $product->save();

        $notify[] = ['success', 'Product updated successfully'];
        return back()->withNotify($notify);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Product Search - ' . $search;
        $emptyMessage = 'No products found';

        $products = Product::where(function($q) use ($search) {
            $q->where('name', 'like',"%$search%")->orWhereHas('category', function($category) use ($search) {
                $category->where('name', 'LIKE', "%$search%");
            })->orWhereHas('subcategory', function($subcategory) use ($search) {
                $subcategory->where('name', 'LIKE', "%$search%");
            });
        })->with('category')->paginate(getPaginate());

        return view('admin.product.index', compact('pageTitle', 'products', 'emptyMessage'));
    }
}
