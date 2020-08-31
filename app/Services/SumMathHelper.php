<?php

namespace App\Services;

class SumMathHelper implements Contracts\MathHelper
{
    public function calculate($a, $b)
    {
        return $a + $b;
    }
}
