

<?php $__env->startSection('content'); ?>;

<style type="text/css">
  .show_data{border:none;}
  .carddata{display: none;}
  .modal-custom{
    max-width:800px;margin: 1.75rem auto;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="padding: 2px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0" data-toggle="modal" data-target="#Image">Data</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
              <li class="breadcrumb-item active btn btn-warning" data-toggle="modal" data-target="#uploadimage" style="margin-right:2px">Add Image
              </li>
              <!-- <li class="breadcrumb-item active btn btn-warning" >Add Metadata
              </li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" id="msg">
      
       <?php if(Session::has('msg')): ?>
       <div class="alert alert-success" role="alert">
        <?php echo session('msg'); ?>

      </div>
      <?php endif; ?>
       <?php if(Session::has('errormessage')): ?>
       <div class="alert alert-danger" role="alert">
        <?php echo session('errormessage'); ?>

      </div>
      <?php endif; ?>
           <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger" role="alert">
              <?php echo e($message); ?>

            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      <div class="container-fluid">

        <form method="get" action="<?php echo e(route('searchuserData')); ?>">
        <div class="row" style="margin-bottom: 1%;">
          <div class="col-md-6">
              <input type="search" name="title" value="<?php echo e($title??null); ?>" class="form-control" placeholder="by title">
            </div>
            <div class="col-md-6">
              <input type="file" name="profile_image" value="" class="form-control" >
            </div>
            <!-- <div class="col-md-2">
              <input type="search" name="email" value="<?php echo e($email??null); ?>" class="form-control" placeholder="by email">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="search" name="role" value="<?php echo e($role??null); ?>" class="form-control" placeholder="by role">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="date" name="created_at" value="<?php echo e($created_at??null); ?>" class="form-control" placeholder="by created_at">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="date" name="updated_at" value="<?php echo e($updated_at??null); ?>" class="form-control" placeholder="by updated_at">
            </div> -->
            <div class="col-md-1">
              <br>
              <button class="btn btn-dark">Search</button>
            </div>
            </form>
            <!-- <div class="col-md-2">
              
                <br>
                <a class="btn btn-warning" href="<?php echo e(route('export')); ?>?search=<?php echo e(request()->get('number')); ?> & email=<?php echo e(request()->get('email')); ?> & role=<?php echo e(request()->get('role')); ?> & created_at=<?php echo e(request()->get('created_at')); ?> & updated_at=<?php echo e(request()->get('updated_at')); ?> & name=<?php echo e(request()->get('search')); ?>">Export Data</a>
           
            </div> -->
            
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
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('Title'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('Image'));?></th>
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('created_at'));?></th>
           <!-- <th>Add Metadata</th> -->
           <th>action</th>
        </tr>
      </thead>
    <tbody>
      

    <?php $__currentLoopData = $viewdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td><?php echo e($no++); ?></td>
      <td class="viewid" style="display: none;"><?php echo e($todo->id); ?></td>
           <td><?php echo e($todo->title); ?></td>
           <td><img src="<?php echo e(asset('user_profile_image')); ?>/<?php echo e($todo->image); ?>" style="height:50px;width:50px"></td>
           <td><?php echo e($todo->created_at); ?></td>
           <!-- <td><button class="btn btn-primary metadata" data-toggle="modal" data-target="#Image">Click</button></td> -->
           <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("allowUser",$todo)): ?>
            <i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            <?php endif; ?>
            <!-- <a href="<?php echo e(route('todo_edit',[ base64_encode($todo->id ?? '') ])); ?>"></a> -->
            <i class="fas fa-pen editiptc" data-toggle="modal" data-target="#editiptc"></i>
            <i class="far fa-eye viewdata" data-toggle="modal" data-target="#view_specialities_details"></i>
           </td>
         </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
    </table>
    
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="Image" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="<?php echo e(route('addmetadata')); ?>" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered modal-custom" role="document" style="max-width:800px;margin: 1.75rem auto;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add MetaData</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <div class="row">
          <div class="col-md-3" id="show">
        
          </div>
          <div class="col-md-3">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="caption" id="caption">
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
          <div class="col-md-3">
        <label for="description">Headline</label>
        <input class="form-control" type="text" name="heading" id="heading"> 
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
          <div class="col-md-3">
        <label for="description">Name</label>
        <input class="form-control" type="text" name="name" id="name"> 
        <?php $__errorArgs = ['name'];
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
          <!-- <div class="col-md-3">
        <label for="description">Status</label>
        <input class="form-control" type="text" name="status" id="status"> 
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: red"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div> -->
          <div class="col-md-3">
        <label for="description">Category</label>
        <input class="form-control" type="text" name="category" id="category"> 
        <?php $__errorArgs = ['category'];
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
        <label for="description">Tag</label>
        <input class="form-control" type="text" name="keywords" id="keywords"> 
        <?php $__errorArgs = ['keywirds'];
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
        <label for="description">Relase_Date</label>
        <input class="form-control" type="text" name="rdate" id="rdate"> 
        <?php $__errorArgs = ['rdate'];
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
        <label for="originating_program">ORIGINATING_PROGRAM</label>
        <input class="form-control" type="text" name="originating_program" id="originating_program"> 
        <?php $__errorArgs = ['originating_program'];
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
        <label for="byline">Authors</label>
        <input class="form-control" type="text" name="byline" id="byline"> 
        <?php $__errorArgs = ['byline'];
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
        <label for="byline_title">BYLINE_TITLE</label>
        <input class="form-control" type="text" name="byline_title" id="byline_title"> 
        <?php $__errorArgs = ['byline_title'];
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
          <div class="col-md-3">
        <label for="city">CITY</label>
        <input class="form-control" type="text" name="city" id="city"> 
        <?php $__errorArgs = ['city'];
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
          <div class="col-md-3">
        <label for="state">STATE</label>
        <input class="form-control" type="text" name="state" id="state"> 
        <?php $__errorArgs = ['state'];
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
          <div class="col-md-3">
        <label for="country_code">COUNTRY_CODE</label>
        <input class="form-control" type="text" name="country_code" id="country_code"> 
        <?php $__errorArgs = ['country_code'];
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
          <div class="col-md-3">
        <label for="country">COUNTRY</label>
        <input class="form-control" type="text" name="country" id="country"> 
        <?php $__errorArgs = ['country_code'];
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
          <div class="col-md-12">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control" type="text" name="copyright" id="copyright"> 
        <?php $__errorArgs = ['copyright'];
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
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>
<div class="modal fade" id="uploadimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="" id="imageform" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h4 class="text-center text-capitalize">Add Image</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="col-md-12">
            <center><div id="loader"></div></center>
          </div>
        <div class="row">
          <!-- <div class="col-md-12">
        <label for="image">Title</label>
        <input class="form-control" type="text" name="title" id="title">
        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: red"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div> -->
          <div class="col-md-12">
        <label for="image">Image</label>
        <input class="form-control" type="file" name="profile_image" id="imgInp">
        <?php $__errorArgs = ['profile_image'];
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
          <div class="col-md-12">
            <img id="blah" src="<?php echo e(asset('img/noimg.png')); ?>" alt="your image" style="height: 100px;width: 100px;"/>
          </div> 
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="submit" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>

<div class="modal fade" id="view_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
    <div class="modal-content container-fluid">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Show Added Data</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="col-md-12" id="iptcdata">
           </div>
            </div>
            </div>
          <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
  </div>
</div>
<div class="modal fade" id="editiptc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <form method="post" action="<?php echo e(route('addmetadata')); ?>" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
    <div class="modal-content container-fluid">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLongTitle">Edit MetaData</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <div class="row" id="editiptcdata">
          
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>
<input type="hidden" id="url" value="<?php echo e(route('upload_image')); ?>">
<input type="hidden" id="csrf_token" value="<?php echo e(csrf_token()); ?>" />


<!------without submit send data on contriller for rowselect------>
<script type="text/javascript">
  imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
<script>
$(document).ready(function() {
    $(".viewdata").click(function() {
            // var formData = $(".idform").val();
            // alert(formData);
            var row = $(this).closest("tr").find('.viewid').text();
             //alert(row);
             $.ajax({
                 url:'<?php echo e(route('get_iptcdata')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "id":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#iptcdata").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },  
                  success: function(response){
                    
                      $('#iptcdata').html(response);

               }
             });
        });  
});
  </script> 
  <script>
$(document).ready(function() {
    $(".editiptc").click(function() {
            // var formData = $(".idform").val();
            // alert(formData);
            var row = $(this).closest("tr").find('.viewid').text();
             //alert(row);
             $.ajax({
                 url:'<?php echo e(route('edit_iptcdata')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "id":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#editiptcdata").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },  
                  success: function(response){
                    
                      $('#editiptcdata').html(response);

               }
             });
        });  
});
  </script> 
  <script type="text/javascript">
    jQuery(document).ready(function ($) {

    $("#imageform").submit(function (event) {
                event.preventDefault();
                //validation for login form
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '<?php echo e(route('upload_image')); ?>',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#loader").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },
                success: function (returndata) 
                {
                    //show return answer
                    $('#uploadimage').modal('hide');
                    $('#Image').modal('show');
                    $('#show').html(returndata);
                    $( '#imageform' ).each(function(){
                        this.reset();
                    });
                },
                error: function(returndata){
                  $( '#imageform' ).each(function(){
                        this.reset();
                    });
                  $('#uploadimage').modal('hide');
                  window.location = '<?php echo e(route('alldata')); ?>';
                                    }
        });
        return false;
    });
});
  </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\seo\resources\views/fetch_addeddata.blade.php ENDPATH**/ ?>