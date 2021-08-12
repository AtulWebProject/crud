<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
use App\Seo;
use App\Testseo;
use Redirect; 

class AddMetadataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     protected $storedata;
     protected $imageurl;
     protected $description;
     protected $comment;
     protected $model;
     protected $longitude;
     protected $latitude;
     protected $copyright;
     protected $artist;
     protected $organation;
     protected $docname;
     protected $programname;
     protected $cameramaker;
     protected $rating;
     protected $tag;
    public function __construct($storedata,$imageurl,$description,$comment,$model,$longitude,$latitude,$copyright,$artist,$organation,$docname,$programname,$cameramaker,$rating,$tag)
    {
        $this->storedata = $storedata;
        $this->imageurl = $imageurl;
        $this->description=$description;
        $this->comment=$comment;
        $this->model =$model;       
        $this->longitude =$longitude;
        $this->latitude =$latitude;
        $this->copyright =$copyright;
        $this->artist =$artist;
        $this->organation =$organation;
        $this->docname =$docname;
        $this->programname =$programname;
        $this->cameramaker =$cameramaker;
        $this->rating =$rating;
        $this->tag =$tag;
        //dd($this->$description);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
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
    public function handle()
    {
       define("IPTC_KEYWORDS", "025");
       // $s_code='';
       $StoreImageUrl='';
    foreach($this->storedata as $d){
    $allstoredata=Config('storedata');
    foreach($allstoredata as $s){
        $allstoredata=$s[$d];
        $s_code[]=$allstoredata['store_code'];
    $f=$d.'.jpg';
     //dd($sc);
    $imageurl=$this->imageurl;
    $StoreImageUrl .=implode([',',$d.$imageurl]);
    $outputurl =$d.$imageurl;
    $store_code=$allstoredata['store_code'];
    $store_manager_name=$allstoredata['store_manager_name'];
    $business_name=$allstoredata['business_name'];
    $address=$allstoredata['address'];
    $latitude_data=$allstoredata['latitude'];
    $longitude_data=$allstoredata['longitude'];
    // $latitude=$request->get('latitude');
    //$altitude=$request->get('altitude');
    $date_time='06-08-2021';
    $locality=$allstoredata['locality'];
    $tag=$this->tag;
    $rating=$this->rating;
    $width='512';
    $administrative_area=$allstoredata['administrative_area'];
    $postal_code=$allstoredata['postal_code'];
    $primary_phone=$allstoredata['primary_phone'];
    $store_alternate_name=$allstoredata['store_alternate_name'];
    // $programname_data=$allstoredata['programname'];
    // $cameramaker_data=$allstoredata['cameramaker'];
    $find = ['{store_code}','{store_manager_name}','{business_name}','{address}','{locality}','{administrative_area}','{postal_code}','{primary_phone}','{store_alternate_name}','{latitude}','{longitude}'];
    $replace = compact('store_code', 'store_manager_name','business_name','address','locality','administrative_area','postal_code','primary_phone','store_alternate_name','longitude_data','latitude_data');
    $description=str_replace($find, $replace, $this->description);
    $comment=str_replace($find, $replace, $this->comment);
    $model=str_replace($find, $replace, $this->model);
    $longitude=str_replace($find, $replace, $this->longitude);
    $latitude=str_replace($find, $replace, $this->latitude);
    $copyright=str_replace($find, $replace, $this->copyright);
    $artist=str_replace($find, $replace, $this->artist);
    $organation=str_replace($find, $replace, $this->organation);
    $docname=str_replace($find, $replace, $this->docname);
    $programname=str_replace($find, $replace, $this->programname);
    $cameramaker=str_replace($find, $replace, $this->cameramaker);
    $title=$allstoredata['title'];
    $input='..\public\user_profile_image/'.$imageurl;
    $output='F:\xampp\htdocs\seo\public\user_profile/'.$outputurl;
    // $description=str_replace("{description}", $allstoredata['description'], $this->description);
    // $comment=str_replace("{comment}", $allstoredata['comment'], );
    

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
    //$ifd0->addEntry(new PelEntryAscii(PelTag::DATE_TIME, $date_time));
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
         
        
         $filename='..\public\user_profile/'.$outputurl;
         $objIPTC=new Testseo;
         $objIPTC->url($filename);
         $objIPTC->setValue(IPTC_KEYWORDS, $tag);
    
    }
    
    }
    $store_c=implode(',', $s_code);
     // dd($store_c);
    $res = new Testseo;
         $res->store_code=$store_c;
         $res->image=$imageurl;
         $res->original_image_name=$StoreImageUrl;
         $res->iconurl=$outputurl;
         $res->description=$this->description;
         $res->comment=$this->comment;
         $res->longitude=$this->longitude;
         $res->latitude=$this->latitude;
         $res->tag=$this->tag;
         // $res->store=$this->storedata;
         // $res->altitude=;
         $res->author=$this->artist;
         $res->organisation=$this->organation;
         $res->document_name=$this->docname;
         $res->program_name=$this->programname;
         $res->copyright=$this->copyright;
         $res->camera_maker=$this->cameramaker;
         $res->camera_model=$this->model;
         $res->rating=$this->rating;
         $res->save();
    
    }

}
