<?php


namespace App\Package\Domain\Csv;


use App\Package\Domain\Helpers\StringHelper;
use App\Package\UseCase\Error\ErrorMessageDto;

class AnyItemCsvValidate
{
    const MESSAGE_NON_REQUIRE_COLUMN = 'ユーザIDがは必須です';
    const MESSAGE_NON_ANY_ITEM_COLUMN = '任意項目の列が一列以上必要です';
    const MESSAGE_EXIST_EMPTY_COLUMN = '空行が存在しております';

    const COL_NAME_USER_ID = 'ユーザID';
    const HEADER_LIST = [
        'ユーザID'
    ];

    /**
     * 必須項目チェック
     *
     * @param array $record
     * @return bool
     */
    public static function isExistRequireColumn( array $record ): bool
    {
        foreach ( self::HEADER_LIST as $header )
        {
            if ( !in_array( $header, $record ) )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * 任意項目のカラムが存在しているか確認
     *
     * @param array $record
     * @return bool
     */
    public static function isExistAnyItemColumn( array $record ): bool
    {
        while( ($index = array_search( self::COL_NAME_USER_ID, $record, true )) !== false ) {
            unset( $record[$index] ) ;
        }

        if ( count( $record ) === 0 )
        {
           return false;
        }
        return true;
    }

    /**
     * 空のタイトル行がないか
     *
     * @param array $record
     * @return string
     */
    public static function nonExistEmptyColumn( array $record )
    {
        foreach ( $record as $item )
        {
            if ( !StringHelper::mbTrim( $item ) )
            {
                return false;
            }
        }
        return true;
    }
}
