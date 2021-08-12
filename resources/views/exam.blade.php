
@extends('layouts.header')
@section('content');

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
    <section class="content">
      
    <div class="container-fluid">
      <div class="card w-100">
        <div class="row">
        <div class="col-md-6">
        <form method="post" action="{{route('start_exam')}}">
            @csrf
            <input type="hidden" name="type" value="q">
        <button class="btn btn-primary w-100">Quiz</button>
        </form>
        </div>
        <div class="col-md-6">
        
          <form method="post" action="{{route('start_exam')}}">
            @csrf
            <input type="hidden" name="type" value="r">
        <button class="btn btn-primary w-100">Regular</button>
        </form>
        
        </div>
        </div>
      </div>
     
    </div><!-- /.container-fluid -->
    </section>
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
                 url:'{{route('todo_view')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
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
@endsection

