

<?php $__env->startSection('content'); ?>;
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="../public/css/costumcss.css">
<link rel="stylesheet" type="text/css" href="../public/css/bootstrap-tagsinput.css">

<?php $__env->stopSection(); ?>
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
            <div class="col-md-1">
              <br>
              <button class="btn btn-dark">Search</button>
            </div>
            </form>
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
           <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('Store Code'));?></th>
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
           <td><?php echo e($todo->store_code); ?></td>
           <td><img src="<?php echo e(asset('user_profile')); ?>/<?php echo e($todo->iconurl); ?>" style="height:50px;width:50px"></td>
           <td><?php echo e($todo->created_at); ?></td>
           <td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("allowUser",$todo)): ?>
            <i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            <?php endif; ?>
            <a href="<?php echo e(route('edit_exifdata')); ?>/<?php echo e($todo->id); ?>"><i class="fas fa-pen"></i></a>
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
  <form method="post" action="" enctype="multipart/form-data" id="metadataform">
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
          <div class="col-md-12" id="addmetadataloader"></div>
          <div class="col-md-3" id="show">
        
          </div>
          <div class="col-md-3">
        <label for="title">Title</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image title"></i>
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
        <label for="description">Description</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image description"></i>
        <input class="form-control" type="text" name="description" id="description"> 
        <?php $__errorArgs = ['description'];
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
        <label for="comment">Comment</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image comment"></i>
        <input class="form-control" type="text" name="comment" id="comment"> 
        <?php $__errorArgs = ['comment'];
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
        <label for="longitude">Longitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240.5214"></i>
        <input class="form-control" type="text" name="longitude" id="longitude" required> 
        <?php $__errorArgs = ['longitude'];
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
        <label for="latitude">Latitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 20.54614"></i>
        <input class="form-control" type="text" name="latitude" id="latitude" required> 
        <?php $__errorArgs = ['latitude'];
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
            <button class="btn btn-default dropdown-toggle" type="button" 
          id="dropdownMenu1" data-toggle="dropdown" 
          aria-haspopup="true" aria-expanded="true">
            <i class="glyphicon glyphicon-cog"></i>
            <span class="caret"></span>
          </button>
            <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
  
            <li >
              <label>
                <input type="checkbox"> Cheese
              </label>
            </li>
            
            <li >
              <label>
                <input type="checkbox"> Pepperoni
              </label>
            </li>
            
            <li >
              <label>
                <input type="checkbox"> Peppers
              </label>
            </li>
            
          </ul>
            </div>
          
          <div class="col-md-6">
        <label for="altitude">Altitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240"></i>
        <input class="form-control" type="text" name="altitude" id="altitude"> 
        <?php $__errorArgs = ['altitude'];
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
        <label for="artist">Authors</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write author name"></i>
        <input class="form-control" type="text" name="artist" id="artist"> 
        <?php $__errorArgs = ['artist'];
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
        <label for="organation">Organation</label>
        <input class="form-control" type="text" name="organation" id="organation"> 
        <?php $__errorArgs = ['organation'];
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
        <label for="docname">Document_Name</label>
        <input class="form-control" type="text" name="docname" id="docname"> 
        <?php $__errorArgs = ['docname'];
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
        <label for="programname">Program Name</label>
        <input class="form-control" type="text" name="programname" id="programname"> 
        <?php $__errorArgs = ['programname'];
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
          <div class="col-md-4">
        <label for="cameramaker">CAMERA MAKER</label>
        <input class="form-control" type="text" name="cameramaker" id="cameramaker"> 
        <?php $__errorArgs = ['camerameker'];
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
        <label for="cameramodel">CAMERA MODEL</label>
        <input class="form-control" type="text" name="cameramodel" id="cameramodel"> 
        <?php $__errorArgs = ['cameramodel'];
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
          <div class="col-md-3 rating">
        <p style="float:left;" for="rating">Rating</p>
        <!-- <div class="row"> -->
          <input id="star5" name="rating" type="radio" value="5" class="radio-btn hide" />
            <label for="star5" >☆</label>
            <input id="star4" name="rating" type="radio" value="4" class="radio-btn hide" />
            <label for="star4" >☆</label>
            <input id="star3" name="rating" type="radio" value="3" class="radio-btn hide" />
            <label for="star3" >☆</label>
            <input id="star2" name="rating" type="radio" value="2" class="radio-btn hide" />
            <label for="star2" >☆</label>
            <input id="star1" name="rating" type="radio" value="1" class="radio-btn hide" />
            <label for="star1" >☆</label>
            <div class="clear"></div>
        <?php $__errorArgs = ['rating'];
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
  <form method="post" action="<?php echo e(route('upload_image')); ?>"  enctype="multipart/form-data">
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
          <div class="col-md-12">
        <label for="image">Image</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Only jpg and jpeg allowd"></i>
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

  <form method="post" action="<?php echo e(route('editmetadata')); ?>" enctype="multipart/form-data">
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


<!-- Start Add Tags -->
<div class="modal fade" id="tagform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="<?php echo e(route('addmetatag')); ?>">
    <?php echo csrf_field(); ?>
  <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
    
    <div class="modal-content container-fluid">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Tags</h5>
         <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Please Write Ex:-tag1,tag2"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="col-md-12" id="imagename">
            
           </div><br>
           <div class="col-md-12">
             <!-- <input type="text" name="tag" class="form-control"> -->
             <input type="text" name="tag" value="" data-role="tagsinput"/>
           </div>
            </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Yes</button>
          </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
  </div>
</div>
<!-- End Tags -->
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
                 url:'<?php echo e(route('get_exifdata')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "id":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#iptcdata").html("<div class='spinner-grow text-danger'></div>");
                  
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
                 url:'<?php echo e(route('edit_exifdata')); ?>',
                 method:"post",
                 data:{"_token": "<?php echo e(csrf_token()); ?>",
                  "id":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#editiptcdata").html("<div class='spinner-grow text-danger'></div>");
                  
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
                $("#loader").html("<div class='spinner-grow text-danger'></div>");
                  
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
                  window.location = '<?php echo e(route('exifalldata')); ?>';
                  alert('Invalid File Type');
                                    }
        });
        return false;
    });
});
  </script>

  <script type="text/javascript">
    jQuery(document).ready(function ($) {

    $("#metadataform").submit(function (event) {
                event.preventDefault();
                //validation for login form
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '<?php echo e(route('addmetadata')); ?>',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#addmetadataloader").html("<div class='spinner-grow text-danger'></div>");
                  
                // $("#BtnProfile").hide();
              },
                success: function (returndata) 
                {
                    //show return answer
                    $('#Image').modal('hide');
                    $('#tagform').modal('show');
                    $('#imagename').html(returndata);
                    $( '#metadataform' ).each(function(){
                        this.reset();
                    });
                },
                error: function(returndata){
                  $( '#metadataform' ).each(function(){
                        this.reset();
                    });
                  $('#uploadimage').modal('hide');
                  window.location = '<?php echo e(route('exifalldata')); ?>';
                                    }
        });
        return false;
    });
});
  </script>
  <script type="text/javascript">
    $(':radio').change(function() {
  console.log('New star rating: ' + this.value);
});
  </script>


  <script type="text/javascript">
    $(document).ready(function($){
      $('[data-toggle="popover"]').popover()
    });
  </script>
  <script type="text/javascript">
    $(document).on('click', '.allow-focus', function (e) {
  e.stopPropagation();
  $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
   $(this).closest("li").toggleClass("active", this.checked);
});
});
  </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\seo\resources\views/exifdata.blade.php ENDPATH**/ ?>