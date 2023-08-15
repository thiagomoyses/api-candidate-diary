<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'city', 'country', 'email', 'phone', 'client_id_fk'];
}
