

<?php $__env->startSection('content'); ?>;
<style type="text/css">
  .error{
    color: red;
  }
</style>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Question</h1>
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
    <?php if(Session::has('msg')): ?>
       <div class="alert alert-danger" role="alert">
        <?php echo session('msg'); ?>

      </div>
      <?php endif; ?>
    <section class="content">
      <div class="container-fluid">
        <form id="registerForm" action="todo_submit" method="post">
          <?php echo csrf_field(); ?>
        <!-- <fieldset> -->
        <div class="row">
          <div class="success-alert1"></div>
          <div class="col-md-4">
            <label for="name">Question:</label>
            <input type="text" class="form-control" name="question" placeholder="Enter Your question" value="<?php echo e(old('question')); ?>">
            <?php $__errorArgs = ['question'];
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
          <div class="col-md-4">
            <label for="mobile">Ans1:</label>
            <input type="text" class="form-control" name="ans1" value="<?php echo e(old('ans1')); ?>">
            <?php $__errorArgs = ['ans1'];
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
          <div class="col-md-4">
            <label for="profile_image">Ans2:</label>
            <input type="text" class="form-control file_upload1" name="ans2" value="<?php echo e(old('ans2')); ?>">
            <?php $__errorArgs = ['ans2'];
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
          <div class="col-md-6">
            <label for="ans3">Ans3:</label>
            <input type="text"  class="form-control" name="ans3" value="<?php echo e(old('ans3')); ?>">
            <?php $__errorArgs = ['ans3'];
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
          <div class="col-md-6">
            <label for="ans4">Ans4:</label>
            <input type="text"  class="form-control" name="ans4" value="<?php echo e(old('ans4')); ?>">
            <?php $__errorArgs = ['ans3'];
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
          <div class="col-md-6">
            <label for="Rans">Right Ans:</label>
            <input type="text"  class="form-control" name="rans" value="<?php echo e(old('rans')); ?>">
            <?php $__errorArgs = ['ans3'];
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
          
          <div class="col-md-12"><br>
            <center><button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button></center>
        </div>
        <!-- <div class="Errors">
        <ul></ul> -->
      </div>
        </div>
        <!-- </fieldset> -->
      </form>
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- <script src="<?php echo e(asset('admin1/js/jquery.js')); ?>"></script> -->
  <script>
   $("#registerForm").validate({
          rules:{
            question:{
              required: true
             
            },
            ans1:{
              required: true
              
            },
           ans2:{
              required:true
              
           },
            ans3:{
              required: true 
          },
          ans4:{
              required: true
            },
            rans:{
              required:true
            }
        },
          message:{
            question:{
              required:"question required"
              
            },
            ans1:{
              required: "ans1 Required"
              
            },
            ans2:{
              required:"ans2 Required"
             
           },
           ans3:{
              required: "ans3 Required"
            },
            ans4:{
              required:"ans4 required"
            },
            rans:{
              required:"rans required"
            }
          }
    });


</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\laravel1\blog\resources\views/addData.blade.php ENDPATH**/ ?>