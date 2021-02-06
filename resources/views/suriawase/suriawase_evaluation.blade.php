@extends('layout.main_content')

@section('content')
    <ul class="nav nav-tabs" id="test">
        @foreach($tab_items as $tab)
            <li class="@if($tab['is_active_tab'] ) active @endif"><a href="#sampleContent{{$tab['tab_id']}}" data-toggle="tab" class="tab">{{$tab['tab_name']}}</a></li>
        @endforeach
    </ul>

    <!-- タブ内容 -->
    <div class="tab-content">
        @foreach($tab_items as $tab)
            <div class="tab-pane @if($tab['is_active_tab']) active @endif" id="sampleContent{{$tab['tab_id']}}">
                <table>
                    @foreach($tab['items'] as $item)
                        <th>{{$item['item_name']}}</th>
                    @endforeach
                        <tr>
                    @foreach($tab['values'] as $value)
                        @if ( $value['is_next_Row'])
                            </tr>
                            <tr>
                            <td>{{$value['value']}}</td>
                        @else
                            <td>{{$value['value']}}</td>
                        @endif
                    @endforeach
                        </tr>
                </table>
            </div>
        @endforeach
    </div>
@endsection



