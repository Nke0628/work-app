@extends('layout.main_content')

@section('content')
    <ul class="nav nav-tabs" id="test">
        <li><a href="#sampleContentA" data-toggle="tab" class="atab">タブＡ</a></li>
        <li class="active"><a href="#sampleContentB" data-toggle="tab" onclick="Tab_lib.test( event, this)">タブＢ</a></li>
        <li><a href="#sampleContentC" data-toggle="tab">タブＣ</a></li>
        <li><a href="#sampleContentD" data-toggle="tab">タブＤ</a></li>
    </ul>

    <!-- タブ内容 -->
    <div class="tab-content">
        <div class="tab-pane" id="sampleContentA">
            <p>タブＡの内容</p>
        </div>
        <div class="tab-pane active" id="sampleContentB">
            <p>タブＢの内容</p>
        </div>
        <div class="tab-pane" id="sampleContentC">
            <p>タブＣの内容</p>
        </div>
        <div class="tab-pane" id="sampleContentD">
            <p>タブＤの内容</p>
        </div>
    </div>
@endsection
