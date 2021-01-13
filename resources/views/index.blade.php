@extends('layout.main_content')

@section('content')
    <div style="padding:30px;" class="p-suriawase">
        <div style="display: flex; justify-content: space-between; margin-bottom: 40px">
            <div style="font-weight: bold;font-size: 24px">
                すり合わせ登録
            </div>
            <div>
                <button class="btn btn-dark" style="font-size: 18px">一覧に戻る</button>
                <button class="btn btn-info" style="font-size: 18px">表示データ登録</button>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#sample1" data-toggle="tab" style="">基本情報</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sample2" data-toggle="tab">参加者</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sample3" data-toggle="tab">評価対象者</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sample4" data-toggle="tab">表示項目</a>
            </li>
        </ul>
        <div class="tab-content p-tab-content" style="background: #f5f5f5 ;height: 500px;">
            <div id="sample1" class="tab-pane active">
                <div style="font-weight: bold;font-size: 18px;border-bottom: 1px solid #dee2e6; margin-bottom: 10px">すり合わせタイトル</div>
                <div style="margin-bottom: 30px">
                    <input type="text" style="width: 100%">
                </div>
                <div>
                    <div style="font-weight: bold; margin-bottom: 10px;font-size: 18px;border-bottom: 1px solid #dee2e6">すり合わせ種類</div>
                    <div>管理職すり合わせ</div>
                </div>
            </div>
            <div id="sample2" class="tab-pane">
                <div>参加者サンプル</div>
                <div>参加者サンプル</div>
                <div>参加者サンプル</div>
                <div>参加者サンプル</div>
            </div>
            <div id="sample3" class="tab-pane">
                <div>評価対象者サンプル</div>
                <div>評価対象者サンプル</div>
                <div>評価対象者サンプル評価対象者サンプル</div>
                <div>評価対象者サンプル</div>
                <div>評価対象者サンプル</div>
                <div>評価対象者サンプル</div>
            </div>
            <div id="sample4" class="tab-pane">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#sample5" data-toggle="tab" style="">基本</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sample6" data-toggle="tab">360度評価</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sample7" data-toggle="tab">すり合わせ</a>
                    </li>
                </ul>
                <div class="tab-content p-tab-content" style="background: #f5f5f5 ;height: 500px;">
                    <div id="sample5" class="tab-pane active">
                        <div style="font-weight: bold;font-size: 18px;border-bottom: 1px solid #dee2e6; margin-bottom: 10px">すり合わせタイトル</div>
                        <div style="margin-bottom: 30px">
                            <input type="text" style="width: 100%">
                        </div>
                        <div>
                            <div style="font-weight: bold; margin-bottom: 10px;font-size: 18px;border-bottom: 1px solid #dee2e6">すり合わせ種類</div>
                            <div>管理職すり合わせ</div>
                        </div>
                    </div>
                    <div id="sample6" class="tab-pane">
                        <div>参加者サンプル</div>
                        <div>参加者サンプル</div>
                        <div>参加者サンプル</div>
                        <div>参加者サンプル</div>
                    </div>
                    <div id="sample7" class="tab-pane">
                        <div>評価対象者サンプル</div>
                        <div>評価対象者サンプル</div>
                        <div>評価対象者サンプル評価対象者サンプル</div>
                        <div>評価対象者サンプル</div>
                        <div>評価対象者サンプル</div>
                        <div>評価対象者サンプル</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
