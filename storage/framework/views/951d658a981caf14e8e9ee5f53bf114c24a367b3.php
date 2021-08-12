

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
            <h1 class="m-0">Question</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php if(!empty($viewdata)): ?> 
    <section class="content">
    <div class="container-fluid">
      <div class="card w-100">
     <form method="post" action="<?php echo e(route('submitanswer')); ?>">
      <?php echo csrf_field(); ?>
      <div class="card-header cardh">
        <h3><?php echo e(Session::get("nextq")); ?>:- <?php echo e($viewdata->question); ?></h3>
       <input type="hidden" name="ans" value="<?php echo e($viewdata->rans); ?>">
       <input type="hidden" name="questionid" value="<?php echo e($viewdata->id); ?>">
       </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <?php echo e($viewdata->ans1); ?>

            <input type="radio" name="userans" value="<?php echo e($viewdata->ans1); ?>">
          </li>
          <li class="list-group-item">
            <?php echo e($viewdata->ans2); ?>

            <input type="radio" name="userans" value="<?php echo e($viewdata->ans2); ?>">
          </li>
          <li class="list-group-item">
            <?php echo e($viewdata->ans3); ?>

            <input type="radio" name="userans" value="<?php echo e($viewdata->ans3); ?>">
          </li>
          <li class="list-group-item">
            <?php echo e($viewdata->ans4); ?>

            <input type="radio" name="userans" value="<?php echo e($viewdata->ans4); ?>">
          </li>
          <li class="list-group-item" style="float:right;">
            <button class="btn btn-primary" type="submit">Submit</button>  
             </li>
       
        </ul>
      </div>
      </form>  <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <?php else: ?>
    <section class="content">
    <div class="container-fluid">
      <div class="card w-100">
      <div class="card-header cardh">
        <h3>Exam Not Start Now</h3>
       </div>
      </div>
    </div><!-- /.container-fluid -->
    </section>
    <?php endif; ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
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


<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\laravel1\blog\resources\views/question.blade.php ENDPATH**/ ?>