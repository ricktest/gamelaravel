<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    // ...
    public $timestamps = false;
    protected $table = 'memberinfo';
    protected $primaryKey = 'uid';
}
