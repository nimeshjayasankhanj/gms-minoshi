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
            <div class="col-lg-7">
                <div class="card m-b-20">

                    <div class="card-body">

                        <div class="table-rep-plugin">
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="" class="table table-striped table-bordered data-table" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>

                                            <th>PRODUCT</th>
                                            <th>QTY</th>
                                            <th style="text-align: right">TOTAL</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($bookingItems))
                                            @if (count($bookingItems) != 0)
                                                @foreach ($bookingItems as $bookingItem)
                                                    <tr>
                                                        <td>{{ $bookingItem->Product->product_name }}</td>
                                                        <td>{{ number_format($bookingItem->qty, 2) }}</td>
                                                        <td style="text-align: right">
                                                            {{ number_format($bookingItem->qty * $bookingItem->Product->selling_price, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" style="text-align: center;font-wight:bold">Sorry No
                                                        Results Found.</td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="row" id="bookingButton">


                            <div class="col-lg-4">

                                <button type="button"   data-toggle="modal"  data-target="#paymentModal" class="btn btn-primary" id="saveBookingBtn"
                                    >
                                 Make Payment</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
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
                        @if (count($bookingItems) != 0)
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><b>Customer : {{ $bookingDetail->User->first_name }}
                                            {{ $bookingDetail->User->last_name }}</b></p>
                                    <p style="line-height: 0px"><b>Booking ID :
                                            {{ str_pad($bookingDetail->idmaster_booking, 5, '0', STR_PAD_LEFT) }}</b>
                                    </p>

                                    <hr>
                                    <div class="row">
                                        @foreach ($bookingItems as $bookingItem)
                                            <div class="col-lg-5">
                                                {{ $bookingItem->Product->product_name }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($bookingItem->qty, 2) }}
                                            </div>
                                            <div class="col-lg-4" style="text-align: right">
                                                {{ number_format($bookingItem->qty * $bookingItem->Product->selling_price, 2) }}

                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <b>Total</b>
                                        </div>
                                        <div class="col-lg-8" style="text-align: right">
                                            <b> {{ number_format($bookingDetail->total, 2) }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->



<!--paymentModal-->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Save Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Paid Amount<span style="color: red">
                            *</span></label>
                        <input type="hidden" value="{{$idOrder}}" id="idOrder" />
                    <input type="text" class="form-control" name="paymentAmount" id="paymentAmount" required
                        placeholder="0.00" />
                    <span id="paymentAmountError" style="color: red"></span>
                </div>
                <button type="button" class="btn btn-primary waves-effect " onclick="saveInvoice()">
                    Save Invoice</button>
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

  
    $('.modal').on('hidden.bs.modal', function() {


        $("#categoryError").html('');
        $("#uCategoryError").html('');
        $("#paymentAmountError").html('');
        $("#cPriceError").html('');
        $("#cPriceError").html('');

    });



    function saveInvoice() {

        var paymentAmount = $("#paymentAmount").val();
        var idOrder = $("#idOrder").val();

        $.post('saveInvoice', {
            idOrder: idOrder,
            paymentAmount: paymentAmount
        }, function(data) {

            if (data.errorsAmount) {
                if (data.errorsAmount) {
                    var p = document.getElementById('paymentAmountError');
                    p.innerHTML = data.errorsAmount;

                }
            }

            if (data.errors != null) {

                if (data.errors.paymentAmount) {
                    var p = document.getElementById('paymentAmountError');
                    p.innerHTML = data.errors.paymentAmount;

                }
            }
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

                window.location.href = "invoice-history";
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
