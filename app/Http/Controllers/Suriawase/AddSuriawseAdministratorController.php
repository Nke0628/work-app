<?php


namespace App\Http\Controllers\Suriawase;


use App\Http\Controllers\Controller;
use App\Package\Suriawase\UseCase\AddSuriawseAdministratorUseCase;

class AddSuriawseAdministratorController extends Controller
{
    /**
     * @var AddSuriawseAdministratorUseCase
     */
    private $addSuriawseAdministratorUseCase;

    /**
     * AddSuriawseAdministratorController constructor.
     * @param AddSuriawseAdministratorUseCase $addSuriawseAdministratorUseCase
     */
    public function __construct( AddSuriawseAdministratorUseCase $addSuriawseAdministratorUseCase)
    {
        $this->addSuriawseAdministratorUseCase = $addSuriawseAdministratorUseCase;
    }

    /**
     *
     */
    public function index()
    {
        $this->addSuriawseAdministratorUseCase->execute();
        return;
    }
}
