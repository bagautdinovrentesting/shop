<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Contracts\MathHelper;


class DiffMathController extends Controller
{
    protected MathHelper $mathHelper;

    public function __construct(MathHelper $mathHelper)
    {
        $this->mathHelper = $mathHelper;
    }

    public function calculate()
    {


        return $this->mathHelper->calculate(3, 5);
    }
}
