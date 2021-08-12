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
class GpsController
{

	public function index(Request $request)
    {
         
        $title=$request->get('title');
        $profile_image=$request->get('profile_image');
        $searchdata = [];
        if(!empty($request->get('title'))) {
                $searchdata[]= ['title','like','%'.filter_var($request->get('title'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('profile_image'))) {
                $searchdata[]= ['original_image_name','=',filter_var($request->get('profile_image'),FILTER_SANITIZE_STRING)];
            }
            $viewdata = Seo::SearchUserData($searchdata);
            // dd($viewdata);
               return view('exifdata',compact('viewdata','title'))->with('no', 1);
            
            
        

    }

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
               $returndata .="<input type='text' name='imageurl' value=".$filename.">";
               
              }
               echo $returndata;
           }   
           else{
              $request->session()->flash('msg','Not Update Image Sucessfull!!');
             return redirect()->route('alldata');
           }
             
  }
function convertDecimalToDMS()
{
	$degree='123.456';
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
// $filename='F:\xampp\htdocs\seoimage\img\t.jpg';
// $jpeg = new PelJpeg($filename);
// $ifd0 = $jpeg->getExif()->getTiff()->getIfd();
// // start copyright
// $entry = new PelEntryCopyright('Copyright, Martin Geisler, 2004');
// $ifd0->addEntry($entry);
// // End copyright
// // start IMAGE_DESCRIPTION
// $entry = $ifd0->getEntry(PelTag::IMAGE_DESCRIPTION);
// $entry->setValue('Edited by deepak');
// // End IMAGE_DESCRIPTION
// $jpeg->saveFile($filename);
	//dd($request);



$imageurl=$request->get('imageurl');
$title=$request->get('caption');
$input='F:\xampp\htdocs\seoimage\img\t.jpg';
$output='F:\xampp\htdocs\seoimage\img\t.jpg';
$description='description';
$comment='comment';
$model='model';
$longitude='1485664';
$latitude='3663';
$altitude='33146364';
$date_time='06-08-2021';
$tags='img,atul';
$width='512';
$rating=$request->get('rating');
$artist=$request->get('artist');
$organation=$request->get('organation');
$docname=$request->get('docname');
$programname=$request->get('programname');
$copyright=$request->get('copyright');

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
    // $ifd0->addEntry(new PelEntryAscii(PelTag::COPYRIGHT, $tags));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::IMAGE_WIDTH, $width));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::RATING, $rating));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::ARTIST, $artist));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::ORIENTATION, $organation));

 // test
    // $ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, $docname));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::MAKE, 'make'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::SOFTWARE, 'SOFTWARE'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::COMPRESSION, 'COMPRESSION'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::PHOTOMETRIC_INTERPRETATION, 'PHOTOMETRIC_INTERPRETATION'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::DOCUMENT_NAME, 'DOCUMENT_NAME'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_OFFSETS, 'STRIP_OFFSETS'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::SAMPLES_PER_PIXEL, 'SAMPLES_PER_PIXEL'));
    // $ifd0->addEntry(new PelEntryAscii(PelTag::ROWS_PER_STRIP, 'ROWS_PER_STRIP'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::STRIP_BYTE_COUNTS, 'STRIP_BYTE_COUNTS'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::X_RESOLUTION, 'X_RESOLUTION'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::Y_RESOLUTION, 'Y_RESOLUTION'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::PLANAR_CONFIGURATION, 'PLANAR_CONFIGURATION'));
    //   $ifd0->addEntry(new PelEntryAscii(PelTag::RESOLUTION_UNIT, 'RESOLUTION_UNIT'));
    //   $ifd0->addEntry(new PelEntryAscii(PelTag::TRANSFER_FUNCTION, 'TRANSFER_FUNCTION'));
    //   $ifd0->addEntry(new PelEntryAscii(PelTag::WHITE_POINT, 'WHITE_POINT'));
    //  $ifd0->addEntry(new PelEntryAscii(PelTag::PRIMARY_CHROMATICITIES, 'PRIMARY_CHROMATICITIES'));
     
    //   $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT, 'JPEG_INTERCHANGE_FORMAT'));
    //   $ifd0->addEntry(new PelEntryAscii(PelTag::JPEG_INTERCHANGE_FORMAT_LENGTH, 'JPEG_INTERCHANGE_FORMAT_LENGTH'));
     //End Test


    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_VERSION_ID, 2, 2, 0, 0));

    /*
     * Use the convertDecimalToDMS function to convert the latitude from
     * something like 12.34� to 12� 20' 42"
     */
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($latitude);

    /* We interpret a negative latitude as being south. */
    $latitude_ref = ($latitude < 0) ? 'S' : 'N';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));

    /* The longitude works like the latitude. */
    list ($hours, $minutes, $seconds) = $this->convertDecimalToDMS($longitude);
    $longitude_ref = ($longitude < 0) ? 'W' : 'E';

    $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));

    /*
     * Add the altitude. The absolute value is stored here, the sign is
     * stored in the GPS_ALTITUDE_REF tag below.
     */
    $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_ALTITUDE, [
        abs($altitude),
        1
    ]));
    /*
     * The reference is set to 1 (true) if the altitude is below sea
     * level, or 0 (false) otherwise.
     */
    $gps_ifd->addEntry(new PelEntryByte(PelTag::GPS_ALTITUDE_REF, (int) ($altitude < 0)));

    /* Finally we store the data in the output file. */
    file_put_contents($output, $jpeg->getBytes());
}




}
?>