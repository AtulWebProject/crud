 

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
       <div class="alert alert-sucess" role="alert">
        <?php echo session('msg'); ?>

      </div>
      <?php endif; ?>
    <section class="content">
      <div class="container-fluid">
        <form method="post" action="<?php echo e(route('userImage')); ?>"  enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
        <!-- <fieldset> -->
        <div class="row">
          <div class="success-alert1"></div>
            <div class="col-md-4">
            <label for="name">Title:</label>
            <input type="text" class="form-control" name="title" placeholder="title">
            <p style="color: red"></p>
          </div>
          <div class="col-md-4">
            <label for="name">Image:</label>
            <input type="file" class="form-control" id="imgInp" name="profile_image" placeholder="image" value="">
            <p style="color: red"></p>
          </div>
          
          <div class="col-md-12"><br>
            <center><button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button></center>
        </div>
       
      </div>
        </div>
       
      </form>
       <div class="col-md-12">
            <img id="blah" src="<?php echo e(asset('user_profile_image')); ?>" alt="your image" style="height: 200px;width: 200px;"/>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



  
  <script type="text/javascript">
  imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\seo\resources\views/addData.blade.php ENDPATH**/ ?>