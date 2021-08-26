@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.manage_blog') }} <small>{{ __('all.list') }}</small></h3>
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
                                    <th>{{ __('all.language') }}</th>
                                    <th>{{ __('all.status') }}</th>
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
                <form id="lang-form" method="post" action="{{ route('blog.store', app()->getLocale()) }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_blogs') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required" placeholder="{{ __('all.title') }}"/>
                                </div>
                                <div class="form-group col-md-6 category">
                                    <label for="fullname">{{ __('all.select_category') }}</label>
                                    <select id="category_id" name="category_id" class="select2_lang form-control" tabindex="-1">
                                        <option value="">{{__('all.select_category')}}</option>
                                        @foreach($categories as $id => $title)
                                            <option value="{{ $id }}">{{ $title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 image">
                                    <label for="email">{{ __('all.select_image') }}</label>
                                    <input type="file" id="image" class="form-control" name="image">
                                </div>
                                <div class="form-group col-md-6 status" style="margin-top: 20px">
                                    <div class="checkbox">
                                        <label>
                                            <input id="status" type="checkbox" name="status"> <span>{{ __('all.status') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{__('all.seo_keyword')}}</label>
                                    <textarea name="seo_keywords" id="seo_keywords" class="resizable_textarea form-control"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{__('all.seo_description')}}</label>
                                    <textarea name="seo_description" id="seo_description" class="resizable_textarea form-control"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{__('all.short_description')}}</label>
                                    <textarea name="summary" id="summary" class="resizable_textarea form-control"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">{{__('all.contents')}}</label>
                                    <textarea name="description" id="text" class="resizable_textarea form-control" placeholder="slider description"></textarea>
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
            var tags = null;
            var text = null;
            var langModal = null;
            var hidden_id = null;
            var hidden_lang_id = null;
            var langForm = null;
            var seo_description = null;
            var seo_keywords = null;
            var category_id = null;
            var summary = null;
            var table = null;
            var sTable = 'main';
            var selectedRecordOfSubTable = null;

            $(document).ready(function () {
                title = $("#title");
                tags = $("#tags_1");
                text = $("#text");
                hidden_id = $("#hidden_id");
                hidden_lang_id = $("#hidden_lang_id");
                langModal = $(".lang-modal");
                langForm = $("#lang-form");
                seo_description = $("#seo_description");
                seo_keywords = $("#seo_keywords");
                category_id = $("#category_id");
                summary = $("#summary");

                table = $('#languageDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('blogs.datatables.list', app()->getLocale()) }}",
                    columns: [
                        { "className": 'details-control', "orderable": false, "data": null, "defaultContent": '', searchable: false },
                        { data: 'title', name: 'title', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="title" data-title="{{ __('all.title') }}e" data-type="text" data-pk="${row.blog.id}">${data}</a>`
                            }
                        },
                        { data: 'language.local_name', name: 'language.local_name' },
                        { data: 'blog.status', name: 'blog.status', render: function(d) { return d == 1 ? 'Active': 'DeActive';} },
                        { data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text" },
                    ],
                    "drawCallback": function (setting) {
                        initializeEditable();
                    },
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    $('#savelang').val('Save');
                    CKEDITOR.instances.text.setData('');
                    $('#lang-form').trigger("reset");
                    hidden_id.val('');
                    hidden_lang_id.val('');
                    sTable = 'main';
                    $('.category').show();
                    $('.image').show();
                    $('.status').show();
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

                            $('#savelang').html('Save');
                        },
                        error: function (data) {
                            $('#savelang').html('Save');
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                        }
                    });
                });

                /*---------------edit records=========================================*/
                $(document).on('click', '.edit', function (e) {
                    e.preventDefault();
                    var data = table.row($(this).parents('tr')).data();
                    hidden_id.val(data.article_id);
                    hidden_lang_id.val('');
                    title.val(data.title);
                    seo_keywords.val(data.seo_keywords);
                    seo_description.val(data.seo_description);
                    category_id.val(data.blog.category_id);
                    summary.val(data.summary);
                    $('#status').prop('checked', !!data.blog.status);
                    CKEDITOR.instances.text.setData(decodeHTMLEntities(data.description));
                    sTable = 'main';
                    $('.category').show();
                    $('.image').show();
                    $('.status').show();
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
                    seo_keywords.val(data.seo_keywords);
                    seo_description.val(data.seo_description);
                    category_id.val('');
                    summary.val(data.summary);
                    CKEDITOR.instances.text.setData(decodeHTMLEntities(data.description));
                    sTable = 'sub';
                    $('.category').hide();
                    $('.image').hide();
                    $('.status').hide();
                    langModal.modal('show');
                });

                /*---------------delete records=========================================*/
                $('body').on('click', '.delete', function () {
                    var data = table.row($(this).parents('tr')).data();
                    var url = "{{ route('blog.destroy', [app()->getLocale(), '***']) }}";
                    url = url.replace('***', data.blog.id);
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
                        var article_id = row.data().article_id;
                        childTable = $('#in' +bid).DataTable({
                            ajax: {
                                url: "{{ route('blog.detail.grid', app()->getLocale()) }}?id=" + bid,
                                "type": "GET"
                            },
                            columns: [
                                { data: 'title', name: 'title', render: function (data, t, row) {
                                        return `<a href="#" class="editable__field" data-title="{{ __('all.enter_title') }}" data-name="title" data-type="text" data-pk="${article_id + '_' + row.language_id}">${data}</a>`;
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
                    url: "{{route('update.blog.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        childTable.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//

            function initializeEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.blog.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//
        </script>
    </div>
@endsection
