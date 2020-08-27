<?php
/**
 * インポートされたCSVファイルに対して、CSVに最適化されたSplFileObjectを生成する。
 */

namespace OaEtc\ImportData;

/**
 * Class ImportCsv
 * @package OaEtc\ImportData
 * @deprecated
 * FIXME App\Helperに移動させる
 */
class ImportCsv extends ImportFileAbstract
{
    const TO_CONVERT_ENCODING = 'UTF-8';
    const FROM_CONVERT_ENCODING = 'SJIS-win';

    const OUTPUT_TO_CONVERT_ENCODING = 'SJIS-win';
    const OUTPUT_FROM_CONVERT_ENCODING = 'UTF-8';

    # FIXME 名前を読み込み用に特化させる
    /**
     * CSV読み込み用のSplFileObjectを生成する。
     *
     * @param string $realPath
     *
     * @return \SplFileObject
     * @throws \Exception
     */
    public static function createFileObject(string $realPath): \SplFileObject
    {
        if (!is_file($realPath)) {
            throw new \Exception('ファイルが存在しません。');
        }

        $splObj = new \SplFileObject($realPath);
        $splObj->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        return $splObj;
    }

    /**
     * 書き込み用の一時ファイル作成。
     * メモリに吐き出すにはパフォーマンス上の懸念があるため、出力用のファイルを生成する。
     * この関数を利用したときは、適宜unLinkTempCsvFile()でファイルを削除してください。
     *
     * @param string $tempFileName
     *
     * @return \SplFileObject
     */
    public static function makeWritingEmptyTempFile(string $tempFileName): \SplFileObject
    {
        \Storage::disk('tmp')->put($tempFileName, '');

        return (new \SplFileInfo(storage_path('tmp') . DIRECTORY_SEPARATOR . $tempFileName))
            ->openFile('w');
    }

    /**
     * ファイルの削除
     *
     * @param \SplFileObject $splFileObject
     *
     * @return bool
     */
    public static function unLinkFile(\SplFileObject $splFileObject): bool
    {
        return unlink($splFileObject->getRealPath());
    }

    /**
     * CSV出力時のレスポンス形式生成
     *
     * @param string $csvContents
     * @param \SplFileObject $splFileObject
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public static function responseCsvHeader(string $csvContents, \SplFileObject $splFileObject)
    {
        return response($csvContents)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $splFileObject->getFilename() . '"');
    }

    /**
     * CSV取込み時に役職略称のゆらぎを吸収する
     * @param string $shotPositionName
     * @return string
     */
    public static function convertShortPositionNameForImport( string $shotPositionName ) : string
    {
        $shotPositionName = mb_convert_kana($shotPositionName, 'ask'); // 全角を半角に
        $shotPositionName = str_replace("’", "'", $shotPositionName); // 全角シングルクォーテーションを半角に
        $shotPositionName = str_replace(' ', '', $shotPositionName); // スペースを除く
        return strtoupper($shotPositionName); // 小文字を大文字に
    }

    /**
     * CSV出力時の文字エンコードを変換を行う
     *
     * @param array $row
     *
     * @return array
     */
    public static function convertOutPutEncodingVariables(array $row): array
    {
        // FIXME コンバート処理をApp\Helper\Csv\OutputCsvHelperに移動させる
        mb_convert_variables(self::OUTPUT_TO_CONVERT_ENCODING, self::OUTPUT_FROM_CONVERT_ENCODING, $row);

        return $row;
    }

    # FIXME 関数名をインポート時の文字コード変換にする。$recodeを$rowに修正する。
    /**
     * 文字エンコードを変換する
     *
     * @param array $recode
     *
     * @return array
     */
    public static function convertEncodingVariables(array $recode): array
    {
        // FIXME コンバート処理をApp\Helper\Csv\ImportCsvHelperに移動させる
        if (!mb_convert_variables(self::TO_CONVERT_ENCODING, self::FROM_CONVERT_ENCODING, $recode)) {
            throw new \UnexpectedValueException('文字コードの変換に失敗しました。');
        }

        return $recode;
    }

    /**
     * CSVフォーマットかどうかを検証する
     *
     * @param array $recode
     * @param int $expectedColumnNum
     *
     * @return bool
     * // FIXME コンバート処理をApp\Helper\CsvHelperに移動させる
     */
    public static function isFormatCsv(array $recode, int $expectedColumnNum): bool
    {
        if (count($recode) !== $expectedColumnNum) {
            return false;
        }

        // 全てのデータが,（カンマ）区切りになっているかどうかチェック
        $filterRecode = array_map(function ($row) {
            return strpos($row, ',') !== false;
        }, $recode);

        if (count($filterRecode) !== count($recode)) {
            return false;
        }

        return true;
    }
}
