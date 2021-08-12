<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Testseo;
class IptcController
{
   
  
  public function upload_image(Request $request)
  {
    $request->validate([
        'profile_image' => 'required|image|mimes:jpg,jpeg',
    ]);
      $res=new Testseo;

      if ($request->file('profile_image')) {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalName();
               // $filename = $extension;
               $filename = time() . '.' . $extension;
               $checkalready=Testseo::where('image',$filename)->first();
               //$existimage=$checkalready->image;
               if($checkalready){
                $request->session()->flash('errormessage','Image Already Uploaded, Please Select Other Image!!');
                echo "not update";
             }else{
               $file->move('user_profile_image/',$filename);
               $res->image = $filename;
               $res->original_image_name = $extension;
               $res->title=$request->get('title');
               $res->save();
               $returndata='';
               $returndata .= "<img src='../public/user_profile_image/".$filename."' style='height:100px;width:100px'>";
               $returndata .="<input type='hidden' name='imageurl' value=".$filename.">";
               
              }
               echo $returndata;
           }   
           else{
              $request->session()->flash('msg','Not Update Image Sucessfull!!');
             return redirect()->route('alldata');
           }
             
  }
  public function get_iptcdata(Request $request)
  {
    $id=$request->get('id');
    // dd($id);
    $get=Testseo::where('id',$id)->first();
     $size = getimagesize( '../public/user_profile_image/'.$get->image, $iptch );

    $iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
    $name = isset( $iptc['2#005'] ) ? $iptc['2#005'][0] : '';
    // $subject = isset( $iptc['2#012'] ) ? $iptc['2#012'][0] : 'NA';
    $category = isset( $iptc['2#015'] ) ? $iptc['2#015'][0] : '';
    $keywords = isset( $iptc['2#025'] ) ? $iptc['2#025'][0] : '';
    $Rdate = isset( $iptc['2#030'] ) ? $iptc['2#030'][0] : '';
    $organationP = isset( $iptc['2#065'] ) ? $iptc['2#065'][0] : '';
    $byline = isset( $iptc['2#080'] ) ? $iptc['2#080'][0] : '';
    $byline_title = isset( $iptc['2#085'] ) ? $iptc['2#085'][0] : '';
    $city = isset( $iptc['2#090'] ) ? $iptc['2#090'][0] : '';
    $state = isset( $iptc['2#095'] ) ? $iptc['2#095'][0] : '';
    $country_code = isset( $iptc['2#100'] ) ? $iptc['2#100'][0] : '';
    $country = isset( $iptc['2#101'] ) ? $iptc['2#101'][0] : '';
    $copyright = isset( $iptc['2#116'] ) ? $iptc['2#116'][0] : '';
    $caption = isset( $iptc['2#120'] ) ? $iptc['2#120'][0] : '';
    $heading = isset( $iptc['2#105'] ) ? $iptc['2#105'][0] : '';
    
    $html='';
    $html .="<table class='table'>
              <thead>
              <tr>
                  <center><img src='..\public\user_profile_image/".$get->image."' style='height:100px;width:100px;'></center>
             
                  <th>Name:</th>
                  <td>".$name."</td>
             
                  <th>Headline:</th>
                  <td>".$heading."</td>
             </tr><tr>
                  <th>Title:</th>
                  <td>".$caption."</td>
             
                  <th>Category:</th>
                  <td>".$category."</td>

             </tr><tr>
                  <th>Tag:</th>
                  <td>".$keywords."</td>

             
                  <th>Rdate:</th>
                  <td>".$Rdate."</td>

             </tr><tr>
                  <th>Originating_program:</th>
                  <td>".$organationP."</td>

             
                  <th>Authors:</th>
                  <td>".$byline."</td>

             </tr><tr>
                  <th>Byline_title:</th>
                  <td>".$byline_title."</td>

             
                  <th>City:</th>
                  <td>".$city."</td>

             </tr><tr>
                  <th>State:</th>
                  <td>".$state."</td>

             
                  <th>Country_code:</th>
                  <td>".$country_code."</td>

             </tr><tr>
                  <th>Country:</th>
                  <td>".$country."</td>

             
                  <th>Copyright:</th>
                  <td>".$copyright."</td>

             </tr>
            </tbody>
          </table>";
     echo $html;
  }



  public function edit_iptcdata(Request $request)
  {
    $id=$request->get('id');
    // dd($id);
    $get=Testseo::where('id',$id)->first();
     $size = getimagesize( '../public/user_profile_image/'.$get->image, $iptch );
     $imagename=$get->image;

    $iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
    $name = isset( $iptc['2#005'] ) ? $iptc['2#005'][0] : '';
    // $subject = isset( $iptc['2#012'] ) ? $iptc['2#012'][0] : 'NA';
    $category = isset( $iptc['2#015'] ) ? $iptc['2#015'][0] : '';
    $keywords = isset( $iptc['2#025'] ) ? $iptc['2#025'][0] : '';
    $Rdate = isset( $iptc['2#030'] ) ? $iptc['2#030'][0] : '';
    $organationP = isset( $iptc['2#065'] ) ? $iptc['2#065'][0] : '';
    $byline = isset( $iptc['2#080'] ) ? $iptc['2#080'][0] : '';
    $byline_title = isset( $iptc['2#085'] ) ? $iptc['2#085'][0] : '';
    $city = isset( $iptc['2#090'] ) ? $iptc['2#090'][0] : '';
    $state = isset( $iptc['2#095'] ) ? $iptc['2#095'][0] : '';
    $country_code = isset( $iptc['2#100'] ) ? $iptc['2#100'][0] : '';
    $country = isset( $iptc['2#101'] ) ? $iptc['2#101'][0] : '';
    $copyright = isset( $iptc['2#116'] ) ? $iptc['2#116'][0] : '';
    $caption = isset( $iptc['2#120'] ) ? $iptc['2#120'][0] : '';
    $heading = isset( $iptc['2#105'] ) ? $iptc['2#105'][0] : '';
    
    $html='';
    $html .='<div class="col-md-3">
            <center><img src="..\public\user_profile_image/'.$imagename.'" style="height:100px;width:100px"></center>
        <input type="hidden" value='.$imagename.' name="imageurl">
        
          </div>
    <div class="col-md-3">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="caption" id="caption"n value='.$caption.'>
        <input type="hidden" value='.$imagename.' name="imageurl">
        
          </div>
          <div class="col-md-3">
        <label for="description">Headline</label>
        <input class="form-control" type="text" name="heading" id="heading" value='.$heading.'> 
        
          </div>
          <div class="col-md-3">
        <label for="description">Name</label>
        <input class="form-control" type="text" name="name" id="name" value='.$name.'> 
        
          </div>
          <div class="col-md-3">
        <label for="description">Category</label>
        <input class="form-control" type="text" name="category" id="category" value='.$category.'> 
        
          </div>
          <div class="col-md-6">
        <label for="description">Tag</label>
        <input class="form-control" type="text" name="keywords" id="keywords" value='.$keywords.'> 
        
          </div>
          <div class="col-md-6">
        <label for="description">Relase_Date</label>
        <input class="form-control" type="text" name="rdate" id="rdate" value='.$Rdate.'> 
        
          </div>
          <div class="col-md-6">
        <label for="originating_program">ORIGINATING_PROGRAM</label>
        <input class="form-control" type="text" name="originating_program" id="originating_program" value='.$organationP.'> 
        
          </div>
          <div class="col-md-6">
        <label for="byline">Authors</label>
        <input class="form-control" type="text" name="byline" id="byline" value='.$byline.'> 
        
          </div>
          <div class="col-md-6">
        <label for="byline_title">BYLINE_TITLE</label>
        <input class="form-control" type="text" name="byline_title" id="byline_title" value='.$byline_title.'> 
        
          </div>
          <div class="col-md-3">
        <label for="city">CITY</label>
        <input class="form-control" type="text" name="city" id="city" value='.$city.'> 
          </div>
          <div class="col-md-3">
        <label for="state">STATE</label>
        <input class="form-control" type="text" name="state" id="state" value='.$state.'> 
        
          </div>
          <div class="col-md-3">
        <label for="country_code">COUNTRY_CODE</label>
        <input class="form-control" type="text" name="country_code" id="country_code" value='.$country_code.'> 
        
          </div>
          <div class="col-md-3">
        <label for="country">COUNTRY</label>
        <input class="form-control" type="text" name="country" id="country" value='.$country.'> 
        
          </div>
          <div class="col-md-12">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control" type="text" name="copyright" id="copyright" value='.$copyright.'> 
        
          </div>';
     echo $html;
  }

  
  

	    public function addmetadata(Request $request)
      {
        define("IPTC_OBJECT_NAME", "005");
        define("IPTC_EDIT_STATUS", "007");
        define("IPTC_SUBJECT", "012");
        define("IPTC_PRIORITY", "010");
        define("IPTC_CATEGORY", "015");
        define("IPTC_SUPPLEMENTAL_CATEGORY", "020");
        define("IPTC_FIXTURE_IDENTIFIER", "022");
        define("IPTC_KEYWORDS", "025");
        define("IPTC_RELEASE_DATE", "030");
        define("IPTC_RELEASE_TIME", "035");
        define("IPTC_SPECIAL_INSTRUCTIONS", "040");
        define("IPTC_REFERENCE_SERVICE", "045");
        define("IPTC_REFERENCE_DATE", "047");
        define("IPTC_REFERENCE_NUMBER", "050");
        define("IPTC_CREATED_DATE", "055");
        define("IPTC_CREATED_TIME", "060");
        define("IPTC_ORIGINATING_PROGRAM", "065");
        define("IPTC_PROGRAM_VERSION", "070");
        define("IPTC_OBJECT_CYCLE", "075");
        define("IPTC_BYLINE", "080");
        define("IPTC_BYLINE_TITLE", "085");
        define("IPTC_CITY", "090");
        define("IPTC_PROVINCE_STATE", "095");
        define("IPTC_COUNTRY_CODE", "100");
        define("IPTC_COUNTRY", "101");
        define("IPTC_ORIGINAL_TRANSMISSION_REFERENCE", "103");
        define("IPTC_HEADLINE", "105");
        define("IPTC_CREDIT", "110");
        define("IPTC_SOURCE", "115");
        define("IPTC_COPYRIGHT_STRING", "116");
        define("IPTC_CAPTION", "120");
        define("IPTC_LOCAL_CAPTION", "121");
      	

        $caption=$request->get('caption');
        $heading=$request->get('heading');
        $name=$request->get('name');
        $status=$request->get('status');
        $category=$request->get('category');
        $keywords=$request->get('keywords');
        $rdate=$request->get('rdate');
        $originating_program=$request->get('originating_program');
        $byline=$request->get('byline');
        $byline_title=$request->get('byline_title');
        $city=$request->get('city');
        $state=$request->get('state');
        $country_code=$request->get('country_code');
        $country=$request->get('country');
        $copyright=$request->get('copyright');
        // dd($heading);
	      $imgfile=$request->get('imageurl');
        // $extension = $imgfile->getClientOriginalName();
        
        $filename='..\public\user_profile_image/'.$imgfile;
        //$file=Testseo::alldata($filename);
         
        $objIPTC=new Testseo;
        $objIPTC->url($filename);
        $res = Testseo::where('image', $imgfile)->first();
        $res->title=$heading;
        $res->save();
        
        
          //set title
        $objIPTC->setValue(IPTC_HEADLINE, $heading);
        
        
          //set description
        $objIPTC->setValue(IPTC_CAPTION, $caption);
       
       
          $objIPTC->setValue(IPTC_OBJECT_NAME, $name);
       
        
          // $objIPTC->setValue(IPTC_EDIT_STATUS, $status);
       
        
          $objIPTC->setValue(IPTC_CATEGORY, $category);
        
        
          $objIPTC->setValue(IPTC_KEYWORDS, $keywords);
      
        
          $objIPTC->setValue(IPTC_RELEASE_DATE, $rdate);
      
       
          $objIPTC->setValue(IPTC_ORIGINATING_PROGRAM, $originating_program);
       
        
          $objIPTC->setValue(IPTC_BYLINE, $byline);
       
        
          $objIPTC->setValue(IPTC_BYLINE_TITLE, $byline_title);
       
       
         $objIPTC->setValue(IPTC_CITY, $city);
        
       
          $objIPTC->setValue(IPTC_PROVINCE_STATE, $state);
        
       
          $objIPTC->setValue(IPTC_COUNTRY_CODE, $country_code);
       
       
          $objIPTC->setValue(IPTC_COUNTRY, $country);
        
        
          $objIPTC->setValue(IPTC_COPYRIGHT_STRING, $copyright);
       
        if($objIPTC){
          $request->session()->flash('msg','Add Image Metadata Sucessfull!!');
           return redirect()->route('alldata');
        }
        
}
 

}
