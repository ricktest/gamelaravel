<?php

namespace LP\Calculator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalculatorController extends Controller
{
    //
    public function add($a, $b)
    {
        echo $a + $b;
    }
    public function sub($a, $b)
    {
        echo $a + -$b;
    }
}
