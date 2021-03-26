@include('includes.header_start')


<!-- DataTables -->
<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}"
      rel="stylesheet"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css">


@include('includes.header_end')

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
        <div class="col-md-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible " id="errorAlert" style="display:none">

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product<span style="color: red"> *</span></label>
                                <select class="form-control select2 tab"
                                        onchange="getProductPrice(this.value);"
                                        name="item"
                                        id="item" required>
                                    <option value="" disabled selected>Select Product
                                    </option>
                                    @if(isset($products))
                                        @foreach($products as $product)
                                            <option value="{{"$product->idproduct"}}">
                                                 {{"$product->product_name"}} </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Buying Price <span style="color: red"> *</span></label>
                            <input type="number" class="form-control tab"
                                   name="bPrice"
                                   id="bPrice" min="0" oninput="this.value = Math.abs(this.value)"
                                   placeholder="0.00"/>
                            <small class="text-danger">{{ $errors->first('sPrice') }}</small>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qty <span style="color: red"> *</span></label>
                                <input type="number" class="form-control tab" name="qtyGrn" id="qtyGrn" min="0"
                                       oninput="this.value = Math.abs(this.value)"
                                       placeholder="0"/>
                                <small id="qtyMsg" class="text-danger">{{ $errors->first('qtyGrn') }}</small>
                            </div>
                        </div>

                    </div>
                    <div class="row">


                        <div class="col-md-2" >
                            <button onclick="addPO()" type="button" class="btn btn-primary waves-effect" > Add to Table</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>PRODUCT NAME</th>
                                    <th>QTY</th>
                                    <th style="text-align: right;">BUYING PRICE</th>
                                    <th style="text-align: right;">TOTAL PRICE</th>
                                    <th style="text-align: center">OPTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-10"></div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-md btn-primary waves-effect float-right"
                                    data-toggle="modal"  data-target="#addPOModal" id="savePOButton">
                                    Select Supplier</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPOModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Save Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert1" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
               
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Supplier<span style="color: red"> *</span></label>
                    <select class="form-control select2 tab"
                            name="supplier"
                            id="supplier" required>
                        <option value="" disabled selected>Select Supplier
                        </option>
                        @if(isset($suppliers))
                            @foreach($suppliers as $supplier)
                                <option value="{{"$supplier->idsupplier"}}">
                                    {{"$supplier->company_name"}} </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <button type="button" class="btn btn-primary waves-effect "
                        onclick="savePO()" >
                    Save PO</button>
            </div>
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="editProductModal"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert2" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <input type="hidden" id="poId"/>
                        <div class="form-group">
                            <label>Product</label>
                            <select class="form-control select2 "
                                    onchange="uGetProductPrice(this.value);"
                                    name="uItem"
                                    id="uItem" required>
                                <option value="" disabled selected>Select Product
                                </option>

                                @if(isset($products))
                                    @foreach($products as $product)
                                        <option value="{{"$product->idproduct"}}">
                                           {{"$product->product_name"}} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Buying Price</label>
                        <input type="number" class="form-control tab"
                               name="uBPrice"
                               id="uBPrice" min="0" oninput="this.value = Math.abs(this.value)"
                               placeholder="0.00"/>
                        <small class="text-danger">{{ $errors->first('sPrice') }}</small>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" class="form-control tab" name="uQty" id="uQty" min="0"
                                   oninput="this.value = Math.abs(this.value)"
                                   placeholder="0.00"/>
                            <small id="qtyMsg" class="text-danger">{{ $errors->first('qtyGrn') }}</small>
                        </div>
                    </div>

                </div>
                <div class="row">


                    <div class="col-md-2" >
                        <button onclick="updatePO()" type="button" class="btn btn-md btn-warning waves-effect" >Update Product</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery('.datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        showPOTable();

    });

    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });

    $('.modal').on('hidden.bs.modal', function () {

        $('#errorAlert').hide();
        $('#errorAlert').html('');
        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $("input").val('');
        $(".select2").val('').trigger('change');
    });

    function getProduct(categoryId){

        $.post('getProducts',{
            categoryId:categoryId,
        },function (data) {
            $("#bPrice").val('');
            $("#item").html(data);

        });
    }
    function uGetProduct(categoryId){

        var uCategory=$("#uCategory").val();
        var proSet=$("#proSet").val();

        if(proSet!=uCategory){
            $.post('getProducts',{
                categoryId:categoryId,
            },function (data) {
                $("#bPrice").val('');
                $("#uItem").html(data);

            });
        }

    }


    function showPOTable() {
        if (!$('#defaultChecked2').prop('checked')) {
            $('#defaultChecked2').click().prop('checked', true);
        }
        $.ajax({

            type: 'post',

            url: 'getPOTempTableData',

            data: {},

            success: function (data) {

                if (data.total > 0) {
                    $("#total").val(data.total.toFixed(2));
                    $('#savePOButton').show();
                }
                else {
                    $('#savePOButton').hide();
                }

                $('tbody').html(data.tableData);


            }

        });
    }



    function getProductPrice(productId) {
        $.post('getProductById', {
            productId: productId,
        }, function (data) {
            if(data!=0){
                $("#bPrice").val(data.buying_price);
            }
        })
    }

    function uGetProductPrice(productId) {
        $.post('getProductById', {
            productId: productId,
        }, function (data) {
            if(data!=0){
                $("#bPrice").val(data.buying_price);
            }
        })
    }



    function addPO() {

        $('#errorAlert').hide();
        $('#errorAlert').html("");

        var category = $("#category").val();
        var item = $("#item").val();
        var qtyGrn = $("#qtyGrn").val();
        var bPrice=$("#bPrice").val();


        $.post('saveTempPO', {
            category:category,
            item: item,
            qtyGrn: qtyGrn,
            bPrice:bPrice

        }, function (data) {

            if (data.errors != null) {
                $('#errorAlert').show();
                $.each(data.errors, function (key, value) {
                    $('#errorAlert').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {

                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'ADDED TO TABLE',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                    message: data.success,
                });

                $('input').val('');
                $(".select2").val('').trigger('change');
            }
            showPOTable();
        });
    }

     

    $(document).on('click', '#deletePO', function () {
        var poId = $(this).data("id");
        $.post('deleteTempPO', {poId: poId}, function (data) {
            notify({
                type: "success", //alert | success | error | warning | info
                title: 'PO DELETED',
                autoHide: true, //true | false
                delay: 2500, //number ms
                position: {
                    x: "right",
                    y: "top"
                },
                icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                message: data.success,
            });
            showPOTable();
        });
    });


    function savePO() {

        $('#errorAlert1').hide();
        $('#errorAlert1').html("");

        var supplier = $("#supplier").val();

        $.post('savePO', {
       
            supplier: supplier,

        }, function (data) {

            if (data.errors != null) {
                $('#errorAlert1').show();
                $('#errorAlert1').show().scrollTop(0);
                $.each(data.errors, function (key, value) {
                    $('#errorAlert1').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {

                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'PO SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                    message: data.success,
                });


                $('#addPOModal').modal('hide');

                showPOTable();
            }

        })

    }

    $(document).on('click', '#editProduct', function () {
        var poId = $(this).data("id");
       
        $.post('getPOByID', {poId: poId}, function (data) {
            console.log(data)
            $("#poId").val(data.idpo_tempory);
            $("#uItem").val(data.product_idproduct).trigger('change');
            $('#uBPrice').val(data.bp);
            $('#uQty').val(data.qty);

        });
    });

    $(document).ready(function () {
        $(document).on('focus', ':input', function () {
            $(this).attr('autocomplete', 'off');
        });
    });


</script>


@include('includes.footer_end')