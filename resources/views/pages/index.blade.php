@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.pages') }} <small>{{ __('all.list') }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                            <select id="lang_id" name="lang_id" class="select2_lang form-control" tabindex="-1">
                                <option value="">{{ __('all.select_type') }}</option>
                                <option value="page">{{ __('all.page') }}</option>
                                <option value="section">{{ __('all.section') }}</option>
                            </select>
                        </div>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-info btn-sm btn-round add-lang"><i class="fa fa-plus"></i>
                                    {{ __('all.add_new') }}
                                </button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('all.title') }}</th>
                                <th>{{ __('all.type') }}</th>
                                <th>{{ __('all.slug') }}</th>
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
                <form id="mainForm" method="post" action="{{ route('page.save', app()->getLocale()) }}"
                      enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_page') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.type') }}</label>
                                    <select id="type" name="type" class=" form-control" tabindex="-1" required="required">
                                        <option value="">{{ __('all.select_type') }}</option>
                                        <option value="page">{{ __('all.page') }}</option>
                                        <option value="section">{{ __('all.section') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 sort_order">
                                    <label for="email">{{ __('all.sort_order') }}</label>
                                    <input type="number" id="order" class="form-control" name="order" required="required"/>
                                </div>

                                <div class="form-group col-md-6" style="margin-top: 20px">
                                    <div class="checkbox">
                                        <label>
                                            <input id="status" type="checkbox" name="status">
                                            <span>{{ __('all.status') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 seo_keyword">
                                    <label for="email">{{ __('all.seo_keyword') }}</label>
                                    <textarea id="seo_keyword" name="seo_keywords" class="resizable_textarea form-control"></textarea>
                                </div>
                                <div class="form-group col-md-12 seo_description">
                                    <label for="email">{{ __('all.seo_description') }}</label>
                                    <textarea id="seo_description" name="seo_description" class="resizable_textarea form-control"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{ __('all.description') }}</label>
                                    <textarea name="content" id="pageContents" class="resizable_textarea form-control" required="required"></textarea>
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
            CKEDITOR.replace('pageContents');
            var mainForm = null;
            var addEditModal = null;
            var saveBtn = null;
            var hidden_id = null;
            var hidden_lang_id = null;
            var title = null;
            var order = null;
            var childTable = null;
            var table = null;
            var lang_type = null;
            var type = null;
            var seo_keyword = null;
            var seo_description = null;
            var selectedRecordOfSubTable = null;
            var sTable = 'main';

            $(document).ready(function () {
                mainForm = $('#mainForm');
                addEditModal = $('#addEditModal');
                saveBtn = $('#saveBtn');
                hidden_id = $('#hidden_id');
                hidden_lang_id = $('#hidden_lang_id');
                title = $('#title');
                order = $('#order');
                lang_type = $('#lang_type');
                type = $('#type');
                seo_keyword = $('#seo_keyword');
                seo_description = $('#seo_description');
                $(".select2_lang").select2();

                table = $('#datatable-responsive').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": {
                        "url": "{{ route('pages.list', app()->getLocale()) }}",
                        "data": function (data) {
                            data.type_filter = $('#lang_id').val();
                            return data
                        },
                        "dataType": "json",
                        "type": "GET"
                    },
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'title', name: 'title', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="title" data-title="{{ __('all.enter_title') }}" data-type="text" data-pk="${row.page.id + '_' + row.language_id}">${data}</a>`
                            }
                        },
                        { data: 'page.type', name: 'page.type', orderable: false, searchable: false, className: "center-text",
                            render: function (d, t, r) {
                                return `<a href="#" class="changeType" data-name="type" data-value="${d}" data-type="select" data-pk="${r.page.id}" data-title="{{ __('all.select_type') }}"></a>`;
                            }
                        },
                        {data: 'page.slug', name: 'page.slug'},
                        { data: 'page.order', name: 'page.order', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-title="{{ __('all.sort_order') }}" data-name="order" data-type="text" data-pk="${row.page.id}">${data}</a>`
                            }
                        },
                        { data: 'page.status', name: 'page.status', orderable: false, searchable: false, className: "center-text",
                            render: function (d, t, r) {
                                return `<a href="#" class="changeStatus" data-name="status" data-value="${d}" data-type="select" data-pk="${r.page.id}" data-title="{{ __('all.select_status') }}"></a>`;
                            }
                        },
                        {data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text"}
                    ],
                    "drawCallback": function (setting) {
                        initializeEditable();
                        initializeTypeEditable();
                        initializeStatusEditable();
                    },
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    hidden_id.val('');
                    hidden_lang_id.val('');
                    CKEDITOR.instances.pageContents.setData('');
                    mainForm.trigger("reset");
                    addEditModal.modal('show');
                    sTable = 'main';
                    $('.sort_order').show();
                    $('.seo_keyword').show();
                    $('.seo_description').show();
                });

                /*---------------Load records by lang=========================================*/
                $(document).on('change', '#type', function () {
                    if ($(this).val() == 'section') {
                        $('.sort_order').hide();
                        $('.seo_keyword').hide();
                        $('.seo_description').hide();
                    } else {
                        $('.sort_order').show();
                        $('.seo_keyword').show();
                        $('.seo_description').show();
                    }

                });

                $(document).on('change', '#lang_id', function () {
                    table.ajax.reload();
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
                                sTable == 'sub' ? selectedRecordOfSubTable.ajax.reload(null, false) : table.ajax.reload(null, false);
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
                    hidden_lang_id.val(data.language_id);
                    hidden_id.val(data.page.id);
                    title.val(data.title);
                    seo_keyword.val(data.seo_keywords);
                    seo_description.val(data.seo_description);
                    order.val(data.page.order);
                    type.val(data.page.type);
                    $('#status').prop('checked', !!data.page.status);
                    CKEDITOR.instances.pageContents.setData(decodeHTMLEntities(data.content));
                    addEditModal.modal('show');
                    sTable = 'main';
                    $('.sort_order').show();
                });

                /*---------------edit sub records=========================================*/
                $(document).on('click', '.editSub', function () {
                    var id = $(this).data('id');
                    selectedRecordOfSubTable = $('#in' + id).DataTable();
                    var data = selectedRecordOfSubTable.row($(this).parents('tr')).data();
                    console.log(data);
                    hidden_lang_id.val(data.language_id);
                    hidden_id.val(data.id);
                    title.val(data.title);
                    order.val(data.order);
                    type.val(data.type);
                    seo_keyword.val(data.seo_keywords);
                    seo_description.val(data.seo_description);
                    $('#status').prop('checked', !!data.status);
                    CKEDITOR.instances.pageContents.setData(decodeHTMLEntities(data.content));
                    sTable = 'sub';
                    addEditModal.modal('show');
                });

                $('#datatable-responsive tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        if (table.row('.shown').length)
                            $('.details-control', table.row('.shown').node()).click();

                        row.child(formatTable(row.data())).show();
                        var bid = row.data().page.id;
                        childTable = $('#in' + bid).DataTable({
                            ajax: {
                                url: "{{ route('page.detail.grid', app()->getLocale()) }}?id=" + bid,
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
                var childTable = '<table id="in' + rowData.page.id + '" class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" width="100%">' +
                    '<thead><th>{{ __("all.title") }}</th><th>Language</th><th>{{ __("all.action") }}</th></thead> ' +
                    '</table>';
                return $(childTable).toArray();
            }

            function initializeEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.page.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//

            function initializeSubEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.page.field',app()->getLocale())}}",
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
                    url: '{{ route('update.page.field', app()->getLocale()) }}',
                    success: function (response, newValue) {
                        if (!response.status) return response.message;
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeStatusEditable() .....//

            function initializeTypeEditable() {
                $('.changeType').editable({
                    source: [
                        {value: 'page', text: '{{ __('all.page') }}'},
                        {value: 'section', text: '{{ __('all.section') }}'}
                    ],
                    url: '{{ route('update.page.field', app()->getLocale()) }}',
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
