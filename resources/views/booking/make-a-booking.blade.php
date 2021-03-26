@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
    rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}"
    rel="stylesheet" />
<link href="{{ URL::asset('assets/css/custom_checkbox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/jquery.notify.css') }}" rel="stylesheet" type="text/css">

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
        <div class="row">
            <div class="col-lg-8">

                <div class="card m-b-20" id="normalArea">
                    <form method="post" enctype="multipart/form-data" action="{{ route('saveTempInvProduct') }}"
                        id="tempProductId">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Product<span
                                                style="color: red"> *</span></label>
                                        <select class="form-control select2 tab" name="product"
                                            onchange="getProductPrice(this.value);getAvailableQty(this.value)"
                                            id="product">
                                            <option value="" disabled selected>Select Product
                                            </option>
                                            @if (isset($products))
                                                @foreach ($products as $product)
                                                    <option value="{{ "$product->idproduct" }}">
                                                        {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger" id="productError"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Price(1 Qty)</label>

                                        <input type="number" class="form-control" name="cPrice" id="cPrice" disabled
                                            placeholder="0.00" />

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Available Qty<span
                                                style="color: red"> *</span></label>

                                        <input type="number" class="form-control" readonly name="availableQty"
                                            id="availableQty" placeholder="0.00" />
                                        <small class="text-danger" id="cPriceError"></small>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Qty<span
                                                style="color: red"> *</span></label>

                                        <input type="number" class="form-control" name="qty" id="qty"
                                            oninput="this.value = Math.abs(this.value);uMaxQty()" placeholder="0.00" />
                                        <small class="text-danger" id="cPriceError"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding-top: 34px">
                                    <button type="submit" class="btn btn-primary">
                                        Add Product</button>

                                </div>
                            </div>
                    </form>


                    <br>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="" class="table table-striped table-bordered data-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>PRODUCT NAME</th>
                                        <th>QTY</th>
                                        <th style="text-align: right">TOTAL</th>
                                        <th>DELETE</th>
                                        <th>EDIT</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="row" id="bookingButton" style="margin-top: 20px">

                        <div class="col-lg-4">
                            <button type="button" onclick="saveBooking()" class="btn btn-primary" id="saveBookingBtn">
                                Save Invoice</button>

                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <img src="{{ URL::asset('assets/images/Royal Laundry.png') }}" style=" display: block;
                                margin-left: auto;
                                margin-right: auto;" height="70" alt="logo">
                        </div>
                    </div>
                    <br>
                    <p style="text-align: center">No 566/7/A,Aldeniya,Kadawatha,<br>Sri Lanka</p>
                    <hr>
                    <div class="row" id="priceArea">

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--update modal-->

    <div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <form class="" method="post" enctype="multipart/form-data"
                        action="{{ route('editTempBooking') }}" id="editTempBookingId">
                        {{ csrf_field() }}


                        <div class="form-group" id="CategoryView">
                            <label for="example-text-input" class="col-form-label">Product<span style="color: red">
                                    *</span></label>
                            <select class="form-control select2 tab" name="uProduct"
                                onchange="getProductPrice(this.value)" id="uProduct">
                                <option value="" disabled selected>Select Product
                                </option>
                                @if (isset($products))
                                    @foreach ($products as $product)
                                        <option value="{{ "$product->idproduct" }}">
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger" id="uProductError"></small>
                        </div>


                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Qty<span style="color: red">
                                    *</span></label>

                            <input type="number" class="form-control" name="uQty" id="uQty" placeholder="0.00" />
                            <small class="text-danger" id="uQtyError"></small>
                        </div>

                        <input type="hidden" id="hiddenTempId" name="hiddenTempId">
                        <button type="submit" class="btn btn-warning">
                            Update Product</button>
                    </form>
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
        type="text/javascript">
    </script>
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

            tableData();
        });
        $(document).on("wheel", "input[type=number]", function(e) {
            $(this).blur();
        });

        function adMethod(dataID, tableName) {

            $.post('changeStatus', {
                id: dataID,
                table: tableName
            }, function(data) {

            });
        }
        $('.modal').on('hidden.bs.modal', function() {


            $("#productError").html('');
            $("#uProductError").html('');

            $("#cPriceError").html('');
            $("#cPriceError").html('');
            $('input').val('');
            $(".select2").val('').trigger('change');
        });

        function getProductPrice(productID) {
            $.post('getProductPrice', {
                productID: productID
            }, function(data) {

                $("#cPrice").val(data.selling_price);
            })
        }

        function getAvailableQty(itemId) {

            $.post('getAvailableQty', {
                itemId: itemId
            }, function(data) {
                console.log(data)
                if (data != null) {
                    $("#availableQty").val(data);
                }

            })
        }

        function uMaxQty() {


            var qtyProduct = parseFloat($('#qty').val());
            var availableQty = parseFloat($('#availableQty').val());

            if (qtyProduct > availableQty) {
                $('#qty').val(availableQty);
                qtyProduct = availableQty;

            }

        }


        function tableData() {

            $.post('tableData', {

            }, function(data) {
                if (data.total == 0) {
                    $("#bookingButton").hide();
                } else {
                    $("#bookingButton").show();
                }

                $("tbody").html(data.tableData)
                $("#priceArea").html(data.tableData2)
            })
        }


        //save temo booking
        $("#tempProductId").on("submit", function(event) {


            $("#productError").html('');
            $("#cPriceError").html('');

            event.preventDefault();

            $.ajax({
                url: '{{ route('saveTempBookingInvProduct') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data)
                    if (data.errors != null) {
                        if (data.errors.product) {
                            var p = document.getElementById('productError');
                            p.innerHTML = data.errors.product[0];
                        }
                        if (data.errors.qty) {
                            var p = document.getElementById('cPriceError');
                            p.innerHTML = data.errors.qty[0];
                        }
                    }
                    if (data.success != null) {
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
                        $('input').val('');
                        $(".select2").val('').trigger('change');
                        tableData();
                    }
                }
            });
        });






        //set edit values
        $(document).on('click', '#uTempID', function() {
            var categoryId = $(this).data("id");
            var qty = $(this).data("qty");
            var product = $(this).data("product");

            $("#uProduct").val(product).trigger('change');
            $("#hiddenTempId").val(categoryId);
            $("#uQty").val(qty);
        });



        //delete temp booking      
        $(document).on('click', '#deleteId', function() {
            var tempId = $(this).data("id");

            $.post('deleteTempBooking', {
                tempId: tempId
            }, function(data) {
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'PRODUCT DELETED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });
                    $("tbody").html(data.tableData);
                    tableData();
                }
            })
        });


        //edit temp booking
        $("#editTempBookingId").on("submit", function(event) {

            $("#uProductError").html('');
            event.preventDefault();

            $.ajax({
                url: '{{ route('editTempBooking') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {

                    console.log(data)
                    if (data.errors != null) {
                        if (data.errors.uCategory) {
                            var p = document.getElementById('uProductError');
                            p.innerHTML = data.errors.uCategory[0];
                        }
                        if (data.errors.uQty) {
                            var p = document.getElementById('uQtyError');
                            p.innerHTML = data.errors.uQty[0];
                        }

                    }

                    if (data.success != null) {
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

                            $('#updateCategoryModal').modal('hide');
                        }, 200);
                        $('input').val('');
                        $(".select2").val('').trigger('change');
                        tableData();
                    }
                }
            });
        });

        $(document).on('click', '#uCategoryPriceID', function() {
            var categoryId = $(this).data("id");
            var category = $(this).data("category");
            var categoryPrice = $(this).data("price");

            $("#hiddenUCatId").val(categoryId);
            $("#uCategory").val(category).trigger('change');
            $("#uCPrice").val(categoryPrice);

        });


        function saveBooking() {

            $.post('saveBooking', {

            }, function(data) {
                console.log(data)
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'INVOICE SAVED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });

                    tableData();

                }

            })
        }

        $(document).ready(function() {
            $(document).on('focus', ':input', function() {
                $(this).attr('autocomplete', 'off');
            });
        });

    </script>


    @include('includes/footer_end')
