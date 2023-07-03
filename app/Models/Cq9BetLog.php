<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cq9BetLog extends Model
{
    // ...
    public $timestamps = false;

    protected $table = 'cq9_betlog';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'memId',
        'iaction',
        'mtcode',
        'ucode',
        'beginGold',
        'amount',
        'balance',
        'gamecode',
        'roundid',
        'data',
        'event',
        'eventTime',
        'validbet',
        'bet',
        'win',
        'rake',
        'gametype',
        'promoid',
        'remark',
        'action',
        'cagent',
        'cagent1',
        'cagent2',
        'cagent3',
        'cagent4',
        'cagent5',
        'cagent6',
        'cagent7',
    ];
}
