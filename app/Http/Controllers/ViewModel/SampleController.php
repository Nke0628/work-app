<?php


namespace App\Http\Controllers\ViewModel;


use App\Package\Presenter\Sample\ComponentAllViewModel;

class SampleController
{
    public function test()
    {
        return new ComponentAllViewModel();
    }
}
