<?php


namespace App\Package\Domain\Helpers;

/**
 * エンコードに関する共通クラス
 */
class EncodeHelper
{
    /**
     * 内部指定のエンコードに変換する
     *
     * @param string|array $pVars エンコード対象
     * @return mixed
     */
    public static function encodeToUtf8( $pVars )
    {
        $aStr = $pVars;
        if ( is_array( $pVars ) )
        {
            //配列の場合は値を連結して判定
            $aStr = implode('', $pVars );
        }
        $aEnc = EncodeHelper::_MbDetectEncoding( $aStr, true );
        mb_convert_variables( 'UTF-8', $aEnc, $pVars );
        return $pVars;
    }

    /**
     * 文字コード特定
     * DetectWinFlgをたてた場合、Windows対応の文字コードを優先
     *
     * @param string $pStr
     * @param bool $pDetectWinFlg
     * @return bool|false|mixed|string
     */
    private static function _MbDetectEncoding( string $pStr, bool $pDetectWinFlg=false )
    {
        $aOrder = "UTF-8, UTF-7, EUC-JP, SJIS, ASCII";
        if ( $pDetectWinFlg )
        {
            $aOrder = "UTF-8, UTF-7, eucjp-win, EUC-JP, sjis-win, SJIS, ASCII";
        }
        return mb_detect_encoding( $pStr, $aOrder );
    }
}
