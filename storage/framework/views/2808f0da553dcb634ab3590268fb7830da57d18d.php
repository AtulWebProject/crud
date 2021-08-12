

<?php $__env->startSection('content'); ?>;

<style type="text/css">
  .show_data{border:none;}
  .carddata{display: none;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="padding: 2px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">Data</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
              <li class="breadcrumb-item active"><a class="btn btn-warning" href="<?php echo e(route('showData')); ?>">Add Data</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      
       <?php if(Session::has('msg')): ?>
       <div class="alert alert-success" role="alert">
        <?php echo session('msg'); ?>

      </div>
      <?php endif; ?>
      <div class="container-fluid">

        <form method="get" action="<?php echo e(route('searchuserData')); ?>">
        <div class="row" style="margin-bottom: 1%;">
          <div class="col-md-2">
              <input type="search" name="search" value="<?php echo e($search??null); ?>" class="form-control" placeholder="by name">
            </div>
            <div class="col-md-2">
              <input type="search" name="number" value="<?php echo e($number??null); ?>" class="form-control" placeholder="by number">
            </div>
            <div class="col-md-2">
              <input type="search" name="email" value="<?php echo e($email??null); ?>" class="form-control" placeholder="by email">
            </div>
            <div class="col-md-2">
              <input type="search" name="role" value="<?php echo e($role??null); ?>" class="form-control" placeholder="by role">
            </div>
            <div class="col-md-2">
              <input type="date" name="created_at" value="<?php echo e($created_at??null); ?>" class="form-control" placeholder="by created_at">
            </div>
            <div class="col-md-2">
              <input type="date" name="updated_at" value="<?php echo e($updated_at??null); ?>" class="form-control" placeholder="by updated_at">
            </div>
            <div class="col-md-1">
              <br>
              <button class="btn btn-dark">Search</button>
            </div>
            </form>
            <div class="col-md-2">
              
                <br>
                <a class="btn btn-warning" href="<?php echo e(route('export')); ?>?search=<?php echo e(request()->get('number')); ?> & email=<?php echo e(request()->get('email')); ?> & role=<?php echo e(request()->get('role')); ?> & created_at=<?php echo e(request()->get('created_at')); ?> & updated_at=<?php echo e(request()->get('updated_at')); ?> & name=<?php echo e(request()->get('search')); ?>">Export Data</a>
           
            </div>
            
            <div class="col-md-1">
              <br>
              <a href="fetch_addeddata"><i class="fas fa-sync" style="margin-left: 1%;"></i></a>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <form id="myForm" method="get" action="<?php echo e(route('getRowData')); ?>">
              <!-- <?php echo csrf_field(); ?> -->
              <div class="col-md-2" style="float: right;">
              <select class="form-select" id="rowfilter" style="width: 100%;" name="rowdataget">
                <option><?php echo e($rowfilter??null); ?></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
              </select>
              </div>
            </div>
            </form>
        </div>
        <div class="row">

    <table id="example" class="table nowrap" style="background-color: white;">
      <thead>
        <tr>
           <th>S.No</th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('question'));?></th>
           <!-- <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('question'));?></th> -->
           <!-- <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('ans1'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('ans2'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('ans3'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('ans4'));?></th> -->
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('rans'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('created_at'));?></th>
           <th>Allow</th>
           <th>action</th>
        </tr>
      </thead>
    <tbody>
    <?php $__currentLoopData = $viewdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        
      <td><?php echo e(($viewdata->currentpage()-1) * $viewdata->perpage() + $key + 1); ?></td>
      <td class="viewid" style="display: none;"><?php echo e($todo->id); ?></td>
           <td><?php echo e($todo->question); ?></td>
           <td><?php echo e($todo->rans); ?></td>
           <td><?php echo e($todo->created_at); ?></td>
           <td>
           <?php $status=$todo->type; if ($status == '') { ?>
           <button class="btn btn-dark adddatatype">Regular</button>
            <button class="btn btn-dark adddataquiztype">Quiz</button>
           
           <?php }else{ ?>
            <?php $status=$todo->status; if ($status == 1) { ?>
             <svg xmlns="http://www.w3.org/2000/svg" width="35" height="25" fill="currentColor" class="bi bi-toggle-on active" viewBox="0 0 16 16" style="color:green;" data-toggle="modal" data-target="#active">
            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
           <?php }else{ ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="26" fill="currentColor" class="bi bi-toggle-on dactive" viewBox="0 0 16 16" style="color:red;" data-toggle="modal" data-target="#dactive">
            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
           <?php }} ?></td>
           <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("allowUser",$todo)): ?>
            <i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            <?php endif; ?>
            <a href="<?php echo e(route('todo_edit',[ base64_encode($todo->id ?? '') ])); ?>"><i class="fas fa-pen"></i></a>
            <i class="far fa-eye viewdata" data-toggle="modal" data-target="#view_specialities_details"></i>
           </td>

    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    </table>
    <?php echo $viewdata->appends(Request::input())->render(); ?>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!--==============Activate user=========----->
<div class="modal fade" id="active" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="<?php echo e(route('activeUser')); ?>">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure You Are Dactivated This..</h5>
        <input type="hidden" name="current_url" value="<?php echo e(url()->full()); ?>">
        <input type="hidden" name="active_id" id="active_id">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>
<!---===================Dactivate User============----->
<div class="modal fade" id="dactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="<?php echo e(route('activeUser')); ?>">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure You Are Activated This</h5>
        <input type="hidden" name="current_url" value="<?php echo e(url()->full()); ?>">
        <input type="hidden" name="active_id" id="dactive_id">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>
<!---------view model---------->
<!-- Modal -->
<div class="modal fade" id="view_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="todo_delete">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered" role="document" style="padding: 2%;">
    <div class="modal-content">
      <div class="container" style="height: 300px; overflow-x: scroll;">
        <!-- <div id="result"></div> -->
        <table id="show" class="table">
          
        </table>
        <!-- <input type="text" name="name" id="name">
        <input type="text" name="name" id="name">
        <input type="text" name="name" id="mobile"> -->
      </div>
      <div class="modal-footer">
        <!-- <button type="submit" class="btn btn-primary">Yes</button> -->
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!------without submit send data on contriller for rowselect------>
<script>
$(document).ready(function() {
    $(".viewdata").click(function() {
            // var formData = $(".idform").val();
            // alert(formData);
            var row = $(this).closest("tr").find('.viewid').text();
             //alert(row);
             $.ajax({
                 url:'<?php echo e(route('todo_view')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "row":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#show").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },  
                  success: function(response){
                    
                      $('#show').html(response);

               }
             });
        });  
});
  </script> 
<!--start for regular -->
  <script>
$(document).ready(function() {
    $(".adddatatype").click(function() {
            var row = $(this).closest("tr").find('.viewid').text();
             // alert(row);
             $.ajax({
                 url:'<?php echo e(route('adddataforuser')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "row":row,
                 },
                  success: function(response){
                    
                      // $('#showadddata').html(response);
                      alert("sucessfull add");

               }
             });
        });  
});
  </script>
<!--end for regular -->
  <!--start for quiz -->
  <script>
$(document).ready(function() {
    $(".adddataquiztype").click(function() {
            var row = $(this).closest("tr").find('.viewid').text();
             // alert(row);
             $.ajax({
                 url:'<?php echo e(route('adddataquizforuser')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "row":row,
                 },
                  success: function(response){
                    
                      // $('#showadddata').html(response);
                      alert("sucessfull add");

               }
             });
        });  
});
  </script>  
<!--end for quiz -->


<script type="text/javascript">
  $(function() {
      $('#rowfilter').change(function() {
            $('#myForm').submit();
      });
});
</script>
<!-------delete script--------->
<script> 
$(".delete").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#delete_id').val(rowIndex);
    $('#delete_specialities_details').modal('show');   
});



</script> 

<!-----active----->
<script> 
$(".active").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#active_id').val(rowIndex);  
});
</script> 
<!-----dacrive----->
<script> 
$(".dactive").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#dactive_id').val(rowIndex); 
});



</script> 
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\laravel1\blog\resources\views/fetch_addeddata.blade.php ENDPATH**/ ?>