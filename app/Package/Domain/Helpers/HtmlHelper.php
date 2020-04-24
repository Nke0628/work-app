<?php


namespace App\Package\Domain\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * HTMLに関する共通クラス
 */
class HtmlHelper
{
    /**
     * json形式に変更
     *
     * @param mixed $pValue
     * @return JsonResponse
     */
    public static function FixJsonEncode( $pValue ):JsonResponse
    {
        $aHeader = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );
        return response()->json( $pValue, 200, $aHeader, JSON_UNESCAPED_UNICODE );
    }
}
