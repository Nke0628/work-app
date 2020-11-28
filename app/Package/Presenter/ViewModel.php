<?php


namespace App\Package\Presenter;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ViewModel基底クラス
 *
 * Class ViewModel
 * @package App\Package\Presenter
 */
abstract class ViewModel implements Arrayable, Responsable
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var ViewModel[]
     */
    protected $viewModels;

    /**
     * @param string $view
     * @return void
     */
    public function view(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @param ViewModel $viewModel
     */
    public function addViewModel( ViewModel $viewModel ): void
    {
        $this->viewModels[] = $viewModel;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        if ( is_null( $this->view ) ) {
            throw new \RuntimeException( 'insufficient view configuration' );
        }

        return view( $this->view, $this )->render();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse( $request )
    {
        $tmpParams = [];
        if ( !empty( $this->viewModels ) ){
            foreach ( $this->viewModels as $viewModel ){
                $tmpParams = array_merge( $tmpParams, $viewModel->toArray() );
            }
        }

        $params = array_merge( $tmpParams, $this->toArray());

        return response()->view( $this->view, $params );
    }

    /**
     * @return Response
     */
    public function toJson( ): Response
    {
        return response()->json( $this->toArray() );
    }

    /**
     * @inheritDoc
     */
    public function toArray(){}
}
