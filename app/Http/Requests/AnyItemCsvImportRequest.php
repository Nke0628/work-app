<?php

namespace App\Http\Requests;

use App\Package\Domain\Department\RegisterDepartmentRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\hhmm;

class AnyItemCsvImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => [
                'required',
                'max:1024', // php.iniのupload_max_filesizeとpost_max_sizeを考慮する必要があるので注意
                'file',
                'mimes:csv,txt', // mimesの都合上text/csvなのでtxtも許可が必要
                'mimetypes:text/plain',
            ],
        ];
    }

    /**
     * エラーメッセージ設定
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.required'  => 'ファイルを指定してください',
            'file.max' => 'ファイルサイズが不正です',
            'file.file' => 'アップロードに失敗しました',
            'file.mimes' => 'csv形式のファイルを指定してください',
        ];
    }
}
