<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagescl extends Model
{
    //指定表名
    protected $table= 'pagescl';

    protected $fillable = ['id','name','content','sort'];

    public $timestamps = false;
}
