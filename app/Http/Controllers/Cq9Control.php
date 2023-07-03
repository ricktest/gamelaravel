<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\Cq9Check;
use App\Models\Cq9BetLog;
use App\Models\MemberInfo;
use App\Models\WalletLog;
use Illuminate\Support\Facades\DB;

class Cq9Control extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function bet(Request $request)
    {
        //驗證
        $value = $request->header('Wtoken');

        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'eventTime' => 'required',
            'gamecode' => 'required',
            'roundid' => 'required',
            'amount' => 'required',
            'mtcode' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $result = array(
                'data' => null,
                'status' => array(
                    'code' => '1003',
                    'message' => $errors->first('Wtoken'),
                    'datetime' => date("Y-m-d\TH:i:sP", time()),
                )
            );

            return response()->json($result);
        }

        $validator = Validator::make(['Wtoken' => $value], [
            'Wtoken' =>  ['required', new Cq9Check],
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $result = array(
                'data' => null,
                'status' => array(
                    'code' => '1100',
                    'message' => $errors->first('Wtoken'),
                    'datetime' => date("Y-m-d\TH:i:sP", time()),
                )
            );

            return response()->json($result);
        }

        //資料操作
        $input = $request->input();

        DB::beginTransaction();

        $member = MemberInfo::where('uid', 1)
            ->lockForUpdate()
            ->first();

        $beginGold = $member['vpoint'];
        $member->vpoint = $member->vpoint - $input['amount'];
        $member->save();

        $data = [
            'memId' => $member['uid'],
            'iaction' => 'bet',
            'createDate' => date('Y-m-d H:i:s'),
            'mtcode' => $input['mtcode'],
            'beginGold' => $beginGold,
            'amount' => $input['amount'],
            'balance' => $member->vpoint,
            'gamecode' => $input['gamecode'],
            'roundid' => $input['roundid'],
            'cagent' => $member['cagent'],
            'cagent1' => $member['cagent1'],
            'cagent2' => $member['cagent2'],
            'cagent3' => $member['cagent3'],
            'cagent4' => $member['cagent4'],
            'cagent5' => $member['cagent5'],
            'cagent6' => $member['cagent6'],
            'cagent7' => $member['cagent7'],
        ];

        Cq9BetLog::create($data);

        $data = [
            'memId' => $member['uid'],
            'transhash' => $input['mtcode'],
            'action' => 'bet',
            'srcpoint' =>  $beginGold,
            'point' => $input['amount'],
            'descpoint' => $member->vpoint,
            'createDate' => date('Y-m-d H:i:s'),
            'memo' => 'vtocq9',
            'status' => 2,
        ];

        WalletLog::create($data);
        DB::commit();

        $result = array(
            'data' => array(
                'balance' => '',
                'currency' => $member['currency_code'],
            ),
            'status' => array(
                'code' => '0',
                'message' => 'Success',
                'datetime' => date("Y-m-d\TH:i:sP", time()),
            )
        );
        //數字格式且到小數第四位須補零
        $r1 = json_encode($result);
        $r2 = strpos($r1, "balance") + 10;
        $r3 = substr($r1, 0, $r2 - 1) . number_format($member['vpoint'], 4, '.', '') . substr($r1, $r2 + 1);
        $r3 = json_decode($r3, 1);
        return response()->json($r3);
    }
}
