<?php
/**
 * Created by PhpStorm.
 * User: bagau
 * Date: 12.01.2020
 * Time: 21:48
 */

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class CommonViewComposer
{
    public function compose(View $view)
    {
        $view->with('author', 'Bourne');
    }
}