<?php


namespace App\Package\Domain\Helpers;

/**
 * メディア処理に関する共通クラス
 *
 */
class MediaHelper
{
    /**
     * 拡張子取得
     *
     * @param string $pPath ファイルパス
     * @return string 拡張子
     */
    public static function getFileExt( string $pPath ):string
    {
        $aRet = '';
        if ( preg_match( '/.*\.([^\.]+)$/', basename($pPath), $aMatch) )
        {
            $aRet = $aMatch[1];
        }
        return $aRet;
    }

    public static function cnvDownloadFileName( string $pName ):string
    {
        $aEncoding = mb_internal_encoding();
        if ( $aEncoding === '' )
        {
            return $pName;
        }

        $aUA = $_SERVER['HTTP_USER_AGENT'];

        $aFilename_SJIS = mb_convert_encoding( $pName, 'SJIS-win', $aEncoding );
        $aFilename_UTF8 = mb_convert_encoding( $aFilename_SJIS, 'UTF-8', 'SJIS-win');

        // Default
        $aRet = '=?UTF-8?B?' . base64_encode( $aFilename_UTF8 ) . '?=';
    }
}
