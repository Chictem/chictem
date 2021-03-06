@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success">
            <i class="voyager-plus"></i> {{ trans('common.button.add') }}
        </a>
    </h1>
@stop

@section('page_header_actions')

@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($dataType->server_side)
                            @include('voyager::bread.filter')
                            @include('voyager::bread.search')
                        @endif
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr class="sort-items">
                                @foreach($dataType->browseRows as $rows)
                                    @if ($dataType->server_side)
                                        @php
                                            $para = array_merge(array_except(request()->query(), ['order_by', 'order_mode']), ['order_by' => $rows->field, 'order_mode' => (request()->query('order_mode') =='desc'? 'asc':'desc')])
                                        @endphp
                                        <th>
                                            <a class="sort-item sorting{{ (request()->query('order_by') == $rows->field)?('-'.request()->query('order_mode')):'' }}"
                                               href="{{ route('voyager.'.$dataType->slug.'.index', $para) }}">{{ $rows->display_name }}</a>
                                        </th>
                                    @else
                                        <th>
                                            {{ $rows->display_name }}
                                        </th>
                                    @endif
                                @endforeach
                                <th class="actions">{{ trans('common.button.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                        <td>
                                            @php $options = json_decode($row->details); @endphp
                                            @if($row->type == 'image')
                                                <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                                     style="width:100px">
                                            @elseif($row->type == 'select_multiple')
                                                @if ($data->{$row->field} && isset($options->relationship))
                                                    {{ @$data->{$row->field}->{implode(', ', $options->relationship->label)} }}
                                                @endif
                                            @elseif($row->type == 'select_dropdown')
                                                @if ($data->{$row->field} && isset($options->relationship) && $field = str_replace('_id', '', $row->field))
                                                    {{ @$data->{camel_case($field)}->{$options->relationship->label} }}
                                                @elseif($data->{$row->field} && isset($options->options))
                                                    {{ @$options->options->{($data->{$row->field})} }}
                                                @endif
                                            @elseif($row->type=='radio_btn')
                                                {{ @$options->options->{($data->{$row->field})} }}
                                            @else
                                                {{ @$data->{$row->field} }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}"
                                             id="delete-{{ $data->id }}">
                                            <i class="voyager-trash"></i> {{ trans('common.button.delete') }}
                                        </div>
                                        <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->id) }}"
                                           class="btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> {{ trans('common.button.edit') }}
                                        </a>
                                        <a href="{{ route('voyager.'.$dataType->slug.'.show', $data->id) }}"
                                           class="btn-sm btn-warning pull-right">
                                            <i class="voyager-eye"></i> {{ trans('common.button.read') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if (isset($dataType->server_side) && $dataType->server_side)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">
                                    {{ $dataTypeContent->firstItem() }} - {{ $dataTypeContent->lastItem() }}
                                    总 {{ $dataTypeContent->total() }} 条
                                </div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i
                                class="voyager-trash"></i> {{ trans('common.alert.delete', ['name' => $dataType->display_name_singular]) }}
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ trans('common.button.delete')}}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ trans('common.button.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        @if (!$dataType->server_side)
            $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [],
            });
        });
        @endif

        $('td').on('click', '.delete', function(e) {
            var form = $('#delete_form')[0];

            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
@stop
