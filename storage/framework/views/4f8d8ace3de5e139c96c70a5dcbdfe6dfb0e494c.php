

<?php $__env->startSection('content'); ?>;
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Data</h1> 
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <table class="table" style="background-color: white;">
  <thead>
    <tr>
           <th>Id</th>
           <th>Total Post</th>
           <th>Name</th>
           <th>Email</th>
           <th>Creater_at</th>
           <th>Updated_at</th>
           <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $viewdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        
      <td><?php echo e($todo->id); ?></td>
     <td><a href="<?php echo e(route('searchTotalPost', [$todo->id])); ?>"><?php echo e($todo->count); ?></a></td>
           <td><?php echo e($todo->name); ?></td>
           <td><?php echo e($todo->email); ?></td>
           <!-- <td>base64_decode (<?php echo e($todo->password); ?>);</td> -->
           <td><?php echo e($todo->created_at); ?></td>
           <td><?php echo e($todo->updated_at); ?></td>
           <td><button class="btn btn-danger changepassword" data-toggle="modal" data-target="#changepassword">Change Password</button>
            <!-- <button class="btn btn-danger changepassword" data-toggle="modal" data-target="#changepassword"><?php echo e($todo->count); ?></button> -->
            <!-- <a href="todo_edit_data/<?php echo e($todo->id); ?>">Edit</a> -->
           </td>
           
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
<?php echo e($viewdata->links()); ?>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!--==============Activate user=========----->
<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="<?php echo e(route('changepassword')); ?>" id="changepasswordvalidate">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <input class="form-control" type="hidden" name="pass_id" id="pass_id">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
        <label for="new_password">New Password</label>
        <input class="form-control" type="text" name="newpassword" id="newpassword">
        <?php $__errorArgs = ['newpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: red"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
        <label for="new_password">Con Password</label>
        <input class="form-control" type="text" name="conpassword">
        <?php $__errorArgs = ['conpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: red"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
        </div>
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

<script> 
$(".changepassword").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(0)').text();
    // rowEmail =  $row.find('td:eq(2)').text();
      $('#pass_id').val(rowIndex);
      // $('#pass_email').val(rowEmail);  
});
</script> 

<script>
   $("#changepasswordvalidate").validate({
          rules:{
            oldpassword:{
              required: true,
              minlength:8
            },
            newpassword:{
              required: true,
              minlength:8,
            },
            conpassword:{
              required: true,
              equalTo : "#newpassword"
            },
          },
        
    });

</script>
<?php $__env->stopSection(); ?>

 
<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\laravel1\blog\resources\views/userdata.blade.php ENDPATH**/ ?>