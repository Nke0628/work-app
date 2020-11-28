<?php


namespace App\Package\Presenter\Sample;

use App\Package\Presenter\ViewModel;


/**
 * Class ComponentAllViewModel
 * @package App\Package\Presenter\Sample
 */
class ComponentAllViewModel extends ViewModel
{
    /**
     * ComponentAllViewModel constructor.
     */
    public function __construct()
    {
        $this->view( 'viewmodel.component_all' );
        $this->addViewModel( new Component1ViewModel());
        $this->addViewModel( new Component2ViewModel());
    }

    public function toArray()
    {
        $params['mes'] = 'ok';
        foreach ( $this->viewModels as $viewModel ) {
            if ( $viewModel instanceof Component1ViewModel ){
                $params['html1'] = $viewModel->render();
            } else if ( $viewModel instanceof Component2ViewModel ){
                $params['html2'] = $viewModel->render();
            }
        }
        return $params;
    }
}
