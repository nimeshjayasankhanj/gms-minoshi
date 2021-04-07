@include('includes.header_account')

<!-- Begin page -->
<div class="accountbg" ></div>
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="index" class="logo logo-admin"><img src="assets/images/logo_dark.png" height="100"
                                                             alt="logo"></a>
            </h3>

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">WelcomeBack !</h4>
                <p class="text-muted text-center">Sign in to continue to The Sun Star Holdings</p>

                @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ \Session::get('error') }}</p>
                    </div>
                @endif

                @if(\Session::has('warning'))
                    <div class="alert alert-warning alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ \Session::get('warning') }}</p>
                    </div>
                @endif


                <form class="form-horizontal m-t-30" action="{{ route('loginMy') }}" method="POST">
                {{--<form class="form-horizontal m-t-30" action="{{ route('authenticate') }}" method="POST">--}}

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                               placeholder="Username">
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">

                    <div class="form-group row m-t-20">
                        <div class="col-sm-6">
                            
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group mb-0 row">
                        <div class="col-12">
                            <p style="text-align: center">Not a member yet? <a href="{{ URL::asset('sign-up')}}" class="text-muted">Sign Up</a></p>
                            <p style="text-align: center"><a href="{{ URL::asset('forget-password')}}" class="text-muted">Forget Password</a></p>
                           
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

   
</div>

@include('includes.footer_account')