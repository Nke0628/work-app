@extends('layout.main_content')

@section('content')
    <div class="p-register-department">
        <div class="p-register-department-header">
            <div class="p-register-department-header__title">
                組織登録
            </div>
        </div>
        <div class="c-horizon"></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="p-register-department-form" method="post" action="/department/register">
            @csrf
            <div class="p-register-department-form-input-group">
                <label class="p-register-department-form-input-group__label" for="">
                    1.名称
                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true"
                       title="組織名称です。<br>255文字以内で入力してください。"></i></label>
                <input type="text" name="department_name" class="p-register-department-form-input-group__input">
            </div>
            <div class="p-register-department-form-input-group">
                <label class="p-register-department-form-input-group__label" for="">2.勤務開始時間</label>
                <input type="text" name="work_time_start" class="p-register-department-form-input-group__input">
            </div>
            <div class="p-register-department-form-input-group">
                <label class="p-register-department-form-input-group__label" for="">3.勤務終了時間</label>
                <input type="text" name="work_time_end" class="p-register-department-form-input-group__input">
            </div>
            <div class="p-register-department-form-input-group">
                <label class="p-register-department-form-input-group__label" for="">4.休憩開始時間</label>
                <input type="text" name="break_time_start" class="p-register-department-form-input-group__input">
            </div>
            <div class="p-register-department-form-input-group">
                <label class="p-register-department-form-input-group__label" for="">5.休憩終了時間</label>
                <input type="text" name="break_time_end" class="p-register-department-form-input-group__input">
            </div>
            <div>
                <button type="submit" class="p-register-department-form__button c-button--blue">登録</button>
            </div>
        </form>
    </div>
@endsection
