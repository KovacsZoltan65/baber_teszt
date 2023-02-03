<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonsLogs extends Model
{
    use HasFactory;
    
    protected $table = 'persons_logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mod_date','mod_op','p_id','teljes_nev','email_cim',
        'ado_azonosito','egyeb_id','belepes','kilepes','created_at',
        'updated_at','deleted_at'
    ];
    protected $dates = ['mod_date','created_at','updated_at','deleted_at'];
    
}
