<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CategoriesController extends Controller
{
    public function catSubcatList(Request $request) {
        $data = [
            'pageTitle' => 'Categories & Sub Categories Management'
        ];
        return view('back.pages.admin.cats-subcats-list', $data);
    }

    public function addCategory(Request $request) {
        $data = [
            'pageTitle' => 'Add Category'
        ];
        return view('back.pages.admin.add-category', $data);
    }

    public function storeCategory(Request $request) {
        $request->validate([
            'category_name' => 'required|min:5|unique:categories,category_name',
            'category_image' => 'required|image|mimes:png,jpg,jpeg,svg',
        ], [
            'category_name.required' => ':Attribute is required',
            'category_name.min' => ':Attribute must contains atleast 5 characters',
            'category_name.unique' => 'This :attribute is already exists',
            'category_image.required' => ':Attribute is required',
            'category_image.image' => ':Attribute must be an image',
            'category_image.mimes' => ':Attribute must be in PNG, JPG, JPEG or SVG format'

        ]);

        if($request->hasFile('category_image')) {
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();

            if(!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path));
            }

            $upload = $file->move(public_path($path), $filename);
            if($upload) {
                $category = new Category();
                $category->category_name = $request->category_name;
                $category->category_image = $filename;
                $saved = $category->save();
                if($saved) {
                    return redirect()->route('admin.manage-categories.cat-subcats-list')->with('success', 'Successfully');
                } else {
                    return redirect()->route('admin.manage-categories.add-category')->with('fail', 'Something went wrong');
                }


            } else {
                return redirect()->route('admin.manage-categories.add-category')->with('fail', 'Something went wrong while uploading image');
            }

        }
    }

    public function editCategory(Request $request) {
        $category_id = $request->id;
        $category = Category::findOrFail($category_id);
        $data = [
            'pageTitle' => 'Edit Category',
            'category' => $category
        ];
        return view('back.pages.admin.edit-category', $data);
    }


    public function updateCategory(Request $request) {
        $category_id = $request->category_id;
        $category = Category::findOrFail($category_id);
        // dd($category);

        $request->validate([
            'category_name' => 'required|min:5|unique:categories,category_name,'.$category_id,
            'category_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ], [
            'category_name.required' => ':Attribute is required',
            'category_name.min' => ':Attribute must contains atleast 5 characters',
            'category_name.unique' => 'This :attribute is already exists',
            'category_image.required' => ':Attribute is required',
            'category_image.image' => ':Attribute must be an image',
            'category_image.mimes' => ':Attribute must be in PNG, JPG, JPEG or SVG format'
        ]);

        if($request->hasFile('category_image')) {
            $path = 'images/categories/';
            $file = $request->file('category_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $old_category_image = $category->category_image;

            $upload = $file->move(public_path($path), $filename);
            if($upload) {
                if(File::exists(public_path($path.$old_category_image))) {
                    File::delete(public_path($path.$old_category_image));

                    $category->category_name = $request->category_name;
                    $category->category_image = $filename;
                    $category->category_slug = null;
                    $saved = $category->save();
                    if($saved) {
                        return redirect()->route('admin.manage-categories.cat-subcats-list')->with('success', 'successfully');
                    } else {
                        return redirect()->route('admin.manage-categories.edit-category', ['id'=>$category_id])->with('fail', 'Something went wrong');
                    }
                }
            } else {
                return redirect()->route('admin.manage-categories.edit-category', ['id'=>$category_id])->with('fail', 'Something went wrong while uploading image');
            }
        } else {
            $category->category_name = $request->category_name;
            $category->category_slug = null;
            $saved = $category->save();

            if($saved) {
                return redirect()->route('admin.manage-categories.cat-subcats-list')->with('success', 'successfully');
            } else {
                return redirect()->route('admin.manage-categories.edit-category', ['id'=>$category_id])->with('fail', 'Something went wrong');
            }
        }
    }

    public function subCatList(Request $request) {
        $data = [
            'pageTitle' => 'Sub Categories Management'
        ];
        return view('back.pages.admin.subcats-list', $data);
    }

    public function addSubCategory(Request $request) {
        $independent_subcategories = SubCategory::where('is_child_of', 0)->get();
        $categories =  Category::all();
        $data = [
            'pageTitle' => 'Add SubCategory',
            'categories' => $categories,
            'subcategories' => $independent_subcategories
        ];

        return view('back.pages.admin.add-subcategory', $data);
    }

    public function storeSubCategory(Request $request) {
        $request->validate([
            'parent_category' => 'required|exists:categories,id',
            'subcategory_name' => 'required|min:5|unique:sub_categories,subcategory_name'
        ], [
            'parent_category.required' => ':Attribute is required',
            'parent_category.exists' => ':Attribute is not present in the categories table',
            'subcategory_name.required' => ':Attribute is required',
            'subcategory_name.min' => ':Attribute must contains atleast 5 characters',
            'subcategory_name.unique' => ':Attribute is already exists in the system'
        ]);

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->parent_category;
        $sub_category->subcategory_name = $request->subcategory_name;
        $sub_category->is_child_of = $request->is_child_of;
        $saved = $sub_category->save();

        if($saved) {
            return redirect()->route('admin.manage-categories.add-subcategory')->with('success', 'successfully');
        } else {
            return redirect()->route('admin.manage-categories.add-subcategory')->with('fail', 'Something went wrong');
        }
    }

    public function editSubCategory(Request $request) {
        $subcategory_id = $request->id;
        $subcategory = SubCategory::findOrFail($subcategory_id);
        $independent_subcategories = SubCategory::where('is_child_of', 0)->get();
        $data = [
            'pageTitle' => 'Edit Sub Category',
            'categories' => Category::all(),
            'subcategory' => $subcategory,
            'subcategories' => (!empty($independent_subcategories)) ? $independent_subcategories : []
        ];

        return view('back.pages.admin.edit-subcategory', $data);
    }

    public function updateSubCategory(Request $request) {
        $subcategory_id = $request->subcategory_id;
        $subcategory = SubCategory::findOrFail($subcategory_id);

        $request->validate([
            'parent_category' => 'required|exists:categories,id',
            'subcategory_name' => 'required|min:5|unique:sub_categories,subcategory_name,'.$subcategory_id
        ], [
            'parent_category.required' => ':Attribute is required',
            'parent_category.exists' => ':Attribute is not present in the categories table',
            'subcategory_name.required' => ':Attribute is required',
            'subcategory_name.min' => ':Attribute must contains atleast 5 characters',
            'subcategory_name.unique' => ':Attribute is already exists in the system'
        ]);

        //check if sub category has child category

        if($subcategory->children->count() && $request->is_child_of != 0) {
            return redirect()->route('admin.manage-categories.edit-subcategory', ['id' => $subcategory_id])
                                ->with('fail', 'This sub category has('.$subcategory->children->count().') children.
                                You cannot change "is Child of" option unless you free its children');
        } else {
            $subcategory->category_id = $request->parent_category;
            $subcategory->subcategory_name = $request->subcategory_name;
            $subcategory->subcategory_slug = null;
            $subcategory->is_child_of = $request->is_child_of;
            $saved = $subcategory->save();

            if($saved) {
                return redirect()->route('admin.manage-categories.edit-subcategory', ['id' => $subcategory_id])->with('success', 'successfully');
            } else {
                return redirect()->route('admin.manage-categories.edit-subcategory', ['id' => $subcategory_id])->with('fail', 'Something went wrong');
            }
        }
    }
}
