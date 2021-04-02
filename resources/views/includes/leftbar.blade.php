<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="">
                <!--<a href="index" class="logo text-center">Fonik</a>-->

                <a href="{{ URL::asset('index') }}" class="logo"><img
                        src="{{ URL::asset('assets/images/Royal Laundry.png') }}" height="150" alt="logo"></a>

            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>



                    <li>
                        <a href="index" class="waves-effect"><i class="dripicons-device-desktop"></i><span>Dashboard
                            </span></a>
                    </li>

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-book"
                                    aria-hidden="true"></i><span>Tasks<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('pending-tasks') }}"><span>Pending Tasks</span></a>
                                </li>

                                <li>
                                    <a href="{{ route('completed-tasks') }}"><span>Completed Tasks</span></a>
                                </li>

                            </ul>
                        </li>
                    @endif

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 2)
                        <li class="menu-title">INVOICE SECTION</li>
                        <li>
                            <a href="{{ route('make-a-booking') }}" class="waves-effect"><i class="fa fa-book"
                                    aria-hidden="true"></i><span>Make an Invoice </span></a>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-book"
                                    aria-hidden="true"></i><span>Invoices<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('pending-cus-works') }}"><span>Pending Invoices</span></a>
                                </li>

                                <li>
                                    <a href="{{ route('completed-cus-works') }}"><span>Completed Invoices</span></a>
                                </li>

                            </ul>
                        </li>

                        <li class="menu-title">USER MANAGEMENT</li>

                        <li>
                            <a href="{{ route('view-customers') }}" class="waves-effect"><i class="fa fa-user"
                                    aria-hidden="true"></i><span>Profile </span></a>
                        </li>



                    @endif

                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1)
                        <li class="menu-title">INVOICE SECTION</li>
                        <li>
                            <a href="{{ route('invoice-history') }}" class="waves-effect"><i class="fa fa-book"
                                    aria-hidden="true"></i><span>Invoice History </span></a>
                        </li>



                        <li class="menu-title">TASK MANAGEMENT</li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-book"
                                    aria-hidden="true"></i><span>Booking<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('pending-works') }}"><span>Pending Works</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('accepted-works') }}"><span>Accepted Works</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('delivered-works') }}"><span>Delivered works</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('completed-works') }}"><span>Completed Works</span></a>
                                </li>

                            </ul>
                        </li>







                        <li class="menu-title">Reports</li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-files-o"
                                    aria-hidden="true"></i><span>Reports<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">


                                <li>
                                    <a href="{{ route('income-report') }}"><span>Income Report</span></a>
                                </li>

                                <li>
                                    <a href="{{ route('pending-orders') }}"><span>Pending Orders Report</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('accepted-orders') }}"><span>Accepted Orders Report</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('completed-orders') }}"><span>Completed Orders Report</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('active-stock') }}"><span>Active Stock Report</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('deactive-stock') }}"><span>Deactve Stock Report</span></a>
                                </li>



                            </ul>
                        </li>








                        <li class="menu-title">USER MANAGEMENT</li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user"
                                    aria-hidden="true"></i><span>Users<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">

                                <li>
                                    <a href="add-employee" class="waves-effect"><span>Add Driver</span></a>
                                </li>
                                <li>
                                    <a href="view-users" class="waves-effect"><span>View Users</span></a>
                                </li>
                            </ul>
                        </li>




                        <li class="menu-title">PRODUCT INVENTORY</li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="fa fa-cubes"></i><span>Products<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">

                                <li>
                                    <a href="products" class="waves-effect"><span>Products</span></a>
                                </li>
                                <li>
                                    <a href="main-categories" class="waves-effect"><span>Categories</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-title">SUPPLIER </li>
                        <li>
                            <a href="suppliers" class="waves-effect"><i
                                    class="fa fa-user"></i><span>Suppliers</span></a>
                        </li>

                        <li class="menu-title">PURCHASING INVENTORY</li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cubes"></i><span>Purchase
                                    Order<span class="pull-right"><i class="mdi mdi-chevron-right"></i></span>
                                </span></a>
                            <ul class="list-unstyled">
                                <li><a href="add-po">Add Purchase Order</a></li>
                                <li><a href="pending-po">Pending Purchase Order</a></li>
                                <li><a href="approved-po">Approved Purchase Order</a></li>
                                <li><a href="completed-po">Completed Purchase Order</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="fa fa-suitcase"></i><span>GRN<span class="pull-right"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li><a href="add-grn">Add GRN</a></li>
                                <li><a href="grn-history">GRN History</a></li>
                            </ul>
                        </li>


                        <li class="menu-title">USER MANAGEMENT</li>

                        <li>
                            <a href="{{ route('view-customers') }}" class="waves-effect"><i class="fa fa-user"
                                    aria-hidden="true"></i><span>Profile </span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->
