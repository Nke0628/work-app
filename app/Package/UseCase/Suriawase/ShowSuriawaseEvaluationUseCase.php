<?php


namespace App\Package\UseCase\Suriawase;


use App\Package\UseCase\Suriawase\Output\MeetingDto;
use App\Package\UseCase\Suriawase\ReadQuery\GetSuriawaseMeetingReadQuery;

class ShowSuriawaseEvaluationUseCase
{
    /**
     * @var GetSuriawaseMeetingReadQuery
     */
    private $getSuriawaseMeetingReadQuery;

    /**
     * ShowSuriawaseEvaluationUseCase constructor.
     * @param GetSuriawaseMeetingReadQuery $getSuriawaseMeetingReadQuery
     */
    public function __construct( GetSuriawaseMeetingReadQuery $getSuriawaseMeetingReadQuery )
    {
        $this->getSuriawaseMeetingReadQuery = $getSuriawaseMeetingReadQuery;
    }

    /**
     * @return MeetingDto
     */
    public function execute(): MeetingDto
    {
        return $this->getSuriawaseMeetingReadQuery->fetchMeetingData();
    }
}
