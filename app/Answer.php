<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Answer extends Model
{
	use Sortable;
  public $sortable = ['id',
                        'wrongans',
                        'correctanswer',
                        'userid',
                        'created_at',
                        'updated_at'];
	 protected $table='answer';
	
}
