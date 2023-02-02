<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory,
        SoftDeletes;
    
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'file_path', 'upload_date'];
    protected $dates = ['upload_date', 'created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['deleted_at'];
}
