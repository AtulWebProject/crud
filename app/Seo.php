<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Seo extends Model
{
	
	protected $table = 'seo';

	public static function SearchUserData($searchdata)
	{
        $post=Seo::where($searchdata)->paginate(10);
    //$post=Seo::all();
    return $post;
    }

    public static function alldata($filename)
    {
        $info = null;
        
        $size = getimagesize($filename, $info);
        $data=$info['APP13'];
        $metadata=iptcparse($info["APP13"]);
        $filedata=$filename;
            return [$metadata,$filedata];

    }
  // public static function getValue($tag)
  //   {
        
  //       return isset($this->meta["2#$tag"]) ? $this->meta["2#$tag"][0] : "";
  //   }

    public static function setValue($tag, $data)
    {
        
        $data=$tag=[$data];

        return $data;
        
    }

    public static function write($tag,$metadata,$file)
    {

        $mode = 0;
    
        $content = iptcembed(Self::binary($tag,$metadata), $file, $mode);   
        $filename = $file;
        if(file_exists($file)) 
        	 // unlink($file);

        $fp = fopen($file, "w");
        fwrite($fp, $content);
        fclose($fp);
    }         

    public static function binary($tag,$metadata)
    {
        $data = "";
         
        foreach(array_keys($tag) as $key)
        {
        	dd(array_keys($tag));
            $tag = str_replace("2#", "", $key);
            $data .= Self::iptc_maketag(2, $tag, $metadata);
        }       
        return $data;
    }

    public static function iptc_maketag($rec, $data, $value)
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

    public static function dump()
    {
        echo "<pre>";
        print_r($this->meta);
        echo "</pre>";
    }

    #requires GD library installed
    public static function removeAllTags()
    {
        $this->meta = [];
        $img = imagecreatefromstring(implode(file($this->file)));
        if(file_exists($this->file)) unlink($this->file);
        imagejpeg($img, $this->file, 100);
    }
	
}