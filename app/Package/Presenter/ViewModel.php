<?php


namespace App\Package\Presenter;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ViewModel
 * @package App\Package\Presenter
 */
abstract class ViewModel implements Arrayable, Responsable
{
    /** @var string */
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
     * @param Request $request
     * @return JsonResponse| Response
     */
    public function toResponse( $request )
    {
        if ($request->wantsJson()) {
            return new JsonResponse( $this->toArray() );
        }

        if ( $this->view ) {
            return response()->view( $this->view, $this );
        }

        return new JsonResponse( $this->toArray() );
    }

    /**
     * @inheritDoc
     */
    abstract public function toArray();
}
