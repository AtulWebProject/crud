<?php
namespace App\Http\Controllers;
use App\Seo;
use Illuminate\Http\Request;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelEntryByte;
use lsolesen\pel\PelEntryRational;
use lsolesen\pel\PelEntryUserComment;
use lsolesen\pel\PelEntryShort;
use lsolesen\pel\PelEntryCopyright;
use lsolesen\pel\PelJpegComment;
use lsolesen\pel\PelExif;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelTiff;
use App\Testseo;
use Redirect; 
use App\Jobs\AddMetadataJob;
use App\Jobs\Editjob;
class GpsController
{

public function index(Request $request)
{
         
        $title=$request->get('title');
        $profile_image=$request->get('profile_image');
        $store = Config('storedata.store');
        $searchdata = [];
        if(!empty($request->get('title'))) {
                $searchdata[]= ['title','like','%'.filter_var($request->get('title'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('profile_image'))) {
                $searchdata[]= ['original_image_name','=',filter_var($request->get('profile_image'),FILTER_SANITIZE_STRING)];
            }
            $viewdata = Seo::SearchUserData($searchdata);
            // dd($viewdata);
               return view('exifdata',compact('viewdata','title','store'))->with('no', 1);
            
            
        

    }

public function upload_image(Request $request)
  {
    
    $request->validate([
        'profile_image' => 'required|image|mimes:jpg,jpeg',
    ]);
      $store = Config('storedata.store');
      $res=new Testseo;

      if ($request->file('profile_image')) {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalName();
               // $filename = $extension;
               $filename = $extension;
               $checkalready=Testseo::where('image',$filename)->first();
               //$existimage=$checkalready->image;
               if($checkalready){
                $request->session()->flash('errormessage','Image Already Uploaded, Please Select Other Image!!');
                echo "not update";
             }else{
               $file->move('user_profile_image/',$filename);
               // $res->image = $filename;
               // $res->original_image_name = $extension;
               // $res->title=$request->get('title');
               // $res->save();
               // $returndata='';
               // $returndata .= "<img src='../public/user_profile_image/".$filename."' style='height:100px;width:100px'>";
               // $returndata .="<input type='hidden' name='imageurl' value=".$filename.">";
               
              }
             return view('addmetadata',compact('filename','store'));
               //echo $returndata;
           }   
           else{
              $request->session()->flash('msg','Not Update Image Sucessfull!!');
             return redirect()->route('alldata');
           }
             
  }
function getCoord( $expr ) {
    $expr_p = explode( '/', $expr );
    return $expr_p[0] / $expr_p[1];
}

  public function get_exifdata(Request $request)
  {
    $id=$request->get('id');
    $get=Testseo::where('id',$id)->first();
     // dd($get['store_code']);
   //   $fp = fopen('../public/user_profile/'.$get->iconurl, 'rb');

   //  $headers = exif_read_data($fp);
    
   //  $exif = exif_read_data($fp, 0, true);
   // // dd($headers);
   //  $latitude['degrees']='';
   //  $latitude['minutes']='';
   //  $latitude['seconds']='';
   //  $longitude['degrees']='';
   //  $longitude['minutes']='';
   //  $longitude['seconds']='';

   //  // Latitude
   //  $latitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLatitude'][0] );
   //  $latitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLatitude'][1] );
   //  $latitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLatitude'][2] );

   //  $latitude['minutes'] += 60 * ($latitude['degrees'] - floor($latitude['degrees']));
   //  $latitude['degrees'] = floor($latitude['degrees']);

   //  $latitude['seconds'] += 60 * ($latitude['minutes'] - floor($latitude['minutes']));
   //  $latitude['minutes'] = floor($latitude['minutes']);

   //  // Longitude
   //  $longitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLongitude'][0] );
   //  $longitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLongitude'][1] );
   //  $longitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLongitude'][2] );

   //  $longitude['minutes'] += 60 * ($longitude['degrees'] - floor($longitude['degrees']));
   //  $longitude['degrees'] = floor($longitude['degrees']);

   //  $longitude['seconds'] += 60 * ($longitude['minutes'] - floor($longitude['minutes']));
   //  $longitude['minutes'] = floor($longitude['minutes']);

   //  //  Start convert DMS to DD
   //  $DMStoDDlatitude= $latitude['degrees']+((($latitude['minutes']*60)+($latitude['seconds']))/3600);
   //  $DMStoDDlongitude= $longitude['degrees']+((($longitude['minutes']*60)+($longitude['seconds']))/3600);
   //  // End convert DMS to DD
   //  $size = getimagesize( '../public/user_profile/'.$get->iconurl, $iptch );
   //  $iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
   //  $keywords = isset( $iptc['2#025'] ) ? $iptc['2#025'][0] : '';
   //  //dd($keywords);
     $starNumber=$get['rating'];
     $r='';
    for($x=1;$x<=$starNumber;$x++)
     {
        $r .='<img style="width:10%; height:10%;" src=../public/img/star.png />';
     }
    $html='';
    $html .="<table class='table'>
              <thead>
              <tr>
                  <center><img src='..\public\user_profile/".$get['iconurl']."' style='height:100px;width:100px;'></center>
             
                  <th>File Name:</th>
                  <td>".$get['iconurl']."</td>
             
                  <th>Store Code:</th>
                  <td>".$get['store_code']."</td>
             </tr><tr>
                  <th>Description:</th>
                  <td>".$get['description']."</td>
             
                  <th>Comment:</th>
                  <td>".$get['comment']."</td>

             </tr><tr>
                  <th>Rating:</th>
                  <td style='display:flex;'>".$r."</td>

             
                  <th>Authors:</th>
                  <td>".$get['author']."</td>

             </tr><tr>
                  <th>Organation:</th>
                  <td>".$get['orientation']."</td>

             
                  <th>Document_Name:</th>
                  <td>".$get['document_name']."</td>

             </tr><tr>
                  <th>Program Name:</th>
                  <td>".$get['program_name']."</td>

                  <th>Copyright:</th>
                  <td>".$get['copyright']."</td>

             </tr><tr>
                  <th>Latitude:</th>
                  <td>".$get['latitude']."</td>

                  <th>Longitude:</th>
                  <td>".$get['longitude']."</td>

             </tr>
             <tr>
                  <th>Camera Model:</th>
                  <td>".$get['camera_model']."</td>

                  <th>Camera Maker:</th>
                  <td>".$get['camera_maker']."</td>

             </tr>
             <tr>
             <th>keywords:</th>
                  <td>".$get['tag']."</td>
             </tr>
            </tbody>
          </table>";
     echo $html;
  }
function convertDecimalToDMS($degree)
{
	//$degree='12.456';
    if ($degree > 180 || $degree < - 180) {
        return null;
    }

    $degree = abs($degree); // make sure number is positive
                            // (no distinction here for N/S
                            // or W/E).

    $seconds = $degree * 3600; // Total number of seconds.

    $degrees = floor($degree); // Number of whole degrees.
    $seconds -= $degrees * 3600; // Subtract the number of seconds
                                 // taken by the degrees.

    $minutes = floor($seconds / 60); // Number of whole minutes.
    $seconds -= $minutes * 60; // Subtract the number of seconds
                               // taken by the minutes.

    $seconds = round($seconds * 100, 0); // Round seconds with a 1/100th
                                         // second precision.

    return [
        [
            $degrees,
            1
        ],
        [
            $minutes,
            1
        ],
        [
            $seconds,
            100
        ]
    ];
}
public function addGpsInfo(Request $request){
    $request->validate([
        'longitude' => 'required',
        'latitude' => 'required',
    ]);
     $description=$request->get('description');
     $comment=$request->get('comment');
     $model=$request->get('cameramodel');
     $longitude=$request->get('longitude');
     $latitude=$request->get('latitude');
     $copyright=$request->get('copyright');
     $artist=$request->get('artist');
     $organation=$request->get('organation');
     $docname=$request->get('docname');
     $programname=$request->get('programname');
     $cameramaker=$request->get('cameramaker');
     $rating=$request->get('rating');
     $tag=$request->get('tag');
    // $result = str_replace("{description}", "1", $request->get('description'));
    $storedata=$request->get('store');
    $imageurl=$request->get('imageurl');
    AddMetadataJob::dispatch($storedata,$imageurl,$description,$comment,$model,$longitude,$latitude,$copyright,$artist,$organation,$docname,$programname,$cameramaker,$rating,$tag);
    return redirect()->route('exifalldata');
    
}
public function edit_exifdata(Request $request ,$id)
  {
    //$id=$request->get('id');
    $store = Config('storedata.store');
    $get=Testseo::where('id',$id)->first();
    //dd($get);
    return view('editmetadata',compact('get','store','id'));
  }



  public function editGpsInfo(Request $request){
    $request->validate([
        'longitude' => 'required',
        'latitude' => 'required',
    ]);
     $description=$request->get('description');
     $comment=$request->get('comment');
     $model=$request->get('cameramodel');
     $longitude=$request->get('longitude');
     $latitude=$request->get('latitude');
     $copyright=$request->get('copyright');
     $artist=$request->get('artist');
     $organation=$request->get('organation');
     $docname=$request->get('docname');
     $programname=$request->get('programname');
     $cameramaker=$request->get('cameramaker');
     $rating=$request->get('rating');
     $tag=$request->get('tag');
     $id=$request->get('id');
    // $result = str_replace("{description}", "1", $request->get('description'));
    $storedata=$request->get('store');
    $imageurl=$request->get('imageurl');
    Editjob::dispatch($storedata,$imageurl,$description,$comment,$model,$longitude,$latitude,$copyright,$artist,$organation,$docname,$programname,$cameramaker,$rating,$tag,$id);
    return redirect()->route('exifalldata');
}

// function testing=================================

public function addmetatag(Request $request){

     define("IPTC_KEYWORDS", "025");

    $tag=$request->get('tag');
    //dd($tag);
     $imgfile=$request->get('imageurl');
     $filename='..\public\user_profile/'.$imgfile;
     $objIPTC=new Testseo;
     $objIPTC->url($filename);
     $objIPTC->setValue(IPTC_KEYWORDS, $tag);
      $request->session()->flash('msg','Add Image Metadata Sucessfull!!');
         return Redirect::back();
}

public function test()
{
    $store = Config('storedata.store')['store1'];
    dd($store);
}
}
?>