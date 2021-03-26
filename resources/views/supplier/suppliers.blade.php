@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}"/>


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
                        <div class="col-lg-6 form-group" style="padding-top: 6px">
                           
                        </div>
                        <div class="col-lg-2">
                         
                        </div>
                        <div class="col-lg-4 form-group">
                            <button type="button" class="btn btn-primary waves-effect float-right"
                                    data-toggle="modal"  data-target="#addSupplier" >
                                Add Supplier</button>
                        </div>
                    </div>


                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable"   class="table table-striped table-bordered"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>SUPPLIER NAME</th>
                                    <th>ADDRESS</th>
                                    <th>CONTACT NO</th>
                                    <th>EMAIL</th>
                                    <th>STATUS</th>
                                    <th>EDIT</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($suppliers))
                                    @if(count($suppliers)>0)
                                       
                                    @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>{{$supplier->company_name}}</td>
                                            <td>{{$supplier->address}}</td>
                                            <td>{{$supplier->contact_no}}</td>
                                            <td>{{$supplier->email}}</td>
                                          
                                            @if($supplier->status == 1)

                                                <td>
                                                    <p>
                                                        <input type="checkbox"
                                                               onchange="adMethod('{{ $supplier->idsupplier}}','supplier')"
                                                               id="{{"c".$supplier->idsupplier}}" checked
                                                               switch="none"/>
                                                        <label for="{{"c".$supplier->idsupplier}}"
                                                               data-on-label="On"
                                                               data-off-label="Off"></label>
                                                    </p>
                                                </td>
                                            @else
                                                <td>
                                                    <p>
                                                        <input type="checkbox"
                                                               onchange="adMethod('{{ $supplier->idsupplier}}','supplier')"
                                                               id="{{"c".$supplier->idsupplier}}"
                                                               switch="none"/>
                                                        <label for="{{"c".$supplier->idsupplier}}"
                                                               data-on-label="On"
                                                               data-off-label="Off"></label>
                                                    </p>
                                                </td>
                                            @endif
                                            <td>

                                                <p>
                                                    <button type="button"
                                                            class="btn btn-sm btn-warning  waves-effect waves-light"
                                                            data-toggle="modal"
                                                            data-id="{{ $supplier->idsupplier}}"
                                                           id="uSupplierId"
                                                            data-target="#updateSupplier"><i
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
    </div>
</div>


<!--add supplier model-->
<div class="modal fade" id="addSupplier" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Supplier</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert" style="display:none">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="example-text-input" class="col-form-label">Supplier Name<span style="color: red"> *</span></label>
                        <input type="text" class="form-control" name="supplierName"
                               id="supplierName" required placeholder="Supplier Name"/>
                    </div>
                    <div class="col-lg-6">

                        <label for="example-text-input" class="col-form-label">Contact No<span style="color: red"> *</span></label>
                        <input type="number" class="form-control" name="contactNo1" oninput="this.value = Math.abs(this.value)"
                               id="contactNo1" required placeholder="(+94) XXX XXXXXX"/>

                    </div>
                </div>
               
                <div class="row">
                    <div class="col-lg-12">
                        <label for="example-text-input" class="col-form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                               id="email" required placeholder="abc@gmail.com"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label for="example-text-input" class="col-form-label">Address</label>
                        <input type="text" class="form-control" name="address"
                               id="address" required placeholder="Address"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ">
                        <button type="button" class="btn btn-primary waves-effect "
                                onclick="saveSupplier()" >
                            Save Supplier</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!--update supplier-->
<div class="modal fade" id="updateSupplier" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " id="errorAlert1" style="display:none">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Supplier Name<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="uSupplierName"
                                   id="uSupplierName" required placeholder="Supplier Name"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Contact No<span style="color: red"> *</span></label>
                            <input type="text" class="form-control" name="uContactNo1" oninput="this.value = Math.abs(this.value)"
                                   id="uContactNo1" required placeholder="(+94) XXX XXXXXX"/>
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="uEmail"
                                   id="uEmail"  pplaceholder="abc@gmail.com"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Address</label>
                            <input type="text" class="form-control" name="uAddress"
                                   id="uAddress"  placeholder="Address"/>
                        </div>
                    </div>
                </div>
                <input id="hiddenSupplierId" type="hidden">
                <div class="row">
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-warning waves-effect "
                                onclick="updateSupplier()" >
                            Update Supplier</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $(document).on('focus', ':input', function () {
        $(this).attr('autocomplete', 'off');
    });
    $('.modal').on('hidden.bs.modal', function () {
        $('#errorAlert').hide();
        $('#errorAlert').html('');
        $('#errorAlert1').hide();
        $('#errorAlert1').html('');
        $('input').val('');
    });
    function adMethod(dataID, tableName) {

        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {

        });
    }


    function saveSupplier() {

        $('#errorAlert').hide();
        $('#errorAlert').html("");

        var supplierName = $("#supplierName").val();
        var contactNo1 = $("#contactNo1").val();
        var creditLimit = $("#creditLimit").val();
        var email = $("#email").val();
        var address = $("#address").val();

        $.post('saveSupplier', {
            supplierName: supplierName,
            contactNo1: contactNo1,
            email: email,
            creditLimit: creditLimit,
            address: address,

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
                    title: 'SUPPLIER SAVED',
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
                setTimeout(function () {
                    $('#addSupplier').modal('hide');
                }, 200);
                location.reload();
            }
          
        })
    }



    $(document).on('click','#uSupplierId', function () {

        var supplierId = $(this).data("id");

        $.post('getSupplierById', {supplierId: supplierId}, function (data) {
            $("#hiddenSupplierId").val(data.idsupplier);
            $("#uSupplierName").val(data.company_name);
            $("#uContactNo1").val(data.contact_no);
            $("#uEmail").val(data.email);
            $("#uAddress").val(data.address);
        });
    });


    function updateSupplier() {

        $('#errorAlert1').hide();
        $('#errorAlert1').html("");

        var uSupplierName = $("#uSupplierName").val();
        var uContactNo1 = $("#uContactNo1").val();
        var uEmail = $("#uEmail").val();
        var uAddress = $("#uAddress").val();
        var hiddenSupplierId=$("#hiddenSupplierId").val();
       
        $.post('updateSupplier', {
            hiddenSupplierId:hiddenSupplierId,
            uSupplierName: uSupplierName,
            uContactNo1: uContactNo1,
            uEmail: uEmail,
            uAddress: uAddress,

        }, function (data) {
            if (data.errors != null) {
                $('#errorAlert1').show();
                $.each(data.errors, function (key, value) {
                    $('#errorAlert1').append('<p>' + value + '</p>');
                });
            }
            if (data.success != null) {

                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'SUPPLIER UPDATED',
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
                setTimeout(function () {
                    $('#updateSupplier').modal('hide');
                }, 200);
                location.reload();
            }
           
        })
    }



</script>


@include('includes.footer_end')