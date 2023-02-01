<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'Persons';
    protected $primaryKey = 'id';
    protected $fillable = ['teljes_nev','email_cim', 'ado_azonosito', 'egyeb_id', 'belepes', 'kilepes'];
    protected $dates = ['belepes','kilepes', 'created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['deleted_at'];
}
