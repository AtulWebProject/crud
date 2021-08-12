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
     
     $fp = fopen('../public/user_profile/'.$get->image, 'rb');

    $headers = exif_read_data($fp);
    
    $exif = exif_read_data($fp, 0, true);
   // dd($headers);
    $latitude['degrees']='';
    $latitude['minutes']='';
    $latitude['seconds']='';
    $longitude['degrees']='';
    $longitude['minutes']='';
    $longitude['seconds']='';

    // Latitude
    $latitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLatitude'][0] );
    $latitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLatitude'][1] );
    $latitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLatitude'][2] );

    $latitude['minutes'] += 60 * ($latitude['degrees'] - floor($latitude['degrees']));
    $latitude['degrees'] = floor($latitude['degrees']);

    $latitude['seconds'] += 60 * ($latitude['minutes'] - floor($latitude['minutes']));
    $latitude['minutes'] = floor($latitude['minutes']);

    // Longitude
    $longitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLongitude'][0] );
    $longitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLongitude'][1] );
    $longitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLongitude'][2] );

    $longitude['minutes'] += 60 * ($longitude['degrees'] - floor($longitude['degrees']));
    $longitude['degrees'] = floor($longitude['degrees']);

    $longitude['seconds'] += 60 * ($longitude['minutes'] - floor($longitude['minutes']));
    $longitude['minutes'] = floor($longitude['minutes']);

    //  Start convert DMS to DD
    $DMStoDDlatitude= $latitude['degrees']+((($latitude['minutes']*60)+($latitude['seconds']))/3600);
    $DMStoDDlongitude= $longitude['degrees']+((($longitude['minutes']*60)+($longitude['seconds']))/3600);
    // End convert DMS to DD
    $size = getimagesize( '../public/user_profile/'.$get->image, $iptch );
    $iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
    $keywords = isset( $iptc['2#025'] ) ? $iptc['2#025'][0] : '';
    //dd($keywords);
    $starNumber=$headers['UndefinedTag:0x4746'];
    $r='';
    for($x=1;$x<=$starNumber;$x++)
     {
        $r .='<img style="width:10%; height:10%;" src=../public/img/star.png />';
     }
    $html='';
    $html .="<table class='table'>
              <thead>
              <tr>
                  <center><img src='..\public\user_profile/".$headers['FileName']."' style='height:100px;width:100px;'></center>
             
                  <th>File Name:</th>
                  <td>".$headers['FileName']."</td>
             
                  <th>Title:</th>
                  <td>".$headers['ImageDescription']."</td>
             </tr><tr>
                  <th>Description:</th>
                  <td>".$headers['ImageDescription']."</td>
             
                  <th>Comment:</th>
                  <td>".$headers['COMPUTED']['UserComment']."</td>

             </tr><tr>
                  <th>Rating:</th>
                  <td style='display:flex;'>".$r."</td>

             
                  <th>Authors:</th>
                  <td>".$headers['Artist']."</td>

             </tr><tr>
                  <th>Organation:</th>
                  <td>".$headers['Orientation']."</td>

             
                  <th>Document_Name:</th>
                  <td>".$headers['DocumentName']."</td>

             </tr><tr>
                  <th>Program Name:</th>
                  <td>".$headers['Software']."</td>

                  <th>Copyright:</th>
                  <td>".$headers['Copyright']."</td>

             </tr><tr>
                  <th>Latitude:</th>
                  <td>".$DMStoDDlatitude."</td>

                  <th>Longitude:</th>
                  <td>".$DMStoDDlongitude."</td>

             </tr>
             <tr>
                  <th>Camera Model:</th>
                  <td>".$headers['Model']."</td>

                  <th>Camera Maker:</th>
                  <td>".$headers['Make']."</td>

             </tr>
             <tr>
             <th>keywords:</th>
                  <td>".$keywords."</td>
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
    $imageurl=$request->get('imageurl');
    $title=$request->get('caption');
    $input='..\public\user_profile_image/'.$imageurl;
    $output='F:\xampp\htdocs\seo\public\user_profile/'.$imageurl;
    $description=$request->get('description');
    $comment=$request->get('comment');
    $model=$request->get('cameramodel');
    $longitude=$request->get('longitude');
    $latitude=$request->get('latitude');
    //$altitude=$request->get('altitude');
    $date_time='06-08-2021';
    $tags=$request->get('copyright');
    $tag=$request->get('tags');
    $width='512';
    $rating=$request->get('rating');
    $artist=$request->get('artist');
    $organation=$request->get('organation');
    $docname=$request->get('docname');
    $programname=$request->get('programname');
    $copyright=$request->get('copyright');
    $cameramaker=$request->get('cameramaker');

	 /* Load the given image into a PelJpeg object */
    $jpeg = new PelJpeg($input);
    /*
     * Create and add empty Exif data to the image (this throws away any
     * old Exif data in the image).
     */
    $exif = new PelExif();
    $jpeg->setExif($exif);

    /*
     * Create and add TIFF data to the Exif data (Exif data is actually
     * stored in a TIFF format).
     */
    $tiff = new PelTiff();
    $exif->setTiff($tiff);

    /*
     * Create first Image File Directory and associate it with the TIFF
     * data.
     */
    $ifd0 = new PelIfd(PelIfd::IFD0);
    $tiff->setIfd($ifd0);

    /*
     * Create a sub-IFD for holding GPS information. GPS data must be
     * below the first IFD.
     */
    $gps_ifd = new PelIfd(PelIfd::GPS);
    $ifd0->addSubIfd($gps_ifd);

    /*
     * The USER_COMMENT tag must be put in a Exif sub-IFD under the
     * first IFD.
     */
    $exif_ifd = new PelIfd(PelIfd::EXIF);
    $exif_ifd->addEntry(new PelEntryUserComment($comment));
    $ifd0->addSubIfd($exif_ifd);

    $inter_ifd = new PelIfd(PelIfd::INTEROPERABILITY);
    $ifd0->addSubIfd($inter_ifd);

    $ifd0->addEntry(new PelEntryAscii(PelTag::MODEL, $model));
    $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
    $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description));
    $ifd0->addEntry(new PelEntryAscii(PelTag::COPYRIGHT, $tags));
    $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_WIDTH, $width));
    $ifd0->addEntry(new PelEntryAscii(PelTag::RATING, $rating));
    $ifd0->addEntry(new PelEntryAscii(PelTag::ARTIST, $artist));
    $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
    $ifd0->addEntry(new PelEntryAscii(PelTag::ORIENTATION, $organation));

 // test
    $ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, $docname));
    $ifd0->addEntry(new PelEntryAscii(PelTag::MAKE, $cameramaker));
    $ifd0->addEntry(new PelEntryAscii(PelTag::SOFTWARE, $programname));
    $ifd0->addEntry(new PelEntryAscii(PelTag::COMPRESSION, 'COMPRESSION'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::PHOTOMETRIC_INTERPRETATION, 'PHOTOMETRIC_INTERPRETATION'));
    //$ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, 'DOCUMENT_NAME'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_OFFSETS, 'STRIP_OFFSETS'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::SAMPLES_PER_PIXEL, 'SAMPLES_PER_PIXEL'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::ROWS_PER_STRIP, 'ROWS_PER_STRIP'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_BYTE_COUNTS, 'STRIP_BYTE_COUNTS'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::X_RESOLUTION, 'X_RESOLUTION'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::Y_RESOLUTION, 'Y_RESOLUTION'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::PLANAR_CONFIGURATION, 'PLANAR_CONFIGURATION'));
      //$ifd0->addEntry(new PelEntryAscii(PelTag::RESOLUTION_UNIT, 'RESOLUTION_UNIT'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::TRANSFER_FUNCTION, 'TRANSFER_FUNCTION'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::WHITE_POINT, 'WHITE_POINT'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::PRIMARY_CHROMATICITIES, 'PRIMARY_CHROMATICITIES'));
     
      $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT, 'JPEG_INTERCHANGE_FORMAT'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT_LENGTH, 'JPEG_INTERCHANGE_FORMAT_LENGTH'));
     //End Test


    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));
    if($latitude != ''){
    /*
     * Use the convertDecimalToDMS function to convert the latitude from
     * something like 12.34� to 12� 20' 42"
     */
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($latitude);

    /* We interpret a negative latitude as being south. */
    $latitude_ref = ($latitude < 0) ? 'S' : 'N';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));
    }
    if($longitude != ''){

    /* The longitude works like the latitude. */
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($longitude);
    $longitude_ref = ($longitude < 0) ? 'W' : 'E';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));
    }

    /*
     * Add the altitude. The absolute value is stored here, the sign is
     * stored in the GPS_ALTITUDE_REF tag below.
     */
    // $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
    //     abs($altitude),
    //     1
    // ]));
    /*
     * The reference is set to 1 (true) if the altitude is below sea
     * level, or 0 (false) otherwise.
     */
    // $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));

    /* Finally we store the data in the output file. */
    file_put_contents($output, $jpeg->getBytes());

    // $returndata='';
    // $returndata .= "<img src='../public/user_profile_image/".$imageurl."' style='height:100px;width:100px'>";
    // $returndata .="<input type='hidden' name='imageurl' value=".$imageurl.">";
    if (file_put_contents($output, $jpeg->getBytes())) {
        define("IPTC_KEYWORDS", "025");
         $filename='..\public\user_profile/'.$imageurl;
         $objIPTC=new Testseo;
         $objIPTC->url($filename);
         $objIPTC->setValue(IPTC_KEYWORDS, $tag);
        $res = Testseo::where('image', $imageurl)->first();
        $res->title=$title;
        $res->save();
        // $request->session()->flash('msg','Add Image Metadata Sucessfull!!');
         return redirect()->route('exifalldata');
        //echo $returndata;
    }
    
}


public function edit_exifdata(Request $request)
  {
    $id=$request->get('id');
    // dd($id);
    $get=Testseo::where('id',$id)->first();
     $fp = fopen('../public/user_profile/'.$get->image, 'rb');
     
    $headers = exif_read_data($fp);
    $artist=$headers['Artist'];
    
    $exif = exif_read_data($fp, 0, true);
    //dd($headers);
    // Latitude
    $latitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLatitude'][0] );
    $latitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLatitude'][1] );
    $latitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLatitude'][2] );

    $latitude['minutes'] += 60 * ($latitude['degrees'] - floor($latitude['degrees']));
    $latitude['degrees'] = floor($latitude['degrees']);

    $latitude['seconds'] += 60 * ($latitude['minutes'] - floor($latitude['minutes']));
    $latitude['minutes'] = floor($latitude['minutes']);

    // Longitude
    $longitude['degrees'] = $this->getCoord( $exif['GPS']['GPSLongitude'][0] );
    $longitude['minutes'] = $this->getCoord( $exif['GPS']['GPSLongitude'][1] );
    $longitude['seconds'] = $this->getCoord( $exif['GPS']['GPSLongitude'][2] );

    $longitude['minutes'] += 60 * ($longitude['degrees'] - floor($longitude['degrees']));
    $longitude['degrees'] = floor($longitude['degrees']);

    $longitude['seconds'] += 60 * ($longitude['minutes'] - floor($longitude['minutes']));
    $longitude['minutes'] = floor($longitude['minutes']);
    //  Start convert DMS to DD
    $DMStoDDlatitude= $latitude['degrees']+((($latitude['minutes']*60)+($latitude['seconds']))/3600);
    $DMStoDDlongitude= $longitude['degrees']+((($longitude['minutes']*60)+($longitude['seconds']))/3600);
    // End convert DMS to DD
    $size = getimagesize( '../public/user_profile/'.$get->image, $iptch );
    $iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
    $keywords = isset( $iptc['2#025'] ) ? $iptc['2#025'][0] : '';
    
    $html='';
    $html .='<div class="col-md-3">
            <center><img src="..\public\user_profile_image/'.$get->image.'" style="height:100px;width:100px"></center>
        <input type="hidden" value='.$get->image.' name="imageurl">
        
          </div>
        <div class="col-md-3">
        <label for="title">Title</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image title"></i>
        <input class="form-control" value="'.$headers['ImageDescription'].'" type="text" name="caption" id="caption">
        
          </div>
          <div class="col-md-3">
        <label for="description">Description</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image description"></i>
        <input class="form-control" value="'.$headers['ImageDescription'].'" type="text" name="description" id="description"> 
        
          </div>
          <div class="col-md-3">
        <label for="comment">Comment</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write your image comment"></i>
        <input class="form-control" value="'.$headers['COMPUTED']['UserComment'].'" type="text" name="comment" id="comment"> 
        
          </div>
          
          <div class="col-md-3">
        <label for="longitude">Longitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240.5214"></i>
        <input class="form-control" type="text" value="'.$DMStoDDlongitude.'" name="longitude" id="longitude" required> 
        
          </div>
          <div class="col-md-6">
        <label for="latitude">Latitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 20.54614"></i>
        <input class="form-control" type="text" value="'.$DMStoDDlatitude.'" name="latitude" id="latitude" required> 
        
          </div>
          <div class="col-md-3">
        <label for="Keywords">Keywords</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- tag1 , tag2"></i>
        <input class="form-control" type="text" value="'.$keywords.'" name="tags" id="Keywords"> 
        
        
        
          </div>
          <div class="col-md-6">
        <label for="altitude">Altitude</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Example:- 240"></i>
        <input class="form-control"  type="text" name="altitude" id="altitude"> 
        
          </div>
          <div class="col-md-6">
        <label for="rating">Rating</label>
        <select class="form-control" aria-label="Default select example" name="rating">
          <option  selected>'.$headers['UndefinedTag:0x4746'].'</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
        
          </div>
          <div class="col-md-6">
        <label for="artist">Authors</label>
        <i class="bi bi-question-circle-fill" data-toggle="popover" data-placement="top" data-content="Write author name"></i>
        <input class="form-control" type="text" name="artist" id="artist" value="'.$headers['Artist'].'"> 
        
          </div>
          <div class="col-md-6">
        <label for="organation">Organation</label>
        <input class="form-control" value="'.$headers['Orientation'].'" type="text" name="organation" id="organation"> 
        
          </div>
          <div class="col-md-3">
        <label for="docname">Document_Name</label>
        <input class="form-control" value="'.$headers['DocumentName'].'" type="text" name="docname" id="docname"> 
       
          </div>
          <div class="col-md-3">
        <label for="programname">Program Name</label>
        <input class="form-control" value="'.$headers['Software'].'" type="text" name="programname" id="programname"> 
        
          </div>

          <div class="col-md-4">
        <label for="copyright">COPYRIGHT</label>
        <input class="form-control" value="'.$headers['Copyright'].'" type="text" name="copyright" id="copyright"> 
        
          </div>
          <div class="col-md-4">
        <label for="cameramaker">CAMERA MAKER</label>
        <input class="form-control" value="'.$headers['Make'].'" type="text" name="cameramaker" id="cameramaker"> 
          </div>
          <div class="col-md-4">
        <label for="cameramodel">CAMERA MODEL</label>
        <input class="form-control" value="'.$headers['Model'].'" type="text" name="cameramodel" id="cameramodel"> 
          </div>';
     echo $html;
  }


  public function editGpsInfo(Request $request){
    $request->validate([
        'longitude' => 'required',
        'latitude' => 'required',
    ]);
    $imageurl=$request->get('imageurl');
    $title=$request->get('caption');
    unlink('../public/user_profile/'.$imageurl);
    $input='..\public\user_profile_image/'.$imageurl;
    $output='F:\xampp\htdocs\seo\public\user_profile/'.$imageurl;
    $description=$request->get('description');
    $comment=$request->get('comment');
    $model=$request->get('cameramodel');
    $longitude=$request->get('longitude');
    $latitude=$request->get('latitude');
    //$altitude=$request->get('altitude');
    $date_time='06-08-2021';
    $copyright=$request->get('copyright');
    $tag=$request->get('tags');
    $width='512';
    $rating=$request->get('rating');
    $artist=$request->get('artist');
    $organation=$request->get('organation');
    $docname=$request->get('docname');
    $programname=$request->get('programname');
    $copyright=$request->get('copyright');
    $programname=$request->get('programname');
    $cameramaker=$request->get('cameramaker');

     /* Load the given image into a PelJpeg object */
    $jpeg = new PelJpeg($input);
    /*
     * Create and add empty Exif data to the image (this throws away any
     * old Exif data in the image).
     */
    $exif = new PelExif();
    $jpeg->setExif($exif);

    /*
     * Create and add TIFF data to the Exif data (Exif data is actually
     * stored in a TIFF format).
     */
    $tiff = new PelTiff();
    $exif->setTiff($tiff);

    /*
     * Create first Image File Directory and associate it with the TIFF
     * data.
     */
    $ifd0 = new PelIfd(PelIfd::IFD0);
    $tiff->setIfd($ifd0);

    /*
     * Create a sub-IFD for holding GPS information. GPS data must be
     * below the first IFD.
     */
    $gps_ifd = new PelIfd(PelIfd::GPS);
    $ifd0->addSubIfd($gps_ifd);

    /*
     * The USER_COMMENT tag must be put in a Exif sub-IFD under the
     * first IFD.
     */
    $exif_ifd = new PelIfd(PelIfd::EXIF);
    
    $exif_ifd->addEntry(new PelEntryUserComment($comment));
    $ifd0->addSubIfd($exif_ifd);
   

    $inter_ifd = new PelIfd(PelIfd::INTEROPERABILITY);
    $ifd0->addSubIfd($inter_ifd);
   
    $ifd0->addEntry(new PelEntryAscii(PelTag::MODEL, $model));
    
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
  
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $description));
   
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::COPYRIGHT, $copyright));
   
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_WIDTH, $width));
    
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::RATING, $rating));
  
   
    $ifd0->addEntry(new PelEntryAscii(PelTag::ARTIST, $artist));
   
 
    $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
   
   
    $ifd0->addEntry(new PelEntryAscii(PelTag::ORIENTATION, $organation));
    
    
 // test
    
    $ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, $docname));
   
    $ifd0->addEntry(new PelEntryAscii(PelTag::MAKE, $cameramaker));
    $ifd0->addEntry(new PelEntryAscii(PelTag::SOFTWARE, $programname));
    $ifd0->addEntry(new PelEntryAscii(PelTag::COMPRESSION, 'COMPRESSION'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::PHOTOMETRIC_INTERPRETATION, 'PHOTOMETRIC_INTERPRETATION'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, 'DOCUMENT_NAME'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_OFFSETS, 'STRIP_OFFSETS'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::SAMPLES_PER_PIXEL, 'SAMPLES_PER_PIXEL'));
    $ifd0->addEntry(new PelEntryAscii(PelTag::ROWS_PER_STRIP, 'ROWS_PER_STRIP'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_BYTE_COUNTS, 'STRIP_BYTE_COUNTS'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::X_RESOLUTION, 'X_RESOLUTION'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::Y_RESOLUTION, 'Y_RESOLUTION'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::PLANAR_CONFIGURATION, 'PLANAR_CONFIGURATION'));
      //$ifd0->addEntry(new PelEntryAscii(PelTag::RESOLUTION_UNIT, 'RESOLUTION_UNIT'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::TRANSFER_FUNCTION, 'TRANSFER_FUNCTION'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::WHITE_POINT, 'WHITE_POINT'));
     $ifd0->addEntry(new PelEntryAscii(PelTag::PRIMARY_CHROMATICITIES, 'PRIMARY_CHROMATICITIES'));
     
      $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT, 'JPEG_INTERCHANGE_FORMAT'));
      $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT_LENGTH, 'JPEG_INTERCHANGE_FORMAT_LENGTH'));
     //End Test


    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));
    if($latitude != ''){

    /*
     * Use the convertDecimalToDMS function to convert the latitude from
     * something like 12.34� to 12� 20' 42"
     */
    
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($latitude);

    /* We interpret a negative latitude as being south. */
    $latitude_ref = ($latitude < 0) ? 'S' : 'N';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));
    }
    if($longitude){
    
    

    /* The longitude works like the latitude. */
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($longitude);
    $longitude_ref = ($longitude < 0) ? 'W' : 'E';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));
    }
    
    
    /*
     * Add the altitude. The absolute value is stored here, the sign is
     * stored in the GPS_ALTITUDE_REF tag below.
     */
    // $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
    //     abs($altitude),
    //     1
    // ]));
    /*
     * The reference is set to 1 (true) if the altitude is below sea
     * level, or 0 (false) otherwise.
     */
    // $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));
    

    /* Finally we store the data in the output file. */
    file_put_contents($output, $jpeg->getBytes());
    if (file_put_contents($output, $jpeg->getBytes())) {

        define("IPTC_KEYWORDS", "025");
     $filename='..\public\user_profile/'.$imageurl;
     $objIPTC=new Testseo;
     $objIPTC->url($filename);
     $objIPTC->setValue(IPTC_KEYWORDS, $tag);
     $res = Testseo::where('image', $imageurl)->first();
        $res->title=$title;
        $res->save();
        $request->session()->flash('msg','Add Image Metadata Sucessfull!!');
        return Redirect::back();
    }
    
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