<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multipleuploads extends Model
{
    protected $table ='multiuploads';
    protected $primaryKey = 'id';
    
    // Cukup tuliskan 'filename' saja
    protected $fillable = ['filename']; 
}