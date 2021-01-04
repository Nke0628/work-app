@extends('layout.main_content')

@section('content')
    <div class="p-position-change-apply">
        <form action="/position_change_apply/register" method="post">
            @csrf
            <input type="text" name="sky_id">
            <input type="text" name="position_id">
            <input type="submit" value="登録">
        </form>
    </div>
@endsection
