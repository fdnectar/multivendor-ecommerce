<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;

class AdminCategoriesSubCategoriesList extends Component
{
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory',
        'updateSubCategoriesOrdering',
        'updateChildSubCategoriesOrdering',
        'deleteSubCategory'
    ];

    public function updateCategoriesOrdering($positions) {
        foreach($positions as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id', $index)->update([
                'ordering' => $newPosition
            ]);

            $this->showToaster('success', 'Categories Ordering updated successfully');
        }
    }

    public function updateSubCategoriesOrdering($positions) {
        foreach($positions as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            SubCategory::where('id', $index)->update([
                'ordering' => $newPosition
            ]);

            $this->showToaster('success', 'Sub Categories Ordering updated successfully');
        }
    }

    public function updateChildSubCategoriesOrdering($positions) {
        foreach($positions as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            SubCategory::where('id', $index)->update([
                'ordering' => $newPosition
            ]);

            $this->showToaster('success', 'Child Sub Categories Ordering updated successfully');
        }
    }

    public function deleteCategory($category_id) {
        // dd($category_id);
        $category = Category::findOrFail($category_id);
        $path = 'images/categories/';
        $category_image = $category->category_image;

        //CHECK IF HAVE SUB CATEGORY
        if($category->subcategories->count() > 0) {
            // check if some of these subcategories has related products

            // Delete sub category
            foreach($category->subcategories as $subcategory) {
                $subcategory = SubCategory::findOrFail($subcategory->id);
                $subcategory->delete();
            }
        }

        //DELETE CATEGORY IMAGE
        if(File::exists(public_path($path.$category_image))) {
            File::delete(public_path($path.$category_image));
        }

        //DELETE CATEGORY FROM DB
        $delete = $category->delete();

        if($delete) {
            $this->showToaster('success', 'Category deleted successfully');
        } else {
            $this->showToaster('danger', 'Something went wrong');
        }
    }

    public function deleteSubCategory($subcategory_id) {
        // dd($subcategory_id);
        $subcategory = SubCategory::findOrFail($subcategory_id);

        if($subcategory->children->count() > 0) {
            //check if products related to one of childs sub categories

            //If no products then delete sub category
            foreach($subcategory->children as $child) {
                SubCategory::where('id', $child->id)->delete();
            }

            $subcategory->delete();
            $this->showToaster('success', 'Sub Category deleted successfully');
        } else {
            //check if sub category has product related to it


            //Delete the sub category if no product
            $subcategory->delete();
            $this->showToaster('success', 'Sub Category deleted successfully');
        }
    }

    public function showToaster($type, $message) {
        return $this->dispatch('showToaster',[
            'type' => $type,
            'message' => $message
        ]);

    }

    public function render()
    {
        $data = [
            'categories' => Category::orderBy('ordering', 'asc')->get(),
            'subcategories' => SubCategory::where('is_child_of', 0)->orderBy('ordering', 'asc')->get()
        ];
        // dd($data['subcategories']);
        return view('livewire.admin-categories-sub-categories-list', $data);
    }
}
