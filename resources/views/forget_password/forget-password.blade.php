@include('includes.header_account')
<link href="{{ URL::asset('assets/css/jquery.notify.css') }}" rel="stylesheet" type="text/css">
<meta name="csrf-token" content="{{ csrf_token() }}"/>

<!-- Begin page -->
<div class="accountbg"></div>

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

                                <img src="assets/images/logo_dark.png" height="300px" alt="logo">

                            </div>
                            <div class="col-lg-6">


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="pass">Username</label>
                                            <input type="text" class="form-control" id="userName" autocomplete="off"
                                                name="userName" placeholder="Username">
                                            <small class="text-danger" id="userNameError"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="pass">New Password</label>
                                            <input type="password" class="form-control" id="password" autocomplete="off"
                                                name="password" placeholder="Enter password">
                                            <small class="text-danger" id="passwordError"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="button"
                                            onclick="changePassword()">Reset Password</button>
                                    </div>

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
    <script src="{{ URL::asset('assets/js/jquery.notify.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
        $(document).on("wheel", "input[type=number]", function(e) {
            $(this).blur();
        });

        //sign up 

        function changePassword() {

            $("#fNameError").html('');
            $("#emailError").html('');
            $("#lNameError").html('');
            $("#contactNoError").html('');
            $("#userNameError").html('');
            $("#passwordError").html('');

            var userName = $("#userName").val();
            var password = $("#password").val();

            $.post('resetPassword', {
                userName: userName,
                password: password,
            }, function(data) {
                if (data.errors != null) {

                    if (data.errors.userName) {
                        var p = document.getElementById('userNameError');
                        p.innerHTML = data.errors.userName[0];
                    }
                    if (data.errors.password) {
                        var p = document.getElementById('passwordError');
                        p.innerHTML = data.errors.password[0];
                    }
                }

                if (data.success != null) {


                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'PASSWORD RESET',
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
                        window.location.href = "signin";
                    }, 200);

                }
            })

        }

    </script>
