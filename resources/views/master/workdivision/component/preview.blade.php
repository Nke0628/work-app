<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">アップロード確認</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div>
        <table class="p-work-division-upload-preview-list">
            <thead>
            <tr>
                <th class="p-work-division-upload-preview-list__no">行No</th>
                <th class="p-work-division-upload-preview-list__id">ID</th>
                <th class="p-work-division-upload-preview-list__work-division-name">勤怠区分名称</th>
            </tr>
            </thead>
            @foreach( $lists as $list )
            <tr class="@if( $list['is_error'] ) isError @endif _js_upload_work_division_row">
                <td class="p-work-division-upload-preview-list__no">{{ $list['no'] }}</td>
                <td class="p-work-division-upload-preview-list__id">
                    {{ $list['id'] }}
                    <input type="hidden" class="_js_upload_work_division_id" value="{{ $list['id'] }}">
                </td>
                <td class="p-work-division-upload-preview-list__work-division-name">
                    {{ $list['work_division_name'] }}
                    <input type="hidden" class="_js_upload_work_division_name" value="{{ $list['work_division_name'] }}">
                </td>
            </tr>
            @endforeach
        </table>
        <div class="p-work-division-upload-preview-error @if( $is_error ) isError @endif">
            <p>内容に誤りがあります。</p>
            @foreach( $err_msg_list as $list)
                <p>{{$list}}</p>
            @endforeach
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
    <button type="button" class="btn btn-primary"@if( $is_error ) disabled @endif onclick="WorkDivision_lib.CsvSave(this)">保存</button>
</div>
