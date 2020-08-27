<?php


namespace App\Package\Domain\Csv;


use App\Package\Domain\Helpers\StringHelper;

class SuriawaseAnyItemRow
{
    private const COL_NAME_USER_ID = 'ユーザID';
    private const HEADER = [
        self::COL_NAME_USER_ID => 'user_id'
    ];
    // 保持したい形 $colNoList[key_name] = カラムNO
    public static function headerValidation( array $headerList ): string
    {
        $ret = '';

        foreach ( self::HEADER as $column => $val )
        {
            if ( !in_array( $column , $headerList ) )
            {
                $ret .= $column. 'は必須項目です'  . "\n";
            }
        }

        while( ($index = array_search( self::COL_NAME_USER_ID, $headerList, true )) !== false ) {
            unset( $headerList[$index] ) ;
        }

        if ( count( $headerList ) === 0 )
        {
            $ret .= self::COL_NAME_USER_ID . '以外の項目を１列以上入力してください';
        }

        foreach ( $headerList as $header )
        {
            if ( !StringHelper::mbTrim($header) )
            {
                return '任意項目の列目は文字列で入力してください';
            }
        }
        return $ret;
    }
}
