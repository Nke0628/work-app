<?php


namespace App\Package\Presenter\Department;

use App\Package\Presenter\ViewModel;
use App\Package\UseCase\Department\Dto\SearchDepartmentOutputList;


/**
 * 組織検索ViewModel
 *
 * Class DepartmentList
 * @package App\Package\Domain\Department
 */
class SearchDepartmentViewModel extends ViewModel
{
    /** @var SearchDepartmentOutputList **/
    private $searchDepartmentOutputList;

    /**
     * DepartmentList constructor.
     * @param SearchDepartmentOutputList $searchDepartmentOutputList
     */
    public function __construct( SearchDepartmentOutputList $searchDepartmentOutputList )
    {
        $this->searchDepartmentOutputList = $searchDepartmentOutputList;
        $this->view('department.index');
    }

    /**
     * 表示用に時刻を変換
     *
     * @param string $pTime
     * @return string
     */
    private function GetOutputTime( string $pTime )
    {
        $aRet = '設定なし';
        if ( !$pTime )
        {
            return $aRet;
        }
        return substr( $pTime, 0,2 ) . ':' . substr( $pTime, -2 );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $aTargetList = array();
        foreach ( $this->searchDepartmentOutputList as $searchDepartmentOutput )
        {
            $aLine = array();
            $aLine['id'] = $searchDepartmentOutput->getDepartmentId();
            $aLine['department_name'] = $searchDepartmentOutput->getDepartmentName();
            $aLine['start_work_time'] = $this->GetOutputTime($searchDepartmentOutput->getStartWorkTime());
            $aLine['end_work_time'] = $this->GetOutputTime($searchDepartmentOutput->getEndWorkTime());
            $aLine['start_break_time'] = $this->GetOutputTime($searchDepartmentOutput->getStartBreakTime());
            $aLine['end_break_time'] = $this->GetOutputTime($searchDepartmentOutput->getEndWorkTime());
            $aTargetList[] = $aLine;
        }
        return array(
            'target_list' => $aTargetList,
            'pages' => $this->searchDepartmentOutputList->getPages(),
            'search_query' => $this->searchDepartmentOutputList->getSearchQuery(),
            'department_name' => $this->searchDepartmentOutputList->getDepartmentName(),
            'start_work_time' => $this->searchDepartmentOutputList->getStartWorkTime(),
            'end_work_time' => $this->searchDepartmentOutputList->getEndWorkTime(),
            'start_break_time' => $this->searchDepartmentOutputList->getStartBreakTime(),
            'end_break_time' => $this->searchDepartmentOutputList->getEndBreakTime()
        );
    }
}
