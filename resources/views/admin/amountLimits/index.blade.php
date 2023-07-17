@extends('layouts.admin')
@section('content')
@can('amount_limit_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.amount-limits.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.amountLimit.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.amountLimit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AmountLimit" id="myTable">
                <thead>
                    <tr>
                        <th width=" 10">
                </th>
                <th>
                    {{ trans('cruds.amountLimit.fields.id') }}
                </th>
                <th class="text-right">
                    {{ trans('cruds.amountLimit.fields.royalties') }}
                </th>
                <th class="text-right">
                    {{ trans('cruds.amountLimit.fields.advance_limit') }}
                </th>
                <th>
                    {{ trans('cruds.amountLimit.fields.artist') }}
                </th>
                <th>
                    {{ trans('cruds.artist.fields.phone') }}
                </th>
                <th>
                    &nbsp;
                </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($amountLimits as $key => $amountLimit)
                    <tr data-entry-id="{{ $amountLimit->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $amountLimit->id ?? '' }}
                        </td>
                        <td class="text-right">
                            @money($amountLimit->royalties)
                        </td>
                        <td class="text-right">
                            @money($amountLimit->advance_limit)
                        </td>
                        <td>
                            {{ $amountLimit->artist->name ?? '' }}
                        </td>
                        <td>
                            {{ $amountLimit->artist->phone ?? '' }}
                        </td>
                        <td>
                            @can('amount_limit_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.amount-limits.show', $amountLimit->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('amount_limit_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.amount-limits.edit', $amountLimit->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('amount_limit_delete')
                            <form action="{{ route('admin.amount-limits.destroy', $amountLimit->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            @endcan

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function() {

        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('amount_limit_delete')
        let deleteButtonTrans = 'Delete'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.amount-limits.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('0 Selected')

                    return
                }

                if (confirm('Are you sure?')) {
                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                            },
                            method: 'POST',
                            url: config.url,
                            data: {
                                ids: ids,
                                _method: 'DELETE'
                            }
                        })
                        .done(function() {
                            location.reload()
                        })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [
                [1, 'desc']
            ],
            pageLength: 100,
        });
        let table = $('.datatable-AmountLimit:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>
@endsection