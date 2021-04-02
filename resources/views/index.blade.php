@include('includes/header_start')

            <!--Morris Chart CSS -->
            <link rel="stylesheet" href="assets/plugins/morris/morris.css">

@include('includes/header_end')

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Dashboard</h3>
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
                                <div class="col-md-6 col-xl-4">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-info">{{$Pending}}</h3>
                                            Pending Orders
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-purple">{{$accepted}}</h3>
                                            Accepted Orders
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-primary">{{$completed}}</h3>
                                            Completed Orders
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                           
                         
                         </div>
                        
                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

@include('includes/footer_start')

        <!--Morris Chart-->
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>
        <script src="assets/pages/dashborad.js"></script>
        <script src="admin_assets/pages/dashborad.js"></script>


<script type="text/javascript">
    // Load google charts
   
    </script>

@include('includes/footer_end')