@extends('layout.main_content')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-work-clock-csv">
        <form method="post" action="csv/upload" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <button type="submit" class="c-button--green">CSVアップロード</button>
        </form>
    </div>
@endsection
