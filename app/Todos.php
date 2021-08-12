<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Todos extends Model
{
	use Sortable;
    public $sortable = ['id',
                        'question',
                        'ans1',
                        'ans2',
                        'ans3',
                        'ans4',
                        'rans',
                        'type',
                        'created_at',
                        'updated_at'];
	//protected $table = 'todos';
	use SoftDeletes;
	// protected $data = ['deleted_at'];
  protected $table='todos';
	public static function UpdateUserData($res){
    $value=$res->save();
    return $value;
  }
  public static function InsertUserData($res){
    // $getdata=find($qid);
    $value=$res->save();
    return $value;
  }
  public static function SearchRegularData(){
    //print_r($userid); die;
    
    $post=Todos::where('type','r')->paginate(10);
    
    return $post;

  }
  public static function SearchQuizData(){
    //print_r($userid); die;
    
    $post=Todos::where('type','q')->paginate(10);
    
    return $post;

  }

  

  public static function ActiveUserData($res){
    $post=$res->save();
    return $post;
  }

  public static function DeleteSearchUserData($deletesearchdata){
    $post=todos::where($deletesearchdata)->onlyTrashed()->paginate(10);
    return $post;
  }

  public static function RowFilterUserData($rowfilteruserData){
    $viewuserdata=todos::paginate($rowfilteruserData);
    return $viewuserdata;
  }

  public static function DeletedRowFilterUserData($DeletedrowfilteruserData){
    $viewuserdata=todos::paginate($DeletedrowfilteruserData);
    return $viewuserdata;
  }

  public static function CheckEmail($checkEmail){
    $viewuserdata=todos::where('email',$checkEmail)->first();
    return $viewuserdata;
  }

  public static function RestoreData($restore){
    $viewuserdata=todos::withTrashed()->find($restore)->restore();
    return $viewuserdata;
  }

  // public static function ForceDelete($Forcedelete){
  //   $viewuserdata=todos::where('id',$Forcedelete)->forceDelete();
  //   return $viewuserdata;
  // }
	// public function UserData()
 //    {
 //        //return $this->hasMany('App\Todos','user_id','id');
 //      //return $this->hasOne('App\Todos','user_id','id')->latestOfMany();
 //      return $this->hasMany('Todos')->whereUserId('user_id',$this->id)->count(); 
 //    }
   public function UserData()
    {

      //return $this->belongsToMany('App\user','user_id','id'); 
      return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
