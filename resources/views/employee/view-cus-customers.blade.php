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
                    

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable"  class="table table-striped table-bordered data-table"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>NIC</th>
                                    <th>CONTACT NO</th>
                                    <th>EMAIL</th>
                                    <th>EDIT</th>
                                    <th>UPDATE PASSWORD</th>
                                </tr>
                                </thead>

                                <tbody>
                              
                                    
                                  
                                        <tr>
                                            <td>{{$customer->first_name}}</td>
                                            <td>{{$customer->last_name}}</td>
                                            <td>{{$customer->nic}}</td>
                                            <td>{{$customer->contact_no}}</td>
                                            <td>{{$customer->email}}</td>
                                           <td>

                                                    <p>
                                                        <button type="button"
                                                                class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $customer->iduser_master}}"
                                                              
                                                                id="uEmployee"
                                                                data-target="#employeeModal"><i
                                                                    class="fa fa-edit"></i>
                                                        </button>
                                                    </p>
                                            </td>
                                            <td>
                                                <p style="text-align: center">
                                                    <button type="button"
                                                            class="btn btn-sm btn-warning  waves-effect waves-light"
                                                            data-toggle="modal"
                                                            id="uPasswordId"
                                                            data-id="{{ $customer->iduser_master }}"
                                                            data-target="#passUpModal"
                                                    ><i
                                                                class="mdi mdi-key"></i></button>
                                                </p>
                                            </td>
                                        </tr>
                                   
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="employeeModal"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                
                <form class="" method="post" enctype="multipart/form-data"
                action="{{ route('updateUser') }}" id="updateUserId">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="pass">First Name</label>
                            <input type="text" class="form-control" id="fName" autocomplete="off" name="fName" placeholder="First Name">
                            <small class="text-danger" id="fNameError"></small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="pass">Last Name</label>
                            <input type="text" class="form-control" id="lName" autocomplete="off" name="lName" placeholder="Last Name">
                            <small class="text-danger" id="lNameError"></small>
                        </div>
                    </div>
                   </div>

                   
                  
                
                    <div class="form-group">
                        <label for="pass">Contact No</label>
                        <input type="number" class="form-control" id="contactNo" autocomplete="off" name="contactNo" placeholder="+(94) XX XXX XXXX">
                        <small class="text-danger" id="contactNoError"></small>
                    </div>
                    <div class="form-group">
                        <label for="pass">Email</label>
                        <input type="text" class="form-control" id="email" autocomplete="off" name="email" placeholder="abc@abc.com">
                        <small class="text-danger" id="emailError"></small>
                    </div>
                
                    <div class="form-group">
                        <label for="pass">NIC</label>
                        <input type="text" class="form-control" id="nicNo" autocomplete="off" name="nicNo" placeholder="NIC No">
                        <small class="text-danger" id="NIcError"></small>
                    </div>
                   

                    <input type="hidden" id="hiddenUID" name="hiddenUID" />
                        <button class="btn btn-warning w-md waves-effect waves-light" type="submit">Update</button>
                   
               
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passUpModal"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Password</h5>
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
                <input type="hidden" name="hiddenPID" id="hiddenPID">

                <div class="form-group">
                    <label>Password</label>
                    <div>
                        <input type="password" name="update_pass2" id="update_pass2" class="form-control" required
                               placeholder="Password"/>
                        <small class="text-danger">{{ $errors->first('update_pass2') }}</small>
                    </div>
                    <div class="m-t-10">
                        <input type="password" name="compass" id="compass" class="form-control" required
                               data-parsley-equalto="#update_pass2"
                               placeholder="Re-Type Password"/>
                    </div>
                </div>
                <div class="form-group">

                    <button type="submit" class="btn btn-md btn-warning waves-effect "
                            onclick="editPassword()">
                        Update Password</button>
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
    

    $(document).on('click', '#uPasswordId', function () {
        var userId = $(this).data("id");

            $("#hiddenPID").val(userId);

    });

    $(document).on('click', '#uEmployee', function () {
        var userId = $(this).data("id");
        $.post('getUserById',{
            userId:userId
        },function(data){
            $("#fName").val(data.first_name);
            $("#lName").val(data.last_name);
            $("#contactNo").val(data.contact_no);
            $("#email").val(data.email);
            $("#nicNo").val(data.nic);
            $("#hiddenUID").val(data.iduser_master);
           
        })
    });

    

    $('.modal').on('hidden.bs.modal', function () {

$("input").val('');

$('#errorAlert1').html('');
$('#errorAlert2').html('');

$('#errorAlert1').hide();
$('#errorAlert2').hide();


$('#titleError').html('');
$('#fNameError').html('');
$('#lNameError').html('');
$('#contactNoError').html('');
$('#employeeTypeError').html('');
$('#usernameError').html('');
$('#passwordError').html('');


});
    function editPassword() {


$('#errorAlert2').hide();
$('#errorAlert2').html("");

var update_pass2 = $("#update_pass2").val();
var hiddenPID = $("#hiddenPID").val();
var compass = $("#compass").val();



$.post('updatePassword', {
    update_pass2: update_pass2,
    hiddenPID: hiddenPID,
    compass: compass

}, function (data) {
    if (data.errors != null) {
        $('#errorAlert2').show();
        $.each(data.errors, function (key, value) {
            $('#errorAlert2').append('<p>' + value + '</p>');
        });

    }
    if (data.success != null) {
        notify({
            type: "success", //alert | success | error | warning | info
            title: 'PASSWORD UPDATED',
            autoHide: true, //true | false
            delay: 2500, //number ms
            position: {
                x: "right",
                y: "top"
            },
            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

            message: data.success,
        });

        setTimeout(function () {
            $('#passUpModal').modal('hide');
        }, 200);
    }

});
}


$("#updateUserId").on("submit", function (event) {
              
             

              $("#fNameError").html('');
              $("#emailError").html('');
              $("#lNameError").html('');
              $("#contactNoError").html('');
              $("#NIcError").html('');
             
              event.preventDefault();

                  $.ajax({
                      url: '{{route('updateUser')}}',
                      type: 'POST',
                      data: $(this).serialize(),
                      success: function (data) {

                          if (data.errors != null) {

                            

                              if(data.errors.fName) {
                                  var p = document.getElementById('fNameError');
                                  p.innerHTML = data.errors.fName[0];
                              }
                              if(data.errors.email) {
                                  var p = document.getElementById('emailError');
                                  p.innerHTML = data.errors.email[0];
                              }
                              
                              if(data.errors.lName) {
                                      var p = document.getElementById('lNameError');
                                      p.innerHTML = data.errors.lName[0];
                              }
                              if(data.errors.contactNo) {
                                  var p = document.getElementById('contactNoError');
                                  p.innerHTML = data.errors.contactNo[0];
                              }
                          
                              if(data.errors.nicNo) {
                                  var p = document.getElementById('NIcError');
                                  p.innerHTML = data.errors.nicNo[0];
                              }
                           

                          }

                          if (data.success != null) {
                             

                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'CUSTOMER UPDATED',
                              autoHide: true, //true | false
                              delay: 2500, //number ms
                              position: {
                                  x: "right",
                                  y: "top"
                              },
                              icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                              message: data.success,
                              });

                              setTimeout(function () {
                                location.reload();
                               }, 200);
                             
                          }
                      } 
                  });
              }
          );

</script>


@include('includes.footer_end')