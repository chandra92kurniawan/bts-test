<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $table="checklist";
    public function items(){
        return $this->hasMany(Item::class,'checklist_id','id')->where('parent_id',null);
    }
}
