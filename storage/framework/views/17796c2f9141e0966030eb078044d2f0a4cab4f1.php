

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/costumcss.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-tagsinput.css')); ?>">
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>;

<style type="text/css">
  .show_data{border:none;}
  .cardh{background: #f4f6f9;}
  .qbody{background:white;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper qbody"  style="padding: 2px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Metadata</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container" style="position: relative;">
       <div class="variable">
        <label for="select_fields">Select Fields</label><br>
                <select class="form-select" size="11" aria-label="size 10 select example">
              <option type="button" id="store_code">store_code</option>
              <option type="button" id="store_manager_name">store_manager_name</option> 
              <option type="button" id="business_name">business_name</option>
              <option type="button" id="address">address</option> 
              <option type="button" id="locality">locality</option> 
              <option type="button" id="administrative_area">administrative_area</option>
              <option type="button" id="postal_code">postal_code</option> 
              <option type="button" id="primary_phone">primary_phone</option>
              <option type="button" id="store_alternate_name">store_alternate_name</option>
              <option type="button" id="store_longitude">longitude</option>
              <option type="button" id="store_latitude">latitude</option>

            </select>
            </div>
            </div>
    <div class="container-fluid">
      <form method="post" action="<?php echo e(route('addmetadata')); ?>" enctype="multipart/form-data" id="metadataform">
        <?php echo csrf_field(); ?>
     <div class="row">
          <div class="col-md-12" id="addmetadataloader"></div>
          <div class="col-md-3" id="show">
           <img src="<?php echo e(asset('user_profile_image')); ?>/<?php echo e($filename); ?>">
           <input type='hidden' name='imageurl' value="<?php echo e($filename); ?>">
          </div>
          <div class="col-md-3">
        <label for="title">Title</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image title"></i>
        <input id="title" class="form-control inputHolder" type="text" name="caption">
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
        <input id="" class="form-control inputHolder" type="text" name="description" id="description"> 
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
        <input class="form-control inputHolder" type="text" name="comment" id=""> 
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
        <input class="form-control inputHolder" type="text" name="longitude" id="longitude" required> 
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
        <input class="form-control inputHolder" type="text" name="latitude" id="latitude" required> 
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
        <label for="latitude">Tag</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- tag1 , tag2"></i><br>
        <input class="form-control inputHolder" type="text" name="tag" id="tagsinput" data-role="tagsinput"> 
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
            <div class="form-group">
            <label for="exampleFormControlSelect1">Select Store</label>
            <select class="form-control js-example-basic-multiple" id="exampleFormControlSelect1" name="store[]" multiple="multiple">
                <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$storedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($key); ?>"><?php echo e($key); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </select>
            </div>
            </div>
          <div class="col-md-6">
        <label for="altitude">Altitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240"></i>
        <input class="form-control inputHolder" type="text" name="altitude" id="altitude"> 
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
        <input class="form-control inputHolder" type="text" name="artist" id="artist"> 
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
        <input class="form-control inputHolder" type="text" name="organation" id="organation"> 
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
        <input class="form-control inputHolder" type="text" name="docname" id="docname"> 
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
        <input class="form-control inputHolder" type="text" name="programname" id="programname"> 
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
        <input class="form-control inputHolder" type="text" name="copyright" id="copyright"> 
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
        <input class="form-control inputHolder" type="text" name="cameramaker" id="cameramaker"> 
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
        <input class="form-control inputHolder" type="text" name="cameramodel" id="cameramodel"> 
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
           <button class="btn btn-primary w-100" type="submit">Submit</button>
          </form>
        </div>
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
</div>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
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
    //   jQuery("#btn").on('click', function() {
    //     var $txt = jQuery("#title");
    //     var caretPos = $txt[0].selectionStart;
    //     var textAreaTxt = $txt.val();
    //     var txtToAdd = "stuff";
    //     $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
    // });


$.fn.EnableInsertAtCaret = function() {
$(this).on("focus", function() {        $(".insertatcaretactive").removeClass("insertatcaretactive");
     $(this).addClass("insertatcaretactive");
});
};


function InsertAtCaret(myValue) {

    return $(".insertatcaretactive").each(function(i) {
        if (document.selection) {
            //For browsers like Internet Explorer
            this.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
            this.focus();
        } else if (this.selectionStart || this.selectionStart == '0') {
            //For browsers like Firefox and Webkit based
            var startPos = this.selectionStart;
            var endPos = this.selectionEnd;
            var scrollTop = this.scrollTop;
            this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
            this.focus();
            this.selectionStart = startPos + myValue.length;
            this.selectionEnd = startPos + myValue.length;
            this.scrollTop = scrollTop;
        } else {
            this.value += myValue;
            this.focus();
        }
    })
}
$(".inputHolder,#txtInput").EnableInsertAtCaret();


$('#store_code').click(function() {
    InsertAtCaret('{store_code}');
});
$('#store_manager_name').click(function() {
    InsertAtCaret('{store_manager_name}');
});
$('#business_name').click(function() {
    InsertAtCaret('{business_name}');
});
$('#address').click(function() {
    InsertAtCaret('{address}');
});
$('#locality').click(function() {
    InsertAtCaret('{locality}');
});
$('#administrative_area').click(function() {
    InsertAtCaret('{administrative_area}');
});
$('#postal_code').click(function() {
    InsertAtCaret('{postal_code}');
});
$('#primary_phone').click(function() {
    InsertAtCaret('{primary_phone}');
});
$('#store_alternate_name').click(function() {
    InsertAtCaret('{store_alternate_name}');
});
$('#store_latitude').click(function() {
    InsertAtCaret('{latitude}');
});
$('#store_longitude').click(function() {
    InsertAtCaret('{longitude}');
});
  </script> 
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\seo\resources\views/addmetadata.blade.php ENDPATH**/ ?>