<?php


namespace App\Package\Domain\Csv;


use App\Package\UseCase\Error\Dto\ErrorMessageDto;

class AnyItemImportService
{
    /**
     * ヘッダーバリデーション
     *
     * @param array $record
     * @param ErrorMessageDto $errorMessageDto
     * @throws \Exception
     */
    public function validationHeader( array $record, ErrorMessageDto $errorMessageDto )
    {
        if ( !AnyItemCsvValidate::isExistRequireColumn( $record ) )
        {
            $errorMessageDto->addMessage( AnyItemCsvValidate::MESSAGE_NON_REQUIRE_COLUMN );
            throw new \Exception(AnyItemCsvValidate::MESSAGE_NON_REQUIRE_COLUMN);
        }

        if ( !AnyItemCsvValidate::isExistAnyItemColumn( $record ) )
        {
            $errorMessageDto->addMessage( AnyItemCsvValidate::MESSAGE_NON_ANY_ITEM_COLUMN );
            throw new \Exception(AnyItemCsvValidate::MESSAGE_NON_ANY_ITEM_COLUMN);
        }

        if ( !AnyItemCsvValidate::nonExistEmptyColumn( $record ) )
        {
            $errorMessageDto->addMessage( AnyItemCsvValidate::MESSAGE_EXIST_EMPTY_COLUMN );
            throw new \Exception(AnyItemCsvValidate::MESSAGE_EXIST_EMPTY_COLUMN);
        }
    }

    /**
     * カラムインデックスを取得
     *
     * @param array $record
     * @return array
     */
    public function getColumnNoList( array $record ):array
    {
        $anyItemIndex = 'any_item';
        $userIdIndex = 'user_id';

        $colNoList = [];
        foreach ( $record as $index => $item )
        {
            if ( $item === AnyItemCsvValidate::COL_NAME_USER_ID )
            {
                $colNoList[$userIdIndex] = $index;
            }
            else
            {
                $colNoList[$anyItemIndex . '_' .$index] = $index;
            }
        }
        return $colNoList;
    }

    /**
     * 任意項目かどうか
     *
     * @param int $colNo
     * @param $colNoList
     * @return bool
     */
    public function isAnyItem( int $colNo, $colNoList ): bool
    {
        if ( $colNo != $colNoList['user_id'] )
        {
            return true;
        }
        return false;
    }

    public function getColumnNoIndex( $record )
    {
        $ret = [];
        foreach ( $record as $index => $header )
        {
            if ( $header === AnyItemCsvValidate::COL_NAME_USER_ID )
            {
                $ret['user_id'] = $index;
            }
            else
            {
                $ret['any_item'][] = $index;
            }
        }
        return $ret;
    }

}
