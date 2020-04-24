<?php


namespace App\Package\Domain\Helpers;

/**
 * 文字列に関する共通クラス
 *
 */
class StringHelper
{
    /**
     * 空白を削除
     *
     * @param $pStr
     * @return string
     */
    public static function mbTrim( string $pStr ):string
    {
        return trim( mb_convert_kana( $pStr, 's') );
    }

    /**
     * 改行を除去
     *
     * @param string $pStr
     * @return string
     */
    public static function removeCRLF( string $pStr ):string
    {
        return str_replace( array("\r\n", "\r" ,"\n"), '', $pStr );
    }

    /**
     * 文字列を半角に変換
     *
     * @param string $pStr
     * @return string
     */
    public static function convertToHalf( string $pStr ):string
    {
        if ( !$pStr )
        {
            return null;
        }

        $aRet = mb_convert_kana( $pStr, 'a');
        $aRet = str_replace( '’', '\'', $aRet ); //mb_convert_kanaでは対応できないので別途変換
        $aRet = str_replace( '”', '"', $aRet ); //mb_convert_kanaでは対応できないので別途変換
        return $aRet;
    }
}
