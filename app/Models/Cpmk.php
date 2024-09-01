<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $table = "cpmk";

    protected $fillable = [
        "kode_cpl",
        "kode_cpmk",
        "deskripsi"
    ];

}
