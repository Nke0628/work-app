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
    protected $view = '';

    /**
     * @param string $view
     * @return void
     */
    public function view(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        if ( !$this->view ) {
            throw new \RuntimeException( 'view configuration is not setting' );
        }

        return view( $this->view, $this )->render();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse( $request )
    {
        if ( !$this->view ) {
            throw new \RuntimeException( 'view configuration is not setting' );
        }

        return response()->view( $this->view, $this );
    }

    /**
     * @return Response
     */
    public function toJson( ): Response
    {
        return response()->json( $this );
    }

    /**
     * @return array
     */
    public abstract function toArray(): array;
}
