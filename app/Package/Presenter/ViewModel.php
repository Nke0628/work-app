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
class ViewModel implements Arrayable, Responsable
{
    protected $view;

    /**
     * @param string $view
     * @return ViewModel
     */
    public function view(string $view): ViewModel
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view( $this->view, $this )->render();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse( $request )
    {
        return response()->view( $this->view, $this );
    }

    /**
     * @inheritDoc
     */
    public function toArray(){}
}
