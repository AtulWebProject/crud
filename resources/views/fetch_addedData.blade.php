
@extends('layouts.header')
@section('content');

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
            <!-- <div class="col-md-2">
              <input type="search" name="email" value="{{ $email??null}}" class="form-control" placeholder="by email">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="search" name="role" value="{{ $role??null}}" class="form-control" placeholder="by role">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="date" name="created_at" value="{{ $created_at??null}}" class="form-control" placeholder="by created_at">
            </div> -->
            <!-- <div class="col-md-2">
              <input type="date" name="updated_at" value="{{ $updated_at??null}}" class="form-control" placeholder="by updated_at">
            </div> -->
            <div class="col-md-1">
              <br>
              <button class="btn btn-dark">Search</button>
            </div>
            </form>
            <!-- <div class="col-md-2">
              
                <br>
                <a class="btn btn-warning" href="{{ route('export') }}?search={{request()->get('number')}} & email={{request()->get('email')}} & role={{request()->get('role')}} & created_at={{request()->get('created_at')}} & updated_at={{request()->get('updated_at')}} & name={{request()->get('search')}}">Export Data</a>
           
            </div> -->
            
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
           <th>@sortablelink('Title')</th>
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
           <td>{{$todo->title}}</td>
           <td><img src="{{asset('user_profile_image')}}/{{$todo->image}}" style="height:50px;width:50px"></td>
           <td>{{$todo->created_at}}</td>
           <!-- <td><button class="btn btn-primary metadata" data-toggle="modal" data-target="#Image">Click</button></td> -->
           <td>
            @can("allowUser",$todo)
            <i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            @endcan
            <!-- <a href="{{route('todo_edit',[ base64_encode($todo->id ?? '') ])}}"></a> -->
            <i class="fas fa-pen editiptc" data-toggle="modal" data-target="#editiptc"></i>
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
  <form method="post" action="{{route('addmetadata')}}" enctype="multipart/form-data">
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
          <div class="col-md-3" id="show">
        
          </div>
          <div class="col-md-3">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="caption" id="caption">
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="description">Headline</label>
        <input class="form-control" type="text" name="heading" id="heading"> 
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="description">Name</label>
        <input class="form-control" type="text" name="name" id="name"> 
        @error('name')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <!-- <div class="col-md-3">
        <label for="description">Status</label>
        <input class="form-control" type="text" name="status" id="status"> 
        @error('status')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div> -->
          <div class="col-md-3">
        <label for="description">Category</label>
        <input class="form-control" type="text" name="category" id="category"> 
        @error('category')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="description">Tag</label>
        <input class="form-control" type="text" name="keywords" id="keywords"> 
        @error('keywirds')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="description">Relase_Date</label>
        <input class="form-control" type="text" name="rdate" id="rdate"> 
        @error('rdate')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="originating_program">ORIGINATING_PROGRAM</label>
        <input class="form-control" type="text" name="originating_program" id="originating_program"> 
        @error('originating_program')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="byline">Authors</label>
        <input class="form-control" type="text" name="byline" id="byline"> 
        @error('byline')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
        <label for="byline_title">BYLINE_TITLE</label>
        <input class="form-control" type="text" name="byline_title" id="byline_title"> 
        @error('byline_title')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="city">CITY</label>
        <input class="form-control" type="text" name="city" id="city"> 
        @error('city')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="state">STATE</label>
        <input class="form-control" type="text" name="state" id="state"> 
        @error('state')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="country_code">COUNTRY_CODE</label>
        <input class="form-control" type="text" name="country_code" id="country_code"> 
        @error('country_code')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-3">
        <label for="country">COUNTRY</label>
        <input class="form-control" type="text" name="country" id="country"> 
        @error('country_code')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-12">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control" type="text" name="copyright" id="copyright"> 
        @error('copyright')
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
  <form method="post" action="" id="imageform" enctype="multipart/form-data">
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
          <!-- <div class="col-md-12">
        <label for="image">Title</label>
        <input class="form-control" type="text" name="title" id="title">
        @error('title')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div> -->
          <div class="col-md-12">
        <label for="image">Image</label>
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

  <form method="post" action="{{route('addmetadata')}}" enctype="multipart/form-data">
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
                 url:'{{route('get_iptcdata')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
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
                 url:'{{route('edit_iptcdata')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
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
                url: '{{route('upload_image')}}',
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
                  window.location = '{{route('alldata')}}';
                                    }
        });
        return false;
    });
});
  </script>
@endsection

