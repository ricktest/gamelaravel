<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WalletLog extends Model
{
    // ...
    public $timestamps = false;

    protected $table = 'wallet_log';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'transhash',
        'memId',
        'action',
        'srcpoint',
        'point',
        'amount',
        'descpoint',
        'srcbonuspoint',
        'decbonuspoint',
        'descbonuspoint',
        'createDate',
        'createDateUnix',
        'memo',
        'member_buy2hash',
        'status',
        'MerTradeID',
        'cancelstr',
        'backwater_uid',
        'memo2',
        'memo3',
        'ip',
        'wg',
        'servicestatus',
        'payway',
        'payway2',
        'ExecUser',
        'ExecUserUID',
        'Upline',
        'washCheck',
        'isfirst',
        'useBank',
        'remark',
    ];
}
