<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = ['name', 'nip', 'email', 'phone_number', 'company_agency'];
}
