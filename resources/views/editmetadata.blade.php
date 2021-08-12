
@extends('layouts.header')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/costumcss.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-tagsinput.css')}}">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endsection
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
            <h1 class="m-0">Edit Metadata</h1>
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
                <select class="form-select" size="9" aria-label="size 10 select example">
              <option type="button" id="store_code">store_code</option>
              <option type="button" id="store_manager_name">store_manager_name</option> 
              <option type="button" id="business_name">business_name</option>
              <option type="button" id="address">address</option> 
              <option type="button" id="locality">locality</option> 
              <option type="button" id="administrative_area">administrative_area</option>
              <option type="button" id="postal_code">postal_code</option> 
              <option type="button" id="primary_phone">primary_phone</option>
              <option type="button" id="store_alternate_name">store_alternate_name</option> 
            </select>
            </div>
            </div>
    <div class="container-fluid">
      <form method="post" action="{{route('editmetadata')}}" enctype="multipart/form-data" id="metadataform">
        @csrf
     <div class="row">
          <div class="col-md-12" id="addmetadataloader"></div>
          <div class="col-md-3" id="show">
           <img src="{{asset('user_profile_image')}}/{{$get['image']}}">
           <input type='hidden' name='imageurl' value="{{$get['image']}}">
           <input type='hidden' name='id' value="{{$id}}">
          </div>
          <div class="col-md-3">
        <label for="title">Title</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image title"></i>
        <input id="title" class="form-control inputHolder" type="text" value="{{$get['description']}}" name="caption">
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="description">Description</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image description"></i>
        <input id="" class="form-control inputHolder" value="{{$get['description']}}" type="text" name="description" id="description"> 
        @error('description')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="comment">Comment</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image comment"></i>
        <input class="form-control inputHolder" type="text" value="{{$get['comment']}}" name="comment" id=""> 
        @error('comment')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="longitude">Longitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240.5214"></i>
        <input class="form-control inputHolder" value="{{$get['longitude']}}" type="text" name="longitude" id="longitude" required> 
        @error('longitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="latitude">Latitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 20.54614"></i>
        <input class="form-control inputHolder" value="{{$get['latitude']}}" type="text" name="latitude" id="latitude" required> 
        @error('latitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="latitude">Tag</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- tag1 , tag2"></i><br>
        <input class="form-control inputHolder" value="{{$get['tag']}}" type="text" name="tag" id="tagsinput" data-role="tagsinput"> 
        @error('latitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
            <div class="form-group">
            <label for="exampleFormControlSelect1">Select Store</label>
            <select class="form-control js-example-basic-multiple" id="exampleFormControlSelect1" name="store[]" multiple="multiple">
                @foreach($store as $key=>$storedata)

              <option value="{{$key}}">{{$key}}</option>
                @endforeach 
            </select>
            </div>
            </div>
          <div class="col-md-6">
        <label for="altitude">Altitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240"></i>
        <input class="form-control inputHolder" type="text" name="altitude" id="altitude"> 
        @error('altitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          
          <div class="col-md-6">
        <label for="artist">Authors</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write author name"></i>
        <input class="form-control inputHolder" value="{{$get['author']}}" type="text" name="artist" id="artist"> 
        @error('artist')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="organation">Organation</label>
        <input class="form-control inputHolder" value="{{$get['organisation']}}" type="text" name="organation" id="organation"> 
        @error('organation')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="docname">Document_Name</label>
        <input class="form-control inputHolder" value="{{$get['document_name']}}" type="text" name="docname" id="docname"> 
        @error('docname')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="programname">Program Name</label>
        <input class="form-control inputHolder" value="{{$get['program_name']}}" type="text" name="programname" id="programname"> 
        @error('programname')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control inputHolder" value="{{$get['copyright']}}" type="text" name="copyright" id="copyright"> 
        @error('copyright')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="cameramaker">CAMERA MAKER</label>
        <input class="form-control inputHolder" value="camera_maker" type="text" name="cameramaker" id="cameramaker"> 
        @error('camerameker')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="cameramodel">CAMERA MODEL</label>
        <input class="form-control inputHolder" value="{{$get['camera_model']}}" type="text" name="cameramodel" id="cameramodel"> 
        @error('cameramodel')
            <p style="color: red">{{$message}}</p>
            @enderror
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
        @error('rating')
            <p style="color: red">{{$message}}</p>
            @enderror
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
@section('js')
<script src="{{asset('js/select2.min.js')}}"></script>
@endsection
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
  </script> 
@endsection

