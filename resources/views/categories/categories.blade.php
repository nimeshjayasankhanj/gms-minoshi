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
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                   
                    <div class="row">
                        
                    
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary float-right"
                                    data-toggle="modal"  data-target="#addCategoryModal">
                                Add Cloth</button>
                        </div>
                    </div>
                    <br>
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable"  class="table table-striped table-bordered data-table"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>CLOTH NAME</th>
                                    <th>STATUS</th>
                                    <th>EDIT</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($mainCategories)>0)
                                        @foreach($mainCategories as $mainCategory)
                                            <tr>
                                                <td>{{$mainCategory->main_category_name}}</td>

                                                @if($mainCategory->status == 1)

                                                    <td>
                                                        <p>
                                                            <input type="checkbox"
                                                                   onchange="adMethod('{{ $mainCategory->idmain_category}}','main_category')"
                                                                   id="{{"c".$mainCategory->idmain_category}}" checked
                                                                   switch="none"/>
                                                            <label for="{{"c".$mainCategory->idmain_category}}"
                                                                   data-on-label="On"
                                                                   data-off-label="Off"></label>
                                                        </p>
                                                    </td>
                                                @else
                                                    <td>
                                                        <p>
                                                            <input type="checkbox"
                                                                   onchange="adMethod('{{ $mainCategory->idmain_category}}','main_category')"
                                                                   id="{{"c".$mainCategory->idmain_category}}"
                                                                   switch="none"/>
                                                            <label for="{{"c".$mainCategory->idmain_category}}"
                                                                   data-on-label="On"
                                                                   data-off-label="Off"></label>
                                                        </p>
                                                    </td>
                                                @endif

                                                <td>


                                                        <button type="button"
                                                                class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                data-toggle="modal"
                                                                data-id="{{ $mainCategory->idmain_category}}"
                                                                data-name="{{ $mainCategory->main_category_name}}"
                                                                id="uCategoryID"
                                                                data-target="#updateCategoryModal"><i
                                                                    class="fa fa-edit"></i>
                                                        </button>
                                                  
                                                </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

<!--add category modal-->
<div class="modal fade" id="addCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Cloth</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="post" enctype="multipart/form-data"
                action="{{ route('saveCategory') }}" id="saveCategoryId">
                {{csrf_field()}}
                <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Cloth<span style="color: red"> *</span></label>

                            <input type="text" class="form-control" name="category" id="category" 
                                   placeholder="Cloth"/>
                            <small class="text-danger" id="categoryError"></small>
                        </div>
                <button type="submit" class="btn btn-primary"
                     >
                    Save Category</button>
                </form>
                </div>
            
            </div>
        </div>
    </div>
</div>


<!--update category modal-->
<div class="modal fade" id="updateCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Cloth</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="post" enctype="multipart/form-data"
                action="{{ route('editCategory') }}" id="editCategoryId">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="example-text-input" class="col-form-label">Cloth<span style="color: red"> *</span></label>

                    <input type="text" class="form-control" name="uCategory" id="uCategory" 
                           placeholder="Cloth"/>
                    <small class="text-danger" id="uCategoryError"></small>
                </div>
                <input type="hidden" id="hiddenCatId" name="hiddenCatId">
                <button type="submit" class="btn btn-warning"
                       >
                    Update Cloth</button>
                </form>
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
    function adMethod(dataID, tableName) {

        $.post('changeStatus', {id: dataID, table: tableName}, function (data) {

        });
    }
    $('.modal').on('hidden.bs.modal', function () {


        $("#categoryError").html('');

        $("#uCategoryError").html('');
        $('input').val('');

    });


    //save category
    $("#saveCategoryId").on("submit", function (event) {
              
              $("#categoryError").html('');
              event.preventDefault();

                  $.ajax({
                      url: '{{route('saveCategory')}}',
                      type: 'POST',
                      data: $(this).serialize(),
                      success: function (data) {

                          if (data.errors != null) {
                              if(data.errors.category) {
                                  var p = document.getElementById('categoryError');
                                  p.innerHTML = data.errors.category[0];
                              }
                             
                          }

                          if (data.success != null) {
                             

                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'CATEGORY SAVED',
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
                                
                                  $('#addCategoryModal').modal('hide');
                               }, 200);

                               setTimeout(function () {
                                
                                location.reload();  
                             }, 300);
                             
                          }
                      } 
                  });
              }
          );

    
    //edit category
    $("#editCategoryId").on("submit", function (event) {
              
              $("#categoryError").html('');
              event.preventDefault();

                  $.ajax({
                      url: '{{route('editCategory')}}',
                      type: 'POST',
                      data: $(this).serialize(),
                      success: function (data) {

                          if (data.errors != null) {
                              if(data.errors.category) {
                                  var p = document.getElementById('uCategoryError');
                                  p.innerHTML = data.errors.category[0];
                              }
                             
                          }

                          if (data.success != null) {
                             

                              notify({
                              type: "success", //alert | success | error | warning | info
                              title: 'CATEGORY EDIT',
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
                                
                                  $('#updateCategoryModal').modal('hide');
                               }, 200);
                             location.reload();
                          }
                      } 
                  });
              }
          );

    $(document).on('click', '#uCategoryID', function () {
        var categoryId = $(this).data("id");
        var categoryName = $(this).data("name");

        $("#hiddenCatId").val(categoryId);
            $("#uCategory").val(categoryName);
    });

    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });

</script>


@include('includes/footer_end')