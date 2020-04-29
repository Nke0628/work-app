@extends('layout.app')

@section('content')
    <div class="p-register">
        <div class="p-register-container">
            <div class="p-register-title">WorkClock</div>
            <div class="p-register-form">
                <div class="p-register-form__title">WorkClokに登録する</div>
                <form method="post" action="/signup">
                    @csrf
                    <div class="p-register-form-input-group">
                        <label class="p-register-form-input-group__label">ニックネーム</label>
                        @if ($errors->has('name'))
                            <div class="p-register-form-input-group__error">
                                <span class="c-alert">{{ $errors->first('name') }}</span>
                            </div>
                        @endif
                        <input type="text" name="name" class="p-register-form-input-group__input{{ $errors->has('name') ? '--error' : '' }}">
                    </div>
                    <div class="p-register-form-input-group">
                        <label class="p-register-form-input-group__label">メールアドレス</label>
                        @if ($errors->has('email'))
                            <div class="p-register-form-input-group__error">
                                <span class="c-alert">{{ $errors->first('email') }}</span>
                            </div>
                        @endif
                        <input type="text" name="email" class="p-register-form-input-group__input{{ $errors->has('email') ? '--error' : '' }}">
                    </div>
                    <div class="p-register-form-input-group">
                        <label class="p-register-form-input-group__label">パスワード</label>
                        @if ($errors->has('password'))
                            <div class="p-register-form-input-group__error">
                                <span class="c-alert">{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                        <input type="password" name="password" class="p-register-form-input-group__input{{ $errors->has('password') ? '--error' : '' }}">
                    </div>
                    <div class="p-register-form-checkbox">
                        <input type="checkbox" class="p-register-form-checkbox__input">
                        <span class="p-register-form-checkbox__label">利用規約に同意する</span>
                    </div>
                    <div class="p-register-form-submit">
                        <input type="submit" class="c-button--green" value="登録する(無料)">
                    </div>
                </form>
                <div class="c-horizon"></div>
                <!--  TODO SNS認証処理をあとで作成する  -->
                <div class="p-register-social-account">
                    <div class="p-register-social-account__title">ソーシャルアカウントで登録する</div>
                    <div class="p-register-social-account__button-group">
                        <button class="c-button _js_modal_close">キャンセル</button>
                        <button class="c-button--blue" onclick="WorkDivision_lib.ReSubmit(this)">保存</button>
                    </div>
                </div>
                <div class="c-horizon"></div>
                <div class="p-register-login-link">
                    <a href="">ログイン</a>
                </div>
            </div>
        </div>
    </div>
@endsection
