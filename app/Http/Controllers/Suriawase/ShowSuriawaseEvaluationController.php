<?php


namespace App\Http\Controllers\Suriawase;

use App\Package\Presenter\Suriawase\ShowSuriawseEvaluationViewModel;
use App\Package\UseCase\Suriawase\ShowSuriawaseEvaluationUseCase;

class ShowSuriawaseEvaluationController
{
    /**
     * @var ShowSuriawaseEvaluationUseCase
     */
    private $showSuriawaseEvaluationUseCase;

    /**
     * ShowSuriawaseEvaluationController constructor.
     * @param ShowSuriawaseEvaluationUseCase $showSuriawaseEvaluationUseCase
     */
    public function __construct( ShowSuriawaseEvaluationUseCase $showSuriawaseEvaluationUseCase)
    {
        $this->showSuriawaseEvaluationUseCase = $showSuriawaseEvaluationUseCase;
    }

    public function index()
    {
        $response = $this->showSuriawaseEvaluationUseCase->execute();
        return new ShowSuriawseEvaluationViewModel( $response );
    }
}
