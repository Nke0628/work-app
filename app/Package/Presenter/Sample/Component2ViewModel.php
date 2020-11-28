<?php


namespace App\Package\Presenter\Sample;

use App\Package\Presenter\ViewModel;


/**
 * Class Component2ViewModel
 * @package App\Package\Presenter\Department
 */
class Component2ViewModel extends ViewModel
{
    public function __construct()
    {
        $this->view( 'viewmodel.component2' );
    }

    public function toArray()
    {
        return [
            'component2' => '2'
        ];
    }
}
