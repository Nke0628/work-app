<div class="p-work-division-list _js_work_division_list">
    <table class="p-work-division-list__table" border="1" rules="cols">
        <tr class="category-table__label">
            <th></th>
            <th class="js_category_master_item" data-column="id">ID</th>
            <th class="js_category_master_item" data-column="category_name">勤怠区分名称</th>
            <th class="js_category_master_item" data-column="updated_at">更新日</th>
            <th>編集</th>
        </tr>
        @foreach($work_division_list as $work_division)
            <tr class="category-table__row">
                <td>
                    <input type="checkbox" name="delete-chk[{{ $work_division['id'] }}]" class="">
                </td>
                <td data-label="id">
                    {{ $work_division['id'] }}
                </td>
                <td data-label="カテゴリー名称">
                    {{$work_division['division_name']}}
                </td>
                <td>
                    {{ $work_division['update_date'] }}
                </td>
                <td>
                    <button class="c-button _js_modal_open" data-target="edit" data-division-name="{{$work_division['division_name']}}"
                            data-id="{{ $work_division['id'] }}" onclick="WorkDivision_lib.SetEditModalValue(this)">編集</button>
                    <button class="c-button--red" onclick="WorkDivision_lib.Delete(this, {{ $work_division['id'] }})">削除</button>
                </td>
            </tr>
        @endforeach
    </table>
</div>
