@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home Page')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Categories Management</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if(Session::get('fail'))
        <div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-3 align-middle text-danger"></i><strong>Error</strong> - {{ Session::get('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Session::get('success'))
        <div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Category Updated</strong> - {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @livewire('admin-categories-subcategories-list')

@endsection

@push('custom-scripts')
    <script>


        $('table tbody#sortable_categories').sortable({
            cursor:"move",
            update:function(event, ui) {
                $(this).children().each(function(index){
                    if($(this).attr("data-ordering") != (index+1)){
                        $(this).attr("data-ordering", (index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                // alert(positions);
                Livewire.dispatch("updateCategoriesOrdering", [positions]);
            }
        });

        $(document).on('click', '.deleteCategoryBtn', function(e) {
            e.preventDefault();
            var category_id = $(this).data('id');
            // alert(category_id);
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this category!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Yes, delete it!",
                allowOutsideClick: false,
            }).then(function (result) {
                // resut.value &&
                //     Swal.fire(
                //         "Deleted!",
                //         "Your file has been deleted.",
                //         "success"
                //     );
                if(result.value) {
                    Livewire.dispatch('deleteCategory', [category_id]);
                }
            });
        });

        $('table tbody#sortable_subcategories').sortable({
            cursor:"move",
            update:function(event, ui) {
                $(this).children().each(function(index){
                    if($(this).attr("data-ordering") != (index+1)){
                        $(this).attr("data-ordering", (index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                // alert(positions);
                Livewire.dispatch("updateSubCategoriesOrdering", [positions]);
            }
        });

        $('ul#sortable_child_subcategories').sortable({
            cursor:"move",
            update:function(event, ui) {
                $(this).children().each(function(index){
                    if($(this).attr("data-ordering") != (index+1)){
                        $(this).attr("data-ordering", (index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                // alert(positions);
                Livewire.dispatch("updateChildSubCategoriesOrdering", [positions]);
            }
        });

        $(document).on('click', '.deleteSubCategoryBtn, .deleteChildSubCategoryBtn', function(e) {
            e.preventDefault();
            var subcategory_id = $(this).data('id');
            // alert(subcategory_id);
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this Sub category!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Yes, delete it!",
                allowOutsideClick: false,
            }).then(function (result) {
                if(result.value) {
                    Livewire.dispatch('deleteSubCategory', [subcategory_id]);
                }
            });
        });

    </script>
@endpush
