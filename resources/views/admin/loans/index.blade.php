@extends('layouts.admin')
@section('content')
@can('loan_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.loans.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.loan.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.loan.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Loan">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.processed') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.repaid') }}
                        </th>
                        <th>
                            {{ trans('cruds.loan.fields.artist') }}
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
                    @foreach($loans as $key => $loan)
                    <tr data-entry-id="{{ $loan->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $loan->id ?? '' }}
                        </td>
                        <td>
                            {{ $loan->amount ?? '' }}
                        </td>
                        <td>
                            {{ $loan->code ?? '' }}
                        </td>
                        <td>
                            {{ $loan->duration ?? '' }}
                        </td>
                        <td>
                            <span style="display:none">{{ $loan->processed ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $loan->processed ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $loan->repaid ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $loan->repaid ? 'checked' : '' }}>
                        </td>
                        <td>
                            {{ $loan->artist->name ?? '' }}
                        </td>
                        <td>
                            {{ $loan->artist->phone ?? '' }}
                        </td>
                        <td>
                            @can('loan_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.loans.show', $loan->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('loan_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.loans.edit', $loan->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('loan_delete')
                            <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('loan_delete')
        let deleteButtonTrans = '{{ trans('
        global.datatables.delete ') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.loans.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('
                        global.datatables.zero_selected ') }}')

                    return
                }

                if (confirm('{{ trans('
                        global.areYouSure ') }}')) {
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
        let table = $('.datatable-Loan:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>
@endsection