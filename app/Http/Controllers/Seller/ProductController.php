<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Rules\validatePrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $data = [
            'pageTitle' => 'Add Product',
            'categories' => Category::orderBy('category_name', 'asc')->get()
        ];

        return view('back.pages.seller.add-product', $data);
    }

    public function getProductcategory(Request $request) {
        $category_id = $request->category_id;
        $category = Category::findOrFail($category_id);
        $subcategories = SubCategory::where('category_id', $category_id)
                                  ->where('is_child_of', 0)
                                  ->orderBy('subcategory_name', 'asc')
                                  ->get();

        $html = '';
        foreach($subcategories as $value) {
            $html.='<option value="'.$value->id.'">'.$value->subcategory_name.'</option>';
            if(count($value->children) > 0) {
                foreach($value->children as $child) {
                    $html.='<option value="'.$child->id.'">-- '.$child->subcategory_name.'</option>';
                }
            }
        }
        return response()->json(['status' => 1, 'data' => $html]);
    }

    public function createProduct(Request $request) {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'product_summary' => 'required|min:100',
            'product_image' => 'required|mimes:jpg,jpeg,png|max:1024',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:sub_categories,id',
            'product_price' => ['required', new validatePrice],
            'compare_price' => ['nullable', new validatePrice],
        ], [
            'product_name.required' => 'Enter product name',
            'product_name.unique' => 'This product name is already taken',
            'product_summary.required' => 'Write summary for this product',
            'product_image.required' => 'Choose image for this product',
            'category.required' => 'Select product category',
            'subcategory.required' => 'Select product sub category',
            'product_price.required' => 'Enter product price'
        ]);

        //To validate price and compare price we have to create custom rule validation
        $product_image = null;
        if($request->hasFile('product_image')) {
            $path = 'images/products/';
            $file = $request->file('product_image');
            $filename = 'PIMG_'.time().uniqid().'.'.$file->getClientOriginalExtension();
            $upload = $file->move(public_path($path), $filename);

            if($upload) {
                $product_image = $filename;
            }
        }

        $product = new Product();
        $product->user_type = 'seller';
        $product->seller_id = auth('seller')->id();
        $product->product_name = $request->product_name;
        $product->product_summary = $request->product_summary;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->subcategory;
        $product->product_price = $request->product_price;
        $product->compare_price = $request->compare_price;
        $product->visibility = $request->visibility;
        $product->product_image = $product_image;
        $saved = $product->save();
        if($saved) {
            return response()->json(['status' => 1, 'msg' => 'Product Added Successfully']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
        }

    }

    public function allProductList(Request $request) {
        $data = [
            'pageTitle' => 'All Products'
        ];
        return view('back.pages.seller.all-products', $data);
    }

    public function editProduct(Request $request) {
        $product_id = $request->id;
        $product = Product::findOrFail($product_id);
        $categories = Category::orderBy('category_name', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)
                                  ->where('is_child_of', 0)
                                  ->orderBy('subcategory_name', 'asc')
                                  ->get();
        $data = [
            'pagetTitle' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'subcategories' => $subcategories
        ];

        return view('back.pages.seller.edit-product', $data);
    }

    public function updateProduct(Request $request) {
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);
        $product_image = $product->product_image;

        $request->validate([
            'product_name' => 'required|unique:products,product_name,'.$product->id,
            'product_summary' => 'required|min:100',
            'product_image' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            'subcategory' => 'required|exists:sub_categories,id',
            'product_price' => ['required', new validatePrice],
            'compare_price' => ['nullable', new validatePrice],
        ], [
            'product_name.required' => 'Enter product name',
            'product_name.unique' => 'This product name is already taken',
            'product_summary.required' => 'Write summary for this product',
            'subcategory.required' => 'Select product sub category',
            'product_price.required' => 'Enter product price'
        ]);

        if($request->hasFile('product_image')) {
            $path = 'images/products/';
            $file = $request->file('product_image');
            $filename = 'PIMG_'.time().uniqid().'.'.$file->getClientOriginalExtension();
            $old_product_image = $product->product_image;

            $upload = $file->move(public_path($path), $filename);


            if($upload) {
                if(File::exists(public_path($path.$old_product_image))) {
                    File::delete(public_path($path.$old_product_image));
                }

                $product_image = $filename;
            }
        }

        $product->product_name = $request->product_name;
        $product->slug = null;
        $product->product_summary = $request->product_summary;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->subcategory;
        $product->product_price = $request->product_price;
        $product->compare_price = $request->compare_price;
        $product->visibility = $request->visibility;
        $product->product_image = $product_image;
        $updated = $product->save();

        if($updated) {
            return response()->json(['status' => 1, 'msg' => 'Product Updated Successfully']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function uploadProductImages(Request $request) {
        $product = Product::findOrFail($request->product_id);
        $path = 'images/products/additionals/';
        $file = $request->file('file');
        $filename = 'APIMG_'.$product->id.time().uniqid().'.'.$file->getClientOriginalExtension();

        $file->move(public_path($path), $filename);

        //resize image using intervention
        // $maxWidth = 1080;
        // $maxHeight = 1080;
        // $full_path = $path.$filename;
        // $image = Image::make($file->path());

        // $image->height() > $image->width() ? $maxWidth = null : $maxHeight = null;
        // $image->fit($maxWidth, $maxHeight, function($constraint) {
        //     $constraint->upsize();
        // });
        // $image->save($full_path);

        $pimage = new ProductImage();
        $pimage->product_id = $product->id;
        $pimage->image = $filename;
        $pimage->save();
    }

    public function getProductImages(Request $request) {
        $product = Product::with('images')->findOrFail($request->product_id);
        $path = "images/products/additionals/";
        $html = "";
        if($product->images->count() > 0) {
            foreach($product->images as $item) {
                $html.='<div class="box">
                            <img src="/'.$path.$item->image.'" alt="">
                            <a href="javascript:;" data-image="'.$item->id.'" class="btn btn-danger btn-sm" id="deleteProductImage">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>';
            }
        } else {
            $html = '<span class="text-danger">No image(s)</span>';
        }
        return response()->json(['status'=>1, 'data'=>$html]);
    }

    //addtional image delete
    public function deleteProductImage(Request $request) {
        $product_image = ProductImage::findOrFail($request->image_id);
        $path = "images/products/additionals/";

        if($product_image->image != null && File::exists(public_path($path.$product_image->image))) {
            File::delete(public_path($path.$product_image->image));
        }

        $delete = $product_image->delete();
        if($delete) {
            return response()->json(['status'=>1, 'msg'=>'Product image deleted successfully']);
        } else {
            return response()->json(['status'=>0, 'msg'=>'Something went wrong']);
        }
    }

    public function deleteProduct(Request $request) {
        $product = Product::with('images')->findOrFail($request->product_id);

        //check if it has additional images
        if($product->images->count() > 1) {
            $images_path = 'images/products/additionals/';
            foreach($product->images as $item) {
                if($item->image != null && File::exists(public_path($images_path.$item->image))) {
                    File::delete(public_path($images_path.$item->image));
                }
                $pimage = ProductImage::findOrFail($item->id);
                $pimage->delete();
            }
        }

        //Delete actual product
        $path = 'images/products/';
        $product_image = $product->product_image;
        if($product_image != null && File::exists(public_path($path.$product_image))) {
            File::delete(public_path($path.$product_image));
        }
        $delete = $product->delete();
        if($delete) {
            return response()->json(['status'=>1, 'msg'=>'Product deleted successfully']);
        } else {
            return response()->json(['status'=>0, 'msg'=>'Something went wrong']);
        }
    }
}
