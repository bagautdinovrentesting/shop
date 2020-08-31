<?php

namespace App\Services;

class DiffMathHelper implements Contracts\MathHelper
{
    public function calculate($a, $b)
    {
        return $a - $b;
    }
}
