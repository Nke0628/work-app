<?php


namespace App\Package\Domain\Helpers;

/**
 * ページングに関する共通クラス
 */
class PagingHelper
{
    /**
     * ページングナンバーの生成
     *
     * @param int $pCurrentPage
     * @param int $pTotalRecord
     * @param int $pRecordPerPage
     * @param int $pShowNavLinkNum
     * @return array
     */
    public static function makePaging( int $pCurrentPage, int $pTotalRecord, int $pRecordPerPage=10, int $pShowNavLinkNum=5 ):array
    {
        $aTotalPage = ceil($pTotalRecord / $pRecordPerPage); //総ページ数

        // 全ページ数が表示するページ数より小さい場合、総ページを表示する数にする
        if ($aTotalPage < $pShowNavLinkNum)
        {
            $pShowNavLinkNum = $aTotalPage;
        }

        // トータルページ数が1以下か、現在のページが総ページより大きい場合表示しない
        if ($aTotalPage <= 1 || $aTotalPage < $pCurrentPage )
        {
            return array();
        }

        // 総ページの半分
        $aNavLinkHalf = floor($pShowNavLinkNum / 2);

        // 現在のページをナビゲーションの中心にする
        $aStartPage = $pCurrentPage - $aNavLinkHalf;
        $aEndPage = $pCurrentPage + $aNavLinkHalf;

        // 現在のページが両端だったら端にくるようにする
        if ($aStartPage <= 0)
        {
            $aStartPage = 1;
            $aEndPage = $pShowNavLinkNum;
        }

        if ($aEndPage > $aTotalPage)
        {
            $aStartPage = $aTotalPage - $pShowNavLinkNum + 1;
            $aEndPage = $aTotalPage;
        }

        $aRet = array(
            'start_page' => $aStartPage,
            'end_page' => $aEndPage
        );

        return $aRet;
    }
}
