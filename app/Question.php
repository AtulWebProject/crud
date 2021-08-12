<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Question extends Model
{
	use Sortable;
  public $sortable = ['id',
                        'question',
                        'ans1',
                        'ans2',
                        'ans3',
                        'ans4',
                        'rans',
                        'created_at',
                        'updated_at'];
	 protected $table='question';

   public static function InsertUserData($res){
    $value=$res->save();
    return $value;
  }

  public static function SearchUserData(){
    //print_r($userid); die;
    
    $post=Question::paginate(10);
    
    return $post;

  }

  
	
}
