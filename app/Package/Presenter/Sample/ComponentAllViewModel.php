<?php


namespace App\Package\Presenter\Sample;

use App\Package\Presenter\ViewModel;


/**
 * Class ComponentAllViewModel
 * @package App\Package\Presenter\Sample
 */
class ComponentAllViewModel extends ViewModel
{
    private $viewModel1;
    private $viewModel2;

    /**
     * ComponentAllViewModel constructor.
     */
    public function __construct()
    {
        $this->view( 'viewmodel.component_all' );
        $this->viewModel1 = new Component1ViewModel();
        $this->viewModel2 = new Component2ViewModel();
    }

    public function toArray()
    {
        return [
            $this->viewModel1->toArray(),
            $this->viewModel2->toArray()
        ];
    }
}
