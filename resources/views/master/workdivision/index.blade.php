@extends('layout.main_content')

@section('content')
    <div class="p-work-division">
        <div class="p-work-division-header">
            <div class="p-work-division-header__title">
                <h4>カテゴリーマスター</h4>
            </div>
        </div>
        <div class="p-work-division-menu">
            <div class="p-work-division-menu__item">
                <button type="button" class="c-button--blue _js_modal_open" data-target="add">新規登録</button>
            </div>
            <div class="p-work-division-menu__item">
                <button class="c-button">一括削除</button>
            </div>
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
@endsection
