@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.categories') }} <small>{{ __('all.list') }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-info btn-sm btn-round add-lang"><i class="fa fa-plus"></i>
                                {{ __('all.add_new') }}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                            <select id="lang_id" name="lang_id" class="select2_lang form-control" tabindex="-1">
                                <option value="">{{__('all.languages')}}</option>
                                @foreach($languages as $lang)
                                    <option value="{{$lang->id}}">{{$lang->local_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('all.title') }}</th>
                                <th>{{ __('all.sort_order') }}</th>
                                <th>{{ __('all.type') }}</th>
                                <th width="100">{{ __('all.status') }}</th>
                                <th style="text-align: center;" width="100">{{ __('all.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="addEditModal" class="modal fade bs-example-modal-lg lang-modal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="mainForm" method="post" action="{{ route('category.save', app()->getLocale()) }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_category') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.sort_order') }}</label>
                                    <input type="number" id="sort" class="form-control" name="order" required="required"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <select id="type" name="type" class="form-control" tabindex="-1">
                                        <option value="">{{__('all.type')}}</option>
                                        <option value="service">Service</option>
                                        <option value="article">Article</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input id="status" type="checkbox" name="status">
                                            <span>{{ __('all.status') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{ __('all.description') }}</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                                <input type="hidden" id="hidden_id" name="id"/>
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
            CKEDITOR.replace( 'description');
            var mainForm = null;
            var formTrans = null;
            var addEditModal = null;
            var saveBtn = null;
            var hidden_id = null;
            var title = null;
            var sort = null;
            var level = null;
            var cid = null;
            var childTable = null;
            var table = null;
            var type = null;
            var description = null;

            $(document).ready(function () {
                mainForm = $('#mainForm');
                formTrans = $('#formTrans');
                addEditModal = $('#addEditModal');
                saveBtn = $('#saveBtn');
                hidden_id = $('#hidden_id');
                title = $('#title');
                sort = $('#sort');
                type = $('#type');
                description = $('#description');
                $(".select2_lang").select2();

                /*---------------load datatables=========================================*/
                table = $('#datatable-responsive').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    "ajax": {
                        "url": "{{ route('categories.list', app()->getLocale()) }}",
                        "data": function (data) {
                            data.lang_id = $('#lang_id').val();
                            return data
                        }
                    },
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'title', name: 'title', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="title" data-type="text" data-pk="${row.category_id + '_' + row.language_id}" data-title="{{ __('all.enter_category_title') }}">${data}</a>`;
                            }
                        },
                        { data: 'category.order', name: 'category.order', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="order" data-type="number" data-pk="${row.category_id}" data-title="{{ __('all.enter_sort_order') }}">${data}</a>`;
                            }
                        },
                        { data: 'category.type', name: 'category.type', orderable: false, searchable: false},
                        { data: 'category.status', name: 'category.status', orderable: false, searchable: false, className: "center-text",
                            render: function (d, t, r) {
                                return `<a href="#" class="changeStatus" data-name="status" data-value="${d}" data-type="select" data-pk="${r.category_id}" data-title="{{ __('all.select_status') }}"></a>`;
                            }
                        },
                        {data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text"},
                    ],
                    "drawCallback": function (settings) {
                        $('.editable__field').editable({
                            mode: 'inline',
                            url: '{{ route('update.category.field', app()->getLocale()) }}',
                            success: function (response, newValue) {
                                if (!response.status) return response.message;
                                showNotification(response.message);
                                table.ajax.reload(null, false);
                            }
                        });

                        $('.changeStatus').editable({
                            source: [
                                {value: 0, text: 'DeActive'},
                                {value: 1, text: 'Active'}
                            ],
                            url: '{{ route('update.category.field', app()->getLocale()) }}',
                            success: function (response, newValue) {
                                if (!response.status) return response.message;
                                showNotification(response.message);
                                table.ajax.reload(null, false);
                            }
                        });
                    }
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    saveBtn.val('Save');
                    hidden_id.val('');
                    CKEDITOR.instances.description.setData('');
                    mainForm.trigger("reset");
                    addEditModal.modal('show');
                });

                /*---------------add and update records=========================================*/
                $('#mainForm').on('submit', function (e) {
                    e.preventDefault();
                    CKEDITOR.instances.description.updateElement();
                    saveBtn.html('Saving...');
                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                mainForm.trigger("reset");
                                addEditModal.modal('hide');
                                table.ajax.reload(null, false);
                            } else showNotification(data.message, 'error', 'Error');

                            saveBtn.html('Save');
                        },
                        error: function (data) {
                            saveBtn.html('Save');
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                        }
                    });
                });

                /*---------------edit records=========================================*/
                $(document).on('click', '.edit', function () {
                    var data = table.row($(this).parents('tr')).data();
                    console.log(data, data.category.type)
                    title.val(data.title);
                    sort.val(data.category.order);
                    CKEDITOR.instances.description.setData(decodeHTMLEntities(data.description));
                    hidden_id.val(data.category_id);
                    type.val(data.category.type);
                    $('#status').prop('checked', !!data.category.status);
                    addEditModal.modal('show');
                });
                /*---------------delete records=========================================*/

                /*---------------Load records by lang=========================================*/
                $(document).on('change', '#lang_id', function () {
                    table.ajax.reload();
                });
                /*---------------end of lang=========================================*/

                $('body').on('click', '.delete', function () {
                    var data = table.row($(this).parents('tr')).data();
                    var url = "{{ route('category.destroy', [app()->getLocale(), '***', 'lll']) }}";
                    url = url.replace('***', data.category ? data.category.id : data.id);
                    url = url.replace('lll', data.language_id);
                    if (confirm("Are You sure want to delete !"))
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function (data) {
                                showNotification(data.message);
                                table.ajax.reload(null, false);
                            }, error: function (data) {
                                showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                            }
                        });
                });

                $('#datatable-responsive tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        if (table.row('.shown').length)
                            $('.details-control', table.row('.shown').node()).click();

                        // Open this row
                        row.child(formatTable(row.data())).show();
                        var cid = row.data().category.id;
                        childTable = $('#in' + row.data().id).DataTable({
                            ajax: {
                                url: "{{ route('category.details', app()->getLocale()) }}?id=" + cid,
                                "type": "GET"
                            },
                            columns: [
                                {
                                    data: 'title', name: 'title', render: function (data, t, row) {
                                        return `<a href="#" class="sub__editable__field" data-name="title" data-type="text" data-pk="${row.id + '_' + row.language_id}" data-title="{{ __('all.enter_category_title') }}">${data}</a>`;
                                    }
                                },
                                {data: 'local_name', name: 'local_name'}
                            ],
                            "destroy": true,
                            "info": false,
                            select: false,
                            "bProcessing": true,
                            "filter": false,
                            "paging": false,
                            stateSave: true,
                            "drawCallback": function (settings) {
                                $('.sub__editable__field').editable({
                                    mode: 'inline',
                                    url: '{{ route('update.category.field', app()->getLocale()) }}',
                                    success: function (response, newValue) {
                                        if (!response.status) return response.message;
                                        showNotification(response.message);
                                        childTable.ajax.reload(null, false);
                                    }
                                });
                            }
                        });
                        tr.addClass('shown');
                    }
                });
            });

            function formatTable(rowData) {
                var childTable = '<table id="in' + rowData.id + '" class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" width="100%">' +
                    `<thead><th>{{ __('all.title') }}</th><th>{{ __('all.language') }}</th></thead> ` +
                    '</table>';
                return $(childTable).toArray();
            }
        </script>
    </div>
@endsection
