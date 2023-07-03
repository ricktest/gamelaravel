<?php
Route::get('calculator', function () {
    echo "hello from package";
});

Route::get('add/{a}/{b}', [LP\Calculator\CalculatorController::class, 'add']);
