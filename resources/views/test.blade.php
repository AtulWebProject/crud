@php
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


class IPTC
{
    var $meta = [];
    var $file = null;
    function __construct($filename)
    {
        $info = null;

        $size = getimagesize($filename, $info);
        
        if(isset($info["APP13"])) $this->meta = iptcparse($info["APP13"]);
      
        $this->file = $filename;

    }


    function getValue($tag)
    {
       
        return isset($this->meta["2#$tag"]) ? $this->meta["2#$tag"][0] : "";
    }

    function setValue($tag, $data)
    {
        
        $this->meta["2#$tag"] = [$data];
        
        $this->write();
    }

    private function write()
    {
        $mode = 0;
            

        $content = iptcembed($this->binary(), $this->file, $mode);   
        
        $filename = $this->file;
        
        if(file_exists($this->file)) unlink($this->file);

        $fp = fopen($this->file, "w");
        
        fwrite($fp, $content);
        fclose($fp);
    }         

    private function binary()
    {
        $data = "";
       
        foreach(array_keys($this->meta) as $key)
        {

             
            $tag = str_replace("2#", "", $key);
           
            $data .= $this->iptc_maketag(2, $tag, $this->meta[$key][0]);
        }       
        
        return $data;
    }

    function iptc_maketag($rec, $data, $value)
    {
        
        $length = strlen($value);
        $retval = chr(0x1C) . chr($rec) . chr($data);
        
        if($length < 0x8000)
        {
            $retval .= chr($length >> 8) .  chr($length & 0xFF);
        }
        else
        {
            $retval .= chr(0x80) . 
                       chr(0x04) . 
                       chr(($length >> 24) & 0xFF) . 
                       chr(($length >> 16) & 0xFF) . 
                       chr(($length >> 8) & 0xFF) . 
                       chr($length & 0xFF);
        }
        
        return $retval . $value;            
    }   

    function dump()
    {
        echo "<pre>";
        print_r($this->meta);
        echo "</pre>";
    }

    #requires GD library installed
    function removeAllTags()
    {
        $this->meta = [];
        $img = imagecreatefromstring(implode(file($this->file)));
        if(file_exists($this->file)) unlink($this->file);
        imagejpeg($img, $this->file, 100);
    }
}

$file = "../public/user_profile_image/t.jpg";
$objIPTC = new IPTC($file);

//set title
$objIPTC->setValue(IPTC_HEADLINE, "test");

//set description
$objIPTC->setValue(IPTC_CAPTION, "ojha ji");

//set copyright
$objIPTC->setValue(IPTC_COPYRIGHT_STRING, "@atul");

//set tags
$objIPTC->setValue(IPTC_KEYWORDS, "aaaaa");

$objIPTC->setValue(IPTC_EDIT_STATUS, "a");
$objIPTC->setValue(IPTC_SUBJECT, "b");
$objIPTC->setValue(IPTC_PRIORITY, "c");
$objIPTC->setValue(IPTC_CATEGORY, "d");
$objIPTC->setValue(IPTC_SUPPLEMENTAL_CATEGORY, "e");
$objIPTC->setValue(IPTC_FIXTURE_IDENTIFIER, "f");
$objIPTC->setValue(IPTC_RELEASE_DATE, "g");
$objIPTC->setValue(IPTC_RELEASE_TIME, "h");
$objIPTC->setValue(IPTC_SPECIAL_INSTRUCTIONS, "i");
$objIPTC->setValue(IPTC_REFERENCE_SERVICE, "j");
$objIPTC->setValue(IPTC_CREATED_DATE, "k");
$objIPTC->setValue(IPTC_CREATED_TIME, "l");
//set program name
$objIPTC->setValue(IPTC_ORIGINATING_PROGRAM, "m");

$objIPTC->setValue(IPTC_PROGRAM_VERSION, "n");
$objIPTC->setValue(IPTC_OBJECT_CYCLE, "o");
//set Author
$objIPTC->setValue(IPTC_BYLINE, "p");

$objIPTC->setValue(IPTC_BYLINE_TITLE, "q");
$objIPTC->setValue(IPTC_CITY, "r");


echo $objIPTC->getValue(IPTC_HEADLINE);


 @endphp