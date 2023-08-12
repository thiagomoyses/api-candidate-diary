<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'email', 'phone', 'address', 'city', 'country', 'status'];
}
