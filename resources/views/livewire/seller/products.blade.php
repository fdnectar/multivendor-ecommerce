<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('seller.product.add-product') }}" class="btn btn-primary waves-effect waves-light">Add Product</a>
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
                                                aria-label="Name: activate to sort column descending">Product Image</th>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable"
                                                rowspan="1" colspan="1" style="width: 186.2px;" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Product Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 279.2px;"
                                                aria-label="Position: activate to sort column ascending">Product Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 279.2px;"
                                                aria-label="Position: activate to sort column ascending">Compare Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                                colspan="1" style="width: 136.2px;"
                                                aria-label="Office: activate to sort column ascending">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="sortable_categories">
                                        @forelse ($products as $product)
                                            <tr class="odd">
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    <img src="/images/products/{{ $product->product_image }}" alt="" class="rounded avatar-md">
                                                </td>
                                                <td class="" style="">{{ $product->product_name }}</td>
                                                <td class="" style="">{{ $product->product_price }}</td>
                                                <td class="" style="">{{ $product->compare_price }}</td>
                                                <td class="" style="">
                                                    <a href="{{ route('seller.product.edit-product', ['id' => $product->id]) }}" class="text-primary">
                                                        <i class="mdi mdi-square-edit-outline" style="font-size: 25px"></i>
                                                    </a>
                                                    <a href="javascript:;" class="text-danger" id="deleteProductBtn" data-id="{{ $product->id }}">
                                                        <i class="mdi mdi-delete" style="font-size: 25px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <span class="text-danger">No Product Found...</span>
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
