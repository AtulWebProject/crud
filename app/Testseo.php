<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Testseo extends Model
{
    
	
	protected $table = 'seo';
    public $sortable = ['id',
                        'title',
                        'image',
                        'description',
                        'created_at',
                        'updated_at'];

	public static function SearchUserData()
	{
    $post=Seo::all();
    return $post;
    }

    var $meta = [];
    var $file = null;
    public function __construct()
    {
        //$filename='F:\xampp\htdocs\seo\public\user_profile_image/t.jpg';
        $info = null;

        //$size = getimagesize($filename, $info);
        
        if(isset($info["APP13"])) $this->meta = iptcparse($info["APP13"]);
      
        //$this->file = $filename;

    }

    function url($filename){
        $this->file = $filename;
    }
  // public function getValue($tag)
  //   {
        
  //       return isset($this->meta["2#$tag"]) ? $this->meta["2#$tag"][0] : "";
  //   }

     function setValue($tag, $data)
    {
        //dd($data);
       
        $this->meta["2#$tag"] = [$data];
        
        return $this->write();
    }

     function write()
    {
        $mode = 0;
            

        $content = iptcembed($this->binary(), $this->file, $mode);   
        
        $filename = $this->file;
        
        if(file_exists($this->file)) 
            // unlink($this->file);
         
        $fp = fopen($this->file, "w");
        
        fwrite($fp, $content);
        fclose($fp);
    }       

     function binary()
    {
        $data = "";
       
        foreach(array_keys($this->meta) as $key)
        {
           // dd($this->meta);
             
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