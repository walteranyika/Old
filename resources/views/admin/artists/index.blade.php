@extends('layouts.admin')
@section('content')
@can('artist_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.artists.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.artist.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.artist.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Artist" id="myTable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.artist.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.artist.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.artist.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.artist.fields.enabled') }}?
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artists as $key => $artist)
                    <tr data-entry-id="{{ $artist->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $artist->id ?? '' }}
                        </td>
                        <td>
                            {{ $artist->name ?? '' }}
                        </td>
                        <td>
                            {{ $artist->phone ?? '' }}
                        </td>
                        <td>
                            <span style="display:none">{{ $artist->enabled ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $artist->enabled ? 'checked' : '' }}>
                        </td>
                        <td>
                            @can('artist_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.artists.show', $artist->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('artist_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.artists.edit', $artist->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('artist_delete')
                            <form action="{{ route('admin.artists.destroy', $artist->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        @can('artist_delete')
        let deleteButtonTrans = 'Delete'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.artists.massDestroy') }}",
            className: 'btn-danger',
            action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('0 Items Selected')

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
        let table = $('.datatable-Artist:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        let visibleColumnsIndexes = null;
        $('.datatable thead').on('input', '.search', function() {
            let strict = $(this).attr('strict') || false
            let value = strict && this.value ? "^" + this.value + "$" : this.value

            let index = $(this).parent().index()
            if (visibleColumnsIndexes !== null) {
                index = visibleColumnsIndexes[index]
            }

            table
                .column(index)
                .search(value, strict)
                .draw()
        });
        table.on('column-visibility.dt', function(e, settings, column, state) {
            visibleColumnsIndexes = []
            table.columns(":visible").every(function(colIdx) {
                visibleColumnsIndexes.push(colIdx);
            });
        })
    })
</script>
@endsection