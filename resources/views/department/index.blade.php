@extends('layout.main_content')

@section('content')
    <div class="p-department">
        <div class="p-department-search-form" style="margin-bottom: 15px">
            <form action="/department" method="GET">
                <div class="p-department-search-form-header">
                    <div class="p-department-search-form-header__search-word">
                        <div class="p-department-search-form-input-group">
                            <input type="text" name="search_query" class="p-department-search-form-input-group__input" placeholder="組織検索" value="{{$search_query}}">
                            <button type="submit" class="p-department-search-form-input-group__btn c-button--green">検索</button>
                            <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true"
                               title="下記の項目を対象に部分一致検索を行います。<br>tt"></i>
                        </div>
                    </div>
                    <div class="p-department-search-form-header__option-btn">
                        <button type="button" class="btn btn-outline-success">
                            <i class="fas fa-bars p-department-search-form-icon"></i>
                            検索オプション
                        </button>
                    </div>
                </div>
                <div class="p-department-search-option">
                    <div class="c-horizon"></div>
                    <div class="p-department-search-option-unit">
                        <div class="p-department-search-form-input-group">
                            <label class="p-department-search-form-input-group__label" for="">
                                組織名称
                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="下記の項目を対象に部分一致検索を行いま。<br>tt"></i>
                            </label>
                            <input type="text" name="department_name" class="p-department-search-form-input-group__input" value="{{$department_name}}">
                        </div>
                    </div>
                    <div class="p-department-search-option-unit">
                        <div class="p-department-search-form-input-group">
                            <label class="p-department-search-form-input-group__label" for="">
                                勤務開始時間
                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="下記の項目を対象に部分一致検索を行いま。<br>tt"></i>
                            </label>
                            <input type="text" name="start_work_time" class="p-department-search-form-input-group__input" value="{{$start_work_time}}">
                        </div>
                    </div>
                    <div class="p-department-search-option-unit">
                        <div class="p-department-search-form-input-group">
                            <label class="p-department-search-form-input-group__label" for="">
                                勤務終了時間
                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="下記の項目を対象に部分一致検索を行いま。<br>tt"></i>
                            </label>
                            <input type="text" name="end_work_time" class="p-department-search-form-input-group__input" value="{{$end_work_time}}">
                        </div>
                    </div>
                    <div class="p-department-search-option-unit">
                        <div class="p-department-search-form-input-group">
                            <label class="p-department-search-form-input-group__label" for="">
                                休憩開始時間
                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="下記の項目を対象に部分一致検索を行いま。<br>tt"></i>
                            </label>
                            <input type="text" name="start_break_time" class="p-department-search-form-input-group__input" value="{{$start_break_time}}">
                        </div>
                    </div>
                    <div class="p-department-search-option-unit">
                        <div class="p-department-search-form-input-group">
                            <label class="p-department-search-form-input-group__label" for="">
                                休憩終了時間
                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="right" data-html="true" title="下記の項目を対象に部分一致検索を行いま。<br>tt"></i>
                            </label>
                            <input type="text" name="end_break_time" class="p-department-search-form-input-group__input" value="{{$end_break_time}}">
                        </div>
                    </div>
                    <div class="p-department-search-option__search-btn">
                        <button type="submit" class="c-button--green">
                            この条件で検索する
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-department-page-link" style="display: flex; flex-direction: row-reverse">
            {!! $pages !!}
        </div>
        <div style="margin-top: 15px; border: 3px solid #e8e8e8; border-radius: 4px">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>組織名称</th>
                    <th>勤務開始時間</th>
                    <th>勤務終了時間</th>
                    <th>休憩開始時間</th>
                    <th>休憩終了時間</th>
                </tr>
                </thead>
                @foreach( $target_list as $list )
                    <tr>
                        <td>{{$list['department_name']}}</td>
                        <td>{{$list['start_work_time']}}</td>
                        <td>{{$list['end_work_time']}}</td>
                        <td>{{$list['start_break_time']}}</td>
                        <td>{{$list['end_break_time']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
