@include('includes.header_account')
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<!-- Begin page -->
<div class="accountbg" ></div>

<div class="page-content-wrapper">
    <div class="container-fluid">
     
        <div class="row">
            <div class="col-lg-2">
             
            </div>
            <div class="col-lg-8">
            
                    <div class="card m-b-20">
                        <div class="card-body">
                
                            <div class="row">
                                <div class="col-lg-6">
                                   
                                    <img src="assets/images/logo_dark.png"  height="300px"
                                                                                     alt="logo">
                                  
                                </div>
                                <div class="col-lg-6">
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
                                        <label for="pass">Address</label>
                                        <input type="text" class="form-control" id="address" autocomplete="off" name="address" placeholder="Address">
                                        <small class="text-danger" id="addressError"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">Password</label>
                                        <input type="password" class="form-control" id="password" autocomplete="off" name="password" placeholder="Enter password">
                                        <small class="text-danger" id="passwordError"></small>
                                    </div>
                
                                    
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Sign Up</button>
                                   
                               
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



@include('includes.footer_account')
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
     
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
                        url: '{{route('saveUser')}}',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function (data) {
                            console.log(data.errorUser)
                            if(data.errorUser){
                               
                                    var p = document.getElementById('NIcError');
                                    p.innerHTML = data.errorUser.error;
                                
                            }
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
                            
                                if(data.errors.username) {
                                    var p = document.getElementById('NIcError');
                                    p.innerHTML = data.errors.username[0];
                                }
                                if(data.errors.password) {
                                    var p = document.getElementById('passwordError');
                                    p.innerHTML = data.errors.password[0];
                                }
                                if(data.errors.address) {
                                    var p = document.getElementById('addressError');
                                    p.innerHTML = data.errors.address[0];
                                }


                            }

                            if (data.success != null) {
                               

                                notify({
                                type: "success", //alert | success | error | warning | info
                                title: 'CUSTOMER SAVED',
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
                                    window.location.href = "signin";
                                 }, 200);
                               
                            }
                        } 
                    });
                }
            );







</script>