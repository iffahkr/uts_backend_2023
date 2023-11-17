<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // membuat fungsi getPatient di model Patientt
    protected $table = "patients";
    // mendefinisikan atribut model agar table dapat diisi
    protected $fillable = ['name', 'phone', 'address', 'status', 'in_date_at', 'out_date_at', 'timestamp'];
}
