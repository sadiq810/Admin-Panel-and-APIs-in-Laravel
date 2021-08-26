@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('all.manage_orders') }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('all.order_id') }}</th>
                                    <th>{{ __('all.customer') }}</th>
                                    <th>{{ __('all.total_quantity') }}</th>
                                    <th>{{ __('all.total_amount') }}</th>
                                    <th>{{ __('all.status') }}</th>
                                    <th>{{ __('all.date') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var table = null;

            $(document).ready(function () {
                table = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('orders.datatables', app()->getLocale()) }}",
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'id', name: 'id'},
                        { data: 'customer.name', name: 'customer.name'},
                        { data: 'quantity', name: 'quantity'},
                        { data: 'total', name: 'total'},
                        { data: 'status', name: 'status'},
                        { data: 'date', name: 'created_at'}
                    ],
                    "order": [[ 1, "desc" ]],
                });

                $('#datatable tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        if ( table.row( '.shown' ).length )
                            $('.details-control', table.row( '.shown' ).node()).click();

                        row.child(formatTable(row.data())).show();
                        var bid = row.data().id;
                        childTable = $('#in' +bid).DataTable({
                            "destroy": true,
                            "info": false,
                            select: false,
                            "bProcessing": true,
                            "filter": false,
                            "paging": false,
                            stateSave: true,
                            ajax: {
                                url: "{{ route('order.detail.grid', app()->getLocale()) }}?id=" + bid,
                                "type": "GET"
                            },
                            columns: [
                                { data: 'feature_items', name: 'feature_items'},
                                { data: 'feature_options', name: 'feature_options'},
                                { data: 'price', name: 'price' },
                                { data: 'status', name: 'status'}
                            ],
                            "order": [[ 1, "desc" ]],
                        });
                        tr.addClass('shown');
                    }
                });
            });//..... end of ready() .....//

            function formatTable(rowData) {
                var childTable = '<table id="in' + rowData.id + '" class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" width="100%">' +
                    '<thead><th>{{ __("all.items") }}</th><th>{{ __('all.options') }}</th><th>{{ __("all.price") }}</th><th>{{ __("all.status") }}</th></thead> ' +
                    '</table>';
                return $(childTable).toArray();
            }
        </script>
    </div>
@endsection
