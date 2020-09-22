<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnyItemCsvImportRequest;
use App\Model\Routes;
use App\Package\Domain\Csv\AnyItemImportService;
use App\Package\UseCase\Department\SearchDepartmentUseCase;
use App\Package\UseCase\Error\Dto\ErrorMessageDto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;

class EvaluateRouteController extends Controller
{
    public function getAllEvaluateRoutes()
    {
        $test = [];
        $test[] =
            [
                'personal_id' => 'S1000',
                'sky_id' => '1000',
                'stage1' => [
                    [
                        'personal_id' => 'S1000',
                        'sky_id' => '1000'
                    ],
                    [
                        'personal_id' => 'S1000',
                        'sky_id' => '1000'
                    ],
                ]
            ];

        $test[] =  [
                'personal_id' => 'S1000',
                'sky_id' => '1000',
                'stage1' => [
                    'personal_id' => 'S1000',
                    'sky_id' => '1000'
                ]
            ];
        return response()->json($test);
    }





    public function test()
    {
        $test['result'] = [];
        $ret = [];
        $routes = $this->getRoutes();
        $userIdNum = 0;
        $newUesrId = '';
        $oldUserId = '';
        foreach ( $routes as $index => $route )
        {
            $newUesrId = $route->id;
            if ( $newUesrId != $oldUserId )
            {
                $userIdNum++;
                $ret[$userIdNum]['personal_id'] = $route->id;
                $ret[$userIdNum]['email'] = $route->email;
                $ret[$userIdNum]['stage1'] = [];
                $ret[$userIdNum]['stage2'] = [];
                $ret[$userIdNum]['stage3'] = [];
                $ret[$userIdNum]['stage4'] = [];
            }
            $routeUserInfo = [];
            $routeUserInfo['personal_id'] = $route->target_user_id;
            $routeUserInfo['email'] = $route->route_user_email;
            $ret[$userIdNum]['stage'.$route->stage][] = $routeUserInfo;
            $oldUserId = $route->id;
        }
//        $test['result'] = $ret;
//        $test['result'] = array_values($test['result']);
        dd(json_encode($ret));
        return 'hello';
    }

    private function getRoutes()
    {
        $query = User::query();
        $query->join('routes', 'users.id' , '=','routes.user_id');
        $query->join('users as user2','user2.id', '=','routes.target_user_id');
        return $query->select(['users.id','users.email','stage','target_user_id','user2.email as route_user_email'])
            ->get();
    }
}
