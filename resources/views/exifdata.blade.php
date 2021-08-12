
@extends('layouts.header')
@section('content');
@section('css')
<link rel="stylesheet" type="text/css" href="../public/css/costumcss.css">
<link rel="stylesheet" type="text/css" href="../public/css/bootstrap-tagsinput.css">

@endsection
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
      
       @if (Session::has('msg'))
       <div class="alert alert-success" role="alert">
        {!! session('msg') !!}
      </div>
      @endif
       @if (Session::has('errormessage'))
       <div class="alert alert-danger" role="alert">
        {!! session('errormessage') !!}
      </div>
      @endif
           @error('profile_image')
            <div class="alert alert-danger" role="alert">
              {{$message}}
            </div>
            @enderror
      <div class="container-fluid">

        <form method="get" action="{{route('searchuserData')}}">
        <div class="row" style="margin-bottom: 1%;">
          <div class="col-md-6">
              <input type="search" name="title" value="{{ $title??null}}" class="form-control" placeholder="by title">
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
              <form id="myForm" method="get" action="{{route('getRowData')}}">
              <!-- @csrf -->
              <div class="col-md-2" style="float: right;">
              <select class="form-select" id="rowfilter" style="width: 100%;" name="rowdataget">
                <option>{{ $rowfilter??null}}</option>
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
           <th>@sortablelink('Store Code')</th>
           <th>@sortablelink('Image')</th>
           <th>@sortablelink('created_at')</th>
           <!-- <th>Add Metadata</th> -->
           <th>action</th>
        </tr>
      </thead>
    <tbody>
      
    
    @foreach($viewdata as $key =>$todo) 
    <tr>
      <td>{{ $no++ }}</td>
      <td class="viewid" style="display: none;">{{$todo->id}}</td>
           <td>{{$todo->store_code}}</td>
           <td><img src="{{asset('user_profile')}}/{{$todo->iconurl}}" style="height:50px;width:50px"></td>
           <td>{{$todo->created_at}}</td>
           <td>
            @can("allowUser",$todo)
            <i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            @endcan
            <a href="{{ route('edit_exifdata')}}/{{$todo->id}}"><i class="fas fa-pen"></i></a>
            <i class="far fa-eye viewdata" data-toggle="modal" data-target="#view_specialities_details"></i>
           </td>
         </tr>
    @endforeach
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
          @csrf
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
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="description">Description</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image description"></i>
        <input class="form-control" type="text" name="description" id="description"> 
        @error('description')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="comment">Comment</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image comment"></i>
        <input class="form-control" type="text" name="comment" id="comment"> 
        @error('comment')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="longitude">Longitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240.5214"></i>
        <input class="form-control" type="text" name="longitude" id="longitude" required> 
        @error('longitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="latitude">Latitude<span class="hint">*</span></label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 20.54614"></i>
        <input class="form-control" type="text" name="latitude" id="latitude" required> 
        @error('latitude')
            <p style="color: red">{{$message}}</p>
            @enderror
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
        @error('altitude')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          
          <div class="col-md-6">
        <label for="artist">Authors</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write author name"></i>
        <input class="form-control" type="text" name="artist" id="artist"> 
        @error('artist')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="organation">Organation</label>
        <input class="form-control" type="text" name="organation" id="organation"> 
        @error('organation')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="docname">Document_Name</label>
        <input class="form-control" type="text" name="docname" id="docname"> 
        @error('docname')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="programname">Program Name</label>
        <input class="form-control" type="text" name="programname" id="programname"> 
        @error('programname')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control" type="text" name="copyright" id="copyright"> 
        @error('copyright')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="cameramaker">CAMERA MAKER</label>
        <input class="form-control" type="text" name="cameramaker" id="cameramaker"> 
        @error('camerameker')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
        <label for="cameramodel">CAMERA MODEL</label>
        <input class="form-control" type="text" name="cameramodel" id="cameramodel"> 
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
  <form method="post" action="{{route('upload_image')}}"  enctype="multipart/form-data">
          @csrf
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
        @error('profile_image')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-12">
            <img id="blah" src="{{asset('img/noimg.png')}}" alt="your image" style="height: 100px;width: 100px;"/>
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

  <form method="post" action="{{route('editmetadata')}}" enctype="multipart/form-data">
          @csrf
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
  <form method="post" action="{{route('addmetatag')}}">
    @csrf
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
<input type="hidden" id="url" value="{{route('upload_image')}}">
<input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />


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
                 url:'{{route('get_exifdata')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
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
                 url:'{{route('edit_exifdata')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
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
                url: '{{route('upload_image')}}',
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
                  window.location = '{{route('exifalldata')}}';
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
                url: '{{route('addmetadata')}}',
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
                  window.location = '{{route('exifalldata')}}';
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
@endsection

