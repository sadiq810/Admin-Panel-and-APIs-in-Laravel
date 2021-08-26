@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.faqs') }} <small>{{ __('all.list') }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-info btn-sm btn-round add-lang"><i class="fa fa-plus"></i>{{ __('all.add_new') }}</button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('all.title') }}</th>
                                    <th>{{ __('all.sort_order') }}</th>
                                    <th>{{ __('all.status') }}</th>
                                    <th style="text-align: center;">{{ __('all.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="addEditModal" class="modal fade bs-example-modal-xl lang-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="mainForm" method="post" action="{{ route('faqs.save', app()->getLocale()) }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_faq') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required"/>
                                </div>

                                <div class="form-group col-md-6 order">
                                    <label for="email">{{ __('all.sort_order') }}</label>
                                    <input type="number" id="order" class="form-control" name="order"/>
                                </div>

                                <div class="form-group col-md-6 image">
                                    <label for="fullname">{{ __('all.select_image') }}</label>
                                    <input type="file" class="form-control" name="image"/>
                                </div>

                                <div class="form-group col-md-6 status" style="margin-top: 20px">
                                    <div class="checkbox">
                                        <label>
                                            <input id="status" type="checkbox" name="status"> <span>{{ __('all.status') }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="email">{{ __('all.short_description') }}</label>
                                    <textarea name="short" id="short" class="form-control" required="required"></textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="email">{{ __('all.description') }}</label>
                                    <textarea name="description" id="pageContents" class="resizable_textarea form-control" required="required"></textarea>
                                </div>
                                <input type="hidden" id="hidden_id" name="id"/>
                                <input type="hidden" id="hidden_lang_id" name="lang_id"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('all.close') }}</button>
                            <input type="submit" id="saveBtn" class="btn btn-primary" value="{{ __('all.save') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            CKEDITOR.replace( 'pageContents');
            var mainForm = null;
            var addEditModal = null;
            var saveBtn = null;
            var hidden_id = null;
            var hidden_lang_id = null;
            var title = null;
            var short = null;
            var order = null;
            var childTable = null;
            var table = null;
            var sTable = 'main';

            var selectedRecordOfSubTable = null;

            $(document).ready(function () {
                mainForm = $('#mainForm');
                addEditModal = $('#addEditModal');
                saveBtn = $('#saveBtn');
                hidden_id = $('#hidden_id');
                hidden_lang_id = $('#hidden_lang_id');
                title = $('#title');
                order = $('#order');
                short = $('#short');

                table = $('#datatable-responsive').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: "{{ route('faqs.list', app()->getLocale()) }}",
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'title', name: 'title', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="title" data-title="{{ __('all.enter_title') }}" data-type="text" data-pk="${row.id}">${data}</a>`
                            }
                        },
                        { data: 'order', name: 'order', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-title="{{ __('all.sort_order') }}" data-name="order" data-type="text" data-pk="${row.id}">${data}</a>`
                            }
                        },
                        { data: 'status', name: 'status', orderable: false, searchable: false, className: "center-text", render: function (d, t, r) {
                                return `<a href="#" class="changeStatus" data-name="status" data-value="${d}" data-type="select" data-pk="${r.id}" data-title="{{ __('all.select_status') }}"></a>`;
                            }
                        },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text" }
                    ],
                    "drawCallback": function (setting) {
                        initializeEditable();
                        initializeStatusEditable();
                    },
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    hidden_id.val('');
                    hidden_lang_id.val('');
                    mainForm.trigger("reset");
                    sTable = 'main';
                    CKEDITOR.instances.pageContents.setData('');
                    $('.order').show();
                    $('.image').show();
                    $('.status').show();
                    addEditModal.modal('show');
                });

                /*---------------add and update records=========================================*/
                $('#mainForm').on('submit', function (e) {
                    e.preventDefault();
                    CKEDITOR.instances.pageContents.updateElement();
                    saveBtn.prop('disabled', true);
                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                mainForm.trigger("reset");
                                addEditModal.modal('hide');
                                sTable === 'sub' ? selectedRecordOfSubTable.ajax.reload(null, false) : table.ajax.reload(null, false);
                            } else showNotification(data.message, 'error', 'Error');

                            saveBtn.prop('disabled', false);
                        },
                        error: function (data) {
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                            saveBtn.prop('disabled', false);
                        }
                    });
                });

                /*---------------edit records=========================================*/
                $(document).on('click', '.edit', function () {
                    var data = table.row($(this).parents('tr')).data();
                    hidden_lang_id.val('');
                    hidden_id.val(data.id);
                    title.val(data.title);
                    order.val(data.order);
                    short.val(data.short);
                    $('#status').prop('checked', !!data.status);
                    sTable = 'main';
                    $('.order').show();
                    $('.image').show();
                    $('.status').show();
                    CKEDITOR.instances.pageContents.setData(decodeHTMLEntities(data.description));
                    addEditModal.modal('show');
                });

                /*---------------edit sub records=========================================*/
                $(document).on('click', '.editSub', function () {
                    var id = $(this).data('id');
                    selectedRecordOfSubTable = $('#in'+id).DataTable();
                    var data = selectedRecordOfSubTable.row($(this).parents('tr')).data();
                    hidden_lang_id.val(data.language_id);
                    hidden_id.val(data.id);
                    title.val(data.title);
                    order.val(data.order);
                    short.val(data.short);
                    $('#status').prop('checked', !!data.status);
                    sTable = 'sub';
                    $('.order').hide();
                    $('.image').hide();
                    $('.status').hide();
                    CKEDITOR.instances.pageContents.setData(decodeHTMLEntities(data.description));
                    addEditModal.modal('show');
                });

                $('#datatable-responsive tbody').on('click', 'td.details-control', function () {
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
                            ajax: {
                                url: "{{ route('faqs.detail.grid', app()->getLocale()) }}?id=" + bid,
                                "type": "GET"
                            },
                            columns: [
                                { data: 'title', name: 'title', render: function (data, t, row) {
                                        return `<a href="#" class="editable__field" data-title="{{ __('all.enter_title') }}" data-name="title" data-type="text" data-pk="${row.id + '_' + row.language_id}">${data}</a>`;
                                    }
                                },
                                { data: 'local_name', name: 'local_name' },
                                { data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text" }
                            ],
                            "drawCallback": function (setting) {
                                initializeSubEditable();
                            },
                            "destroy": true,
                            "info": false,
                            select: false,
                            "bProcessing": true,
                            "filter": false,
                            "paging": false,
                            stateSave: true,
                        });
                        tr.addClass('shown');
                    }
                });
            });

            function formatTable(rowData) {
                var childTable = '<table id="in' + rowData.id + '" class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" width="100%">' +
                    '<thead><th>{{ __("all.title") }}</th><th>Language</th><th>{{ __("all.action") }}</th></thead> ' +
                    '</table>';
                return $(childTable).toArray();
            }

            function initializeEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.faq.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//

            function initializeSubEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.faq.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        childTable.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//

            function initializeStatusEditable() {
                $('.changeStatus').editable({
                    source: [
                        {value: 0, text: 'DeActive'},
                        {value: 1, text: 'Active'}
                    ],
                    url: '{{ route('update.faq.field', app()->getLocale()) }}',
                    success: function (response, newValue) {
                        if (!response.status) return response.message;
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeStatusEditable() .....//
        </script>
    </div>
@endsection
