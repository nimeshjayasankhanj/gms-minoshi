@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
    rel="stylesheet" />
<link href="{{ URL::asset('assets/css/custom_checkbox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/jquery.notify.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css') }}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}" />


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{ $title }}</h3>
    </li>
</ul>

<div class="clearfix"></div>
</nav>

</div>
<!-- Top Bar End -->

<!-- ==================
     PAGE CONTENT START
     ================== -->

<div class="page-content-wrapper">

    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8">
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal" data-target="#addProductModal">
                                    Add Product</button>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>CATEGORY</th>
                                        <th>PRODUCT NAME</th>
                                        <th>BUYING PRICE</th>
                                        <th>SELLING PRICE</th>
                                        <th>STATUS</th>
                                        <th>EDIT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($productViews))
                                        @if (count($productViews) > 0)


                                            @foreach ($productViews as $productView)
                                                <tr>
                                                    <td>{{ $productView->Category->category_name }}</td>
                                                    <td>{{ $productView->product_name }}</td>
                                                    <td>{{ number_format($productView->buying_price, 2) }}</td>
                                                    <td>{{ number_format($productView->selling_price, 2) }}</td>

                                                    @if ($productView->status == 1)

                                                        <td>
                                                            <p>
                                                                <input type="checkbox" class="status"
                                                                    onchange="adMethod('{{ $productView->idproduct }}','product')"
                                                                    id="{{ 'c' . $productView->idproduct }}" checked
                                                                    switch="none" />
                                                                <label for="{{ 'c' . $productView->idproduct }}"
                                                                    data-on-label="On" data-off-label="Off"></label>
                                                            </p>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <p>
                                                                <input type="checkbox" class="status"
                                                                    onchange="adMethod('{{ $productView->idproduct }}','product')"
                                                                    id="{{ 'c' . $productView->idproduct }}"
                                                                    switch="none" />
                                                                <label for="{{ 'c' . $productView->idproduct }}"
                                                                    data-on-label="On" data-off-label="Off"></label>
                                                            </p>
                                                        </td>
                                                    @endif

                                                    <td>

                                                        <p>
                                                            <button type="button"
                                                                class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $productView->idproduct }}"
                                                                data-name="{{ $productView->idproduct }}"
                                                                id="updateProduct" data-target="#updateProductModal"><i
                                                                    class="fa fa-edit"></i>
                                                            </button>
                                                        </p>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

<!--add modal-->
<div class="modal fade" id="addProductModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Category <span style="color: red"> *</span></label>
                            <select class="form-control select2 tab" name="category" id="category" required>
                                <option value="" disabled selected>Select Category
                                </option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ "$category->idcategory" }}">{{ $category->category_name }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>
                            <span class="text-danger" id="categoryError"></span>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Product Name<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="pName" id="pName" required
                                placeholder="Product Name" />
                            <span class="text-danger" id="pNameError"></span>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Buying Price<span style="color: red"> *</span></label>
                            <input type="number" class="form-control" name="buyingPrice"
                                oninput="this.value = Math.abs(this.value)" id="buyingPrice" required
                                placeholder="0.00" />
                            <span class="text-danger" id="buyingPriceError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Selling Price<span style="color: red"> *</span></label>
                            <input type="number" class="form-control" name="sellingPrice"
                                oninput="this.value = Math.abs(this.value)" id="sellingPrice" required
                                placeholder="0.00" />
                            <span class="text-danger" id="sellingPriceError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" required name="description" id="description"
                            placeholder="Write some description here...."></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4" style="padding-top: 14px">
                        <button type="button" class="btn btn-primary waves-effect " onclick="saveProduct()">
                            Save Product</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--update modal-->
<div class="modal fade" id="updateProductModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Category <span style="color: red"> *</span></label>
                            <select class="form-control select2 tab" name="uCategory" id="uCategory" required>
                                <option value="" disabled selected>Select Category
                                </option>
                                @if (isset($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ "$category->idcategory" }}">{{ $category->category_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="uCategoryError"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Product Name<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="uPName" id="uPName" required
                                placeholder="Product Name" />
                            <span class="text-danger" id="uPNameError"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Buying Price<span style="color: red"> *</span></label>
                            <input type="number" class="form-control" name="uBuyingPrice"
                                oninput="this.value = Math.abs(this.value)" id="uBuyingPrice" required
                                placeholder="0.00" />
                            <span class="text-danger" id="uBuyingPriceError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Selling Price<span style="color: red"> *</span></label>
                            <input type="number" class="form-control" name="sellingPrice"
                                oninput="this.value = Math.abs(this.value)" id="uSellingPrice" required
                                placeholder="0.00" />
                            <span class="text-danger" id="uSellingPriceError"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" required name="uDescription" id="uDescription"
                            placeholder="Write some description here...."></textarea>
                    </div>
                </div>
                <input type="hidden" id="hiddenUItemId">
                <div class="row">
                    <div class="col-lg-4" style="padding-top: 14px">
                        <button type="submit" class="btn btn-warning waves-effect " onclick="updateProduct()">
                            Update Product</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
    type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"
    type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"
    type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js') }}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
    $(document).on("wheel", "input[type=number]", function(e) {
        $(this).blur();
    });

    function adMethod(dataID, tableName) {

        $.post('activateDeactivate', {
            id: dataID,
            table: tableName
        }, function(data) {

        });
    }
    $('.modal').on('hidden.bs.modal', function() {


        $('#errorAlert').hide();
        $('#errorAlert').html('');

        $('#errorAlert1').hide();
        $('#errorAlert1').html('');

        $('#categoryError').html('');
        $('#pNameError').html('');
        $('#measurementError').html('');
        $('#minQtyError').html('');
        $('#maxQtyError').html('');
        $("#buyingPriceError").html("");

        $('#uCategoryError').html('');
        $('#uPNameError').html('');
        $('#uMeasurementError').html('');
        $('#uMinQtyError').html('');
        $('#uMaxQtyError').html('');
        $("#uBuyingPriceError").html("");
        $("#sellingPriceError").html("");
        $("#uSellingPriceError").html("");
        $('input').val('');
        $(".select2").val('').trigger('change');
        $("#expHave").prop("checked", false);

    });



    function saveProduct() {

        $('#categoryError').html("");
        $('#pNameError').html("");
        $('#measurementError').html("");
        $('#minQtyError').html("");
        $('#maxQtyError').html("");
        $("#buyingPriceError").html("");
        $("#sellingPriceError").html("");

        var pName = $("#pName").val();
        var category = $("#category").val();
        var measurement = $("#measurement").val();
        var description = $("#description").val();
        var buyingPrice = $("#buyingPrice").val();
        var minQty = $("#minQty").val();
        var maxQty = $("#maxQty").val();
        var sellingPrice=$("#sellingPrice").val();

        $.post('saveProduct', {
            pName: pName,
            category: category,
            measurement: measurement,
            description: description,
            minQty: minQty,
            maxQty: maxQty,
            buyingPrice: buyingPrice,
            sellingPrice:sellingPrice
        }, function(data) {
           
            if (data.errors != null) {

                if (data.errors.category) {
                    var p = document.getElementById('categoryError');
                    p.innerHTML = data.errors.category;

                }

                if (data.errors.pName) {
                    var p = document.getElementById('pNameError');
                    p.innerHTML = data.errors.pName;

                }

                if (data.errors.buyingPrice) {
                    var p = document.getElementById('buyingPriceError');
                    p.innerHTML = data.errors.buyingPrice;
                }
                if (data.errors.sellingPrice) {
                    var p = document.getElementById('sellingPriceError');
                    p.innerHTML = data.errors.sellingPrice;
                }

            }
            if (data.success != null) {
                $(".select2").val('').trigger('change');
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'PRODUCT SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                    message: data.success,
                });

                $('input').val("");
                $('textarea').val("");
                $(".select2").val('').trigger('change');
                setTimeout(function() {
                    $('#addProductModal').modal('hide');
                }, 200);
                location.reload();
            }
        });
    }


    $(document).on('click', '#viewProduct', function() {
        var productId = $(this).data("id");
        $.post('viewProduct', {
            productId: productId
        }, function(data) {
            $("#dataViewBody").html(data.tableData);
        });
    });
    $(document).on('click', '#updateProduct', function() {
        var productId = $(this).data("id");
        $.post('getProductById', {
            productId: productId
        }, function(data) {
            console.log(data)
            $("#hiddenUItemId").val(data.idproduct);
            $("#uPName").val(data.product_name);
            $("#uBuyingPrice").val(data.buying_price);
            $("#uSellingPrice").val(data.selling_price);
            $("#uCategory").val(data.category_idcategory).trigger('change');
            $("#uDescription").val(data.description)

        });
    });

    function updateProduct() {

        $('#uCategoryError').html("");
        $('#uPNameError').html("");
        $('#uMeasurementError').html("");
        $('#uMinQtyError').html("");
        $('#uMaxQtyError').html("");
        $("#uBuyingPriceError").html("");
        $("#uSellingPriceError").html("");

        var uPName = $("#uPName").val();
        var uCategory = $("#uCategory").val();
        var uMeasurement = $("#uMeasurement").val();
        var uDescription = $("#uDescription").val();
        var uBuyingPrice = $("#uBuyingPrice").val();
        var hiddenUItemId = $("#hiddenUItemId").val();
        var uMinQty = $("#uMinQty").val();
        var uMaxQty = $("#uMaxQty").val();
        var uSellingPrice=$("#uSellingPrice").val();


        $.post('updateProduct', {
            uPName: uPName,
            uCategory: uCategory,
            uMeasurement: uMeasurement,
            uDescription: uDescription,
            uBuyingPrice: uBuyingPrice,
            hiddenUItemId: hiddenUItemId,
            uMinQty: uMinQty,
            uMaxQty: uMaxQty,
            uSellingPrice:uSellingPrice,

        }, function(data) {
            console.log(data)
            if (data.errors != null) {

                if (data.errors.uCategory) {
                    var p = document.getElementById('uCategoryError');
                    p.innerHTML = data.errors.uCategory;

                }

                if (data.errors.uPName) {
                    var p = document.getElementById('uPNameError');
                    p.innerHTML = data.errors.uPName;

                }

                if (data.errors.uMeasurement) {
                    var p = document.getElementById('uMeasurementError');
                    p.innerHTML = data.errors.uMeasurement;

                }

                if (data.errors.uMinQty) {
                    var p = document.getElementById('uMinQtyError');
                    p.innerHTML = data.errors.uMinQty;

                }
                if (data.errors.uMaxQty) {
                    var p = document.getElementById('uMaxQtyError');
                    p.innerHTML = data.errors.uMaxQty;
                }
                if (data.errors.uBuyingPrice) {
                    var p = document.getElementById('uBuyingPriceError');
                    p.innerHTML = data.errors.uBuyingPrice;
                }

            }
            if (data.success != null) {
                $(".select2").val('').trigger('change');
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'PRODUCT UPDATED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                    message: data.success,
                });
                setTimeout(function() {
                    $('#updateProductModal').modal('hide');
                }, 200);
                location.reload();
            }
        });
    }
    $(document).ready(function() {
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });
    });

</script>


@include('includes/footer_end')
