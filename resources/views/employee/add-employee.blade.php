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
        <h3 class="page-title">{{$title}}</h3>
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
                <div class="col-lg-2">
                 
                </div>
                <div class="col-lg-8">
                
                        <div class="card m-b-20">
                            <div class="card-body">
                    
                                <div class="row">
                                  
                                    <div class="col-lg-12">
                                    <form class="" method="post" enctype="multipart/form-data"
                                    action="{{ route('saveUser') }}" id="saveUserId">
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
                                            <label for="pass">Username</label>
                                            <input type="text" class="form-control" id="username" autocomplete="off" name="username" placeholder="Username">
                                            <small class="text-danger" id="NIcError"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="pass">Password</label>
                                            <input type="password" class="form-control" id="password" autocomplete="off" name="password" placeholder="Enter password">
                                            <small class="text-danger" id="passwordError"></small>
                                        </div>
                    
                                        
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Save Employee</button>
                                       
                                   
                                    </form>
                                </div>
                                </div>
                    
                            </div>
                        
                    </div>
               </div>
               <div class="col-lg-2">
               
           </div>
            </div>
           
        </div><!-- container -->
    
    </div> <!-- Page content Wrapper -->




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
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });
  

  //sign up 
  $("#saveUserId").on("submit", function (event) {
              
              

              $("#fNameError").html('');
              $("#emailError").html('');
              $("#lNameError").html('');
              $("#contactNoError").html('');
              $("#NIcError").html('');
              $("#passwordError").html('');

              event.preventDefault();

                  $.ajax({
                      url: '{{route('saveDriver')}}',
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
                              if(data.errors.password) {
                                  var p = document.getElementById('passwordError');
                                  p.innerHTML = data.errors.password[0];
                              }


                          }

                          if (data.success != null) {
                             

                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'DRIVER SAVED',
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


@include('includes/footer_end')