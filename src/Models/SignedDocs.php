<?php

namespace Asadbek\Eimzo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignedDocs extends Model
{
    use HasFactory;
    protected $table='signed_docs';
    public $timestamps = false;
}
