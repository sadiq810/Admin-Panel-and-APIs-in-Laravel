@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('all.manage_options') }}: <small>{{ $feature->title }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-info btn-sm btn-round add-lang"><i class="fa fa-plus"></i> {{ __('all.add_new') }}</button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="languageDatatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('all.title') }}</th>
                                <th>{{ __('all.type') }}</th>
                                <th style="text-align: center;">{{ __('all.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-lg lang-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="lang-form" method="post" action="{{ route('option.save', [app()->getLocale(), $feature->feature_id]) }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_option') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required" placeholder="{{ __('all.title') }}"/>
                                </div>
                                <div class="form-group col-md-6 type">
                                    <label for="type">{{ __('all.select_type') }}</label>
                                    <select id="type" name="type" class="select2_lang form-control" tabindex="-1" required="required">
                                        <option value="">{{__('all.select_type')}}</option>
                                        @foreach($types as $key => $title)
                                            <option value="{{ $key }}">{{ $title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 image" style="display: none;">
                                    <label for="image">{{ __('all.select_icon') }}</label>
                                    <input type="file" id="image" class="form-control" name="icon">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="email">{{ __('all.description') }}</label>
                                    <textarea name="description" id="text" class="resizable_textarea form-control" placeholder="{{ __('all.description') }}"></textarea>
                                </div>
                            </div>
                            <input type="hidden" id="hidden_id" name="id" />
                            <input type="hidden" id="hidden_lang_id" name="language_id" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('all.close') }}</button>
                            <input type="submit" id="savelang" class="btn btn-primary" value="{{ __('all.save') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            CKEDITOR.replace( 'text');
            var title = null;
            var text = null;
            var langModal = null;
            var hidden_id = null;
            var hidden_lang_id = null;
            var langForm = null;
            var type = null;
            var table = null;
            var sTable = 'main';
            var selectedRecordOfSubTable = null;

            $(document).ready(function () {
                title = $("#title");
                text = $("#text");
                hidden_id = $("#hidden_id");
                hidden_lang_id = $("#hidden_lang_id");
                langModal = $(".lang-modal");
                langForm = $("#lang-form");
                title = $("#title");
                type = $("#type");


                table = $('#languageDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('options.datatables.list', app()->getLocale()) }}",
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'title', name: 'translations.title', render: function (data, t, row) {
                                return row.type == 'icon' ? row.title : (row.translations[0].title ?? '')
                            }
                        },
                        { data: 'type', name: 'type'},
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text" },
                    ]
                });

                $('body').on('change', '#type', function() {
                   if ($(this).val() == 'icon')
                       $(".image").show();
                   else $('.image').hide();
                });
                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    CKEDITOR.instances.text.setData('');
                    $('#lang-form').trigger("reset");
                    hidden_id.val('');
                    hidden_lang_id.val('');
                    $('.type').show();
                    sTable = 'main';
                    langModal.modal('show');
                });

                /*---------------add and update records=========================================*/
                $('#lang-form').on('submit', function (e) {
                    CKEDITOR.instances.text.updateElement();
                    e.preventDefault();
                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                langForm.trigger("reset");
                                langModal.modal('hide');
                                sTable == 'main' ? table.ajax.reload(null, false) : selectedRecordOfSubTable.ajax.reload(null, false);
                            } else showNotification(data.message, 'error', 'Error');
                        },
                        error: function (data) {
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                        }
                    });
                });

                /*---------------edit records=========================================*/
                $(document).on('click', '.edit', function (e) {
                    e.preventDefault();
                    var data = table.row($(this).parents('tr')).data();
                    let translation = data.translations[0] ?? {};

                    hidden_id.val(data.id);
                    hidden_lang_id.val('');
                    title.val(data.type == 'icon' ? data.title: translation.title);
                    $('.type').show();
                    type.val(data.type);

                    if (data.type == 'icon')
                        $('.image').show();
                    else $('.image').hide();

                    CKEDITOR.instances.text.setData(decodeHTMLEntities(data.type == 'icon' ? data.description : translation.description));
                    sTable = 'main';
                    langModal.modal('show');
                });

                /*---------------edit sub records=========================================*/
                $(document).on('click', '.editSub', function () {
                    var id = $(this).data('id');
                    selectedRecordOfSubTable = $('#in'+id).DataTable();
                    var data = selectedRecordOfSubTable.row($(this).parents('tr')).data();
                    hidden_lang_id.val(data.language_id);
                    hidden_id.val(data.id);
                    title.val(data.title);
                    type.val('list_item');
                    $('.type').hide();
                    CKEDITOR.instances.text.setData(decodeHTMLEntities(data.description));
                    sTable = 'sub';
                    langModal.modal('show');
                });

                /*---------------delete records=========================================*/
                $('body').on('click', '.delete', function () {
                    var data = table.row($(this).parents('tr')).data();
                    var url = "{{ route('option.destroy', [app()->getLocale(), '***']) }}";
                    url = url.replace('***', data.id);
                    if (confirm("{{ __('all.confirm_deletion') }}"))
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

                $('#languageDatatable tbody').on('click', 'td.details-control', function () {
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
                                url: "{{ route('options.detail.grid', app()->getLocale()) }}?id=" + bid,
                                "type": "GET"
                            },
                            columns: [
                                { data: 'title', name: 'title', render: function (data, t, row) {
                                        return `<a href="#" class="editable__field" data-title="{{ __('all.enter_title') }}" data-name="title" data-type="text" data-pk="${bid + '_' + row.language_id}">${data}</a>`;
                                    }
                                },
                                { data: 'local_name', name: 'local_name' },
                                { data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text" }
                            ],
                            "order": [[ 1, "desc" ]],
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
            });//..... end of ready() .....//

            function formatTable(rowData) {
                var childTable = '<table id="in' + rowData.id + '" class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" width="100%">' +
                    '<thead><th>{{ __("all.title") }}</th><th>Language</th><th>{{ __("all.action") }}</th></thead> ' +
                    '</table>';
                return $(childTable).toArray();
            }

            function initializeSubEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.option.field', app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        childTable.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//
        </script>
    </div>
@endsection
