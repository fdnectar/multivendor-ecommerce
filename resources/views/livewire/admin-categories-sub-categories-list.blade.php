<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.manage-categories.add-category') }}" class="btn btn-primary waves-effect waves-light">Add Category</a>
                </div>
                <div class="card-body">

                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="datatable"
                                    class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline"
                                    aria-describedby="datatable_info" style="width: 1169px;">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable"
                                                rowspan="1" colspan="1" style="width: 186.2px;" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Category Image</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable"
                                                rowspan="1" colspan="1" style="width: 186.2px;" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Category Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 279.2px;"
                                                aria-label="Position: activate to sort column ascending">N.of Sub Categories</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 136.2px;"
                                                aria-label="Office: activate to sort column ascending">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="sortable_categories">
                                        @forelse ($categories as $value)
                                            <tr class="odd" data-index="{{ $value->id }}" data-ordering="{{ $value->ordering }}">
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    <img src="/images/categories/{{ $value->category_image }}" alt="" class="rounded avatar-md">
                                                </td>
                                                <td class="" style="">{{ $value->category_name }}</td>
                                                <td class="" style="">{{ $value->subCategories->count() }}</td>
                                                <td class="" style="">
                                                    <a href="{{ route('admin.manage-categories.edit-category', ['id' => $value->id]) }}" class="text-primary">
                                                        <i class="mdi mdi-square-edit-outline" style="font-size: 25px"></i>
                                                    </a>
                                                    <a href="javascript:;" class="text-danger deleteCategoryBtn" data-id="{{ $value->id }}">
                                                        <i class="mdi mdi-delete" style="font-size: 25px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <span class="text-danger">No Category Found...</span>
                                                </td>
                                            </tr>

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.manage-categories.add-subcategory') }}" class="btn btn-primary waves-effect waves-light">Add Sub Category</a>
                </div>
                <div class="card-body">

                    <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="sub-cat-datatable"
                                    class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline"
                                    aria-describedby="datatable_info" style="width: 1169px;">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable"
                                                rowspan="1" colspan="1" style="width: 186.2px;"
                                                aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Sub Category Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 279.2px;"
                                                aria-label="Position: activate to sort column ascending">Category Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 136.2px;"
                                                aria-label="Office: activate to sort column ascending">Child Sub Categories</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 136.2px;"
                                                aria-label="Office: activate to sort column ascending">N. of Childs Subs.</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 65.2px;"
                                                aria-label="Age: activate to sort column ascending">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="sortable_subcategories">
                                        @forelse ($subcategories as $value)
                                            <tr class="odd" data-index="{{ $value->id }}" data-ordering="{{ $value->ordering }}">
                                                <td class="dtr-control sorting_1" tabindex="0">{{ $value->subcategory_name }}</td>
                                                <td class="" style="">{{ $value->parentCategory->category_name }}</td>
                                                <td class="" style="">
                                                    @if ($value->children->count() > 0)
                                                        <ul class="list-group" id="sortable_child_subcategories">
                                                            @foreach ($value->children as $child)
                                                                <li class="d-flex justify-content-between align-items-center" data-index="{{ $child->id }}" data-ordering="{{ $child->ordering }}">
                                                                    - {{ $child->subcategory_name }}
                                                                    <div>
                                                                        <a href="{{ route('admin.manage-categories.edit-subcategory', ['id' =>$child->id]) }}" class="text-primary" data-toggle="tooltip" title="Edit">
                                                                            Edit
                                                                        </a>
                                                                        |
                                                                        <a href="javascript:;" data-id="{{ $child->id }}" data-title="Child sub category" class="text-danger deleteChildSubCategoryBtn" data-toggle="tooltip" title="Delete">
                                                                            Delete
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        None
                                                    @endif
                                                </td>
                                                <td class="" style="">{{ $value->children->count() }}</td>
                                                <td class="" style="">
                                                    <a href="{{ route('admin.manage-categories.edit-subcategory', ['id' =>$value->id]) }}" class="text-primary">
                                                        <i class="mdi mdi-square-edit-outline" style="font-size: 25px"></i>
                                                    </a>
                                                    <a href="javascript:;" data-id="{{ $value->id }}" data-title="Delete SubCategory" class="text-danger deleteSubCategoryBtn">
                                                        <i class="mdi mdi-delete" style="font-size: 25px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">
                                                <span class="text-danger">No SubCategory Found...</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
