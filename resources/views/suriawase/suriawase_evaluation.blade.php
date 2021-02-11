@extends('layout.main_content')

@section('content')
    <div class="p-jinji-suriawase-meeting">
        <div class="search-section">
            <div class="search-section__title">検索</div>
            <div class="search-section__template _js_search_section_template">
                <select class="search-section__select-box _js_search_section_select_box">
                    @foreach( $item_list as $index => $item)
                        <option value="{{$index}}">{{$item['title']}}</option>
                    @endforeach
                </select>
                の
                <input type="text" class="search-word">
                が
                <select class="search-condition">
                    <option value="1">完全一致</option>
                    <option value="2" selected>部分一致</option>
                    <option value="3">以上</option>
                    <option value="4">以下</option>
                </select>
            </div>
            <div class="_js_search_section_condition_area">
                <div class="search-section__condition_group _js_search_section_condition_group">
                    <select class="search-section__select-box _js_search_section_select_box">
                        @foreach( $item_list as $index => $item)
                            <option value="{{$index}}">{{$item['title']}}</option>
                        @endforeach
                    </select>
                    の
                    <input type="text" class="search-word">
                    が
                    <select class="search-condition">
                        <option value="1">完全一致</option>
                        <option value="2" selected>部分一致</option>
                        <option value="3">以上</option>
                        <option value="4">以下</option>
                    </select>
                </div>
                <div>
                    <input type="button" value="検索" class="btn btn-info search-btn">
                    <input type="button" value="クリア" class="btn btn-dark clear-btn">
                    <div class="btn btn-danger _js_plus">検索追加 <i class="search-section__plus-icon fas fa-plus"></i></div>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="test">
            @foreach($tab_list as $tab)
                <li class="@if($tab['is_first_tab'] ) active @endif"><a href="#sampleContent{{$tab['tab_id']}}" data-toggle="tab" class="tab">{{$tab['tab_name']}}</a></li>
            @endforeach
        </ul>

        <!-- タブ内容 -->
        <div class="tab-content">
            @foreach($tab_list as $tab)
                <div class="tab-pane @if($tab['is_first_tab']) active @endif" id="sampleContent{{$tab['tab_id']}}">
                    <table id="meeting{{$tab['tab_id']}}" class="table table-bordered">
                    </table>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready( function () {

            const SEARCH_SECTION_TEMPLATE = '._js_search_section_template';
            const CLASS_SEARCH_SECTION_TEMPLATE = '_js_search_section_template';
            const SEARCH_SECTION_SELECT_BOX = '._js_search_section_select_box';
            const SEARCH_CONDITION = {
                match : 1,
                partial_match : 2,
                more : 3,
                less :4
            };

            var itemList = @json($item_list);
            var rowList = @json($row_list);

            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
            } );

            let table = $('#meeting1').DataTable({
                paging: false,
                scrollY: '500px',
                searching: true,
                data: rowList,
                columns: itemList,
                'columnDefs': [
                    {
                        'targets': 1,
                        'width': '10px',
                        'searchable': false,
                        'orderable': false,
                        'render': function (data){
                            return '<input type="input" name="o_chk" value="' + data + '">'
                        }
                    },
                    {
                        'targets': 0,
                        'visible':false
                    }
                ],
                "createdRow": function( row, data, dataIndex ) {
                        $(row).addClass(`js${data[0]}`);
                },
            });

            $('._js_plus').on('click',function () {
                const template = $(SEARCH_SECTION_TEMPLATE).clone(true);
                template.removeClass(CLASS_SEARCH_SECTION_TEMPLATE);
                template.removeClass('search-section__template');
                template.addClass('_js_search_section_condition_group');
                template.addClass('search-section__condition_group');
                $('._js_search_section_condition_area').prepend(template);
            });

            $('.search-btn').on('click',function () {
                Common_Lib.ShowWait();
                table.draw();
                Common_Lib.HideWait();
            });

            $('.clear-btn').on('click',function () {
                Common_Lib.ShowWait();
                $.each($('._js_search_section_condition_group'),function (index,element) {
                    $(element).children(SEARCH_SECTION_SELECT_BOX).val(0);
                    $(element).children('.search-word').val('');
                    $(element).children('.search-condition').val(2);
                });
                table.draw();
                Common_Lib.HideWait();
            });

            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex, rowData ) {
                    let isMatch = true;
                    $.each($('._js_search_section_condition_group'),function (index,element) {
                        const searchSelect = $(element).children(SEARCH_SECTION_SELECT_BOX).val();
                        const searchWord = $(element).children('.search-word').val();
                        const searchCondition = $(element).children('.search-condition').val();
                        let target = '';
                        if ( searchSelect ==1 ) {
                            const meetingMemoTd = table.cell( dataIndex, 1 ).node();
                            const meetingMemoInput = $('input', meetingMemoTd);
                            const meetingMemoValue = meetingMemoInput.val();
                            target = meetingMemoValue;
                        }else {
                            target = data[searchSelect];
                        }

                        switch ( parseInt(searchCondition) ) {
                            case SEARCH_CONDITION.match:
                                if ( target !== searchWord ){
                                    isMatch = false;
                                    return false;
                                }
                                break;
                            case SEARCH_CONDITION.partial_match:
                                if ( target.indexOf(searchWord) === -1 ){
                                    isMatch = false;
                                    return false;
                                }
                                break;
                            case SEARCH_CONDITION.more:
                                if ( target < searchWord ){
                                    isMatch = false;
                                    return false;
                                }
                                break;
                            case SEARCH_CONDITION.less:
                                if ( target > searchWord ){
                                    isMatch = false;
                                    return false;
                                }
                                break;
                        }
                    });

                    return isMatch;
                }
            );
        } );
    </script>
@endsection



