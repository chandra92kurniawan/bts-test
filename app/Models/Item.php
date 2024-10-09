<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table='item';
    public function detail(){
        return $this->hasMany(Item::class,'parent_id','id');
    }
    public function checklist(){
        return $this->belongsTo(Checklist::class,'checklist_id','id');
    }
}
