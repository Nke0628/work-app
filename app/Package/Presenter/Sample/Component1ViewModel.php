<?php


namespace App\Package\Presenter\Sample;

use App\Package\Presenter\ViewModel;


/**
 * Class Component1ViewModel
 * @package App\Package\Presenter\Department
 */
class Component1ViewModel extends ViewModel
{
    public function __construct()
    {
        $this->view( 'viewmodel.component1' );
    }

    public function toArray()
    {
        return [
            'component1' => '1'
        ];
    }
}
