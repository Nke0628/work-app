@extends('layout.app')

@section('content')
    <div class="p-login">
        <div class="p-login-container">
            <div class="p-login-title">WorkClock</div>
            <div class="p-login-form">
                <div class="p-login-form__title">ログイン</div>
                <form method="post" action="/login">
                    @csrf
                    <div class="p-login-form-input-group">
                        <label class="p-login-form-input-group__label">メールアドレス</label>
                        @if ($errors->has('email'))
                            <div class="p-login-form-input-group__error">
                                <span class="c-alert">{{ $errors->first('email') }}</span>
                            </div>
                        @endif
                        <input type="text" name="email" class="p-login-form-input-group__input{{ $errors->has('email') ? '--error' : '' }}">
                    </div>
                    <div class="p-login-form-input-group">
                        <label class="p-login-form-input-group__label">パスワード</label>
                        @if ($errors->has('password'))
                            <div class="p-login-form-input-group__error">
                                <span class="c-alert">{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                        <input type="password" name="password" class="p-login-form-input-group__input{{ $errors->has('password') ? '--error' : '' }}">
                        <a class="p-login-form-input-group__link" href="#">パスワードを忘れた方はこちら</a>
                    </div>
                    <div class="p-login-form-submit">
                        <input type="submit" class="c-button--green p-login-form-submit__input" value="ログイン">
                        <a class="p-login-form-submit__link" href="/signup">会員登録はこちら</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
