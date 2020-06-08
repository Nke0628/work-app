@extends('layout.main_content')

@section('content')
    <div class="p-work-division">
        <div class="p-work-division-header">
            <div class="p-work-division-header__title">
                勤怠区分一覧
            </div>
        </div>
        <div class="p-work-division-menu">
            <div class="p-work-division-menu__item">
                <button type="button" class="c-button--blue _js_modal_open" data-target="add">新規登録</button>
            </div>
            <div class="p-work-division-menu__item">
                <button class="c-button">一括削除</button>
            </div>
            <div class="p-work-division-menu__item">
                <button class="c-button--green" onclick="WorkDivision_lib.CsvUpload(this)">CSVアップロード</button>
                <form method="post" class="_js_work_division_upload_csv" style="display: inline-block">
                    <input type="file" name="file">
                </form>
            </div>
        </div>
        <div class="p-work-division-upload-description">
            <p>【アップロードファイルの注意事項】</p>
            <div class="p-work-division-upload-description__detail">
                ・1行目は勤怠区分名称などの項目名を設定してください。<br>
                ・各項目は、カンマ区切り。<br>
                ・CSVファイルの文字コードは、「Shift-JIS」または「UTF-8」を使用してください。
            </div>
            <table class="p-work-division-upload-description-list">
                <thead>
                <tr>
                    <th></th>
                    <th>項目名</th>
                    <th>設定値</th>
                    <th>補足</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>ID</td>
                    <td>必須(数字)</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>勤怠区分名称</td>
                    <td>必須。255文字以内</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        @include('master.workdivision.Component.work_division_list')
    </div>

    <!-- 新規作成モーダル -->
    <div class="c-modal _js_modal_add">
        <div class="c-modal__content">
            <div class="p-work-division-modal">
                <div class="p-work-division-modal__title">新規作成</div>
                <div class="p-work-division-input-group">
                    <label  class="p-work-division-input-group__label">勤怠区分名称</label>
                    <input type="text"  class="p-work-division-input-group__input _js_work_division_name_input_add">
                </div>
                <div class="p-work-division-modal-button-group">
                    <button class="c-button _js_modal_close">キャンセル</button>
                    <button class="c-button--blue" onclick="WorkDivision_lib.Submit(this)">登録</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 編集モーダル -->
    <div class="c-modal _js_modal_edit">
        <div class="c-modal__content">
            <div class="p-work-division-modal">
                <div class="p-work-division-modal__title">編集</div>
                <div class="p-work-division-input-group">
                    <label  class="p-work-division-input-group__label">勤怠区分名称</label>
                    <input type="text" class="p-work-division-input-group__input _js_work_division_name_input_edit">
                    <input type="hidden" class="_js_work_division_id_input_edit">
                </div>
                <div class="p-work-division-modal-button-group">
                    <button class="c-button _js_modal_close">キャンセル</button>
                    <button class="c-button--blue" onclick="WorkDivision_lib.ReSubmit(this)">保存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- プレビューモーダル -->
    <div class="modal fade" id="upload-preview-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content _js_work_division_upload_modal_content">
            </div>
        </div>
    </div>
@endsection
