@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('all.languages') }} <small>{{ __('all.list') }}</small></h3>
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
                                <th>{{ __('all.short_name') }}</th>
                                <th>{{ __('all.local_name') }}</th>
                                <th>{{ __('all.latin_name') }}</th>
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
                <form id="lang-form" method="post" action="{{ route('language.store', app()->getLocale()) }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_language') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">{{ __('all.short_name') }}</label>
                                    <input type="text" id="short" class="form-control" name="code" required="required"/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.local_name') }}</label>
                                    <input type="text" id="local" class="form-control" name="local_name" required="required"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.latin_name') }}</label>
                                    <input type="text" id="latin" class="form-control" name="latin_name" required="required"/>
                                </div>
                               {{-- <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.order') }}</label>
                                    <input type="number" id="order" class="form-control" name="order" required="required"/>
                                </div>--}}
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.direction') }}</label>
                                    <select id="direction" name="direction" class="form-control" required="required">
                                        <option value="ltr">LTR</option>
                                        <option value="rtl">RTL</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="checkbox" style="margin-top: 30px !important;">
                                        <label>
                                            <input id="status" type="checkbox" name="status">
                                            <span>{{ __('all.status') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="hidden_id" name="id">
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
            var short = null;
            var local = null;
            var latin = null;
            var order = null;
            var direction = null;
            var langModal = null;
            var hidden_id = null;
            var langForm = null;
            var table = null;

            $(document).ready(function () {
                short = $("#short");
                local = $("#local");
                latin = $("#latin");
                order = $("#order");
                direction = $("#direction");
                hidden_id = $("#hidden_id");
                langModal = $(".lang-modal");
                langForm = $("#lang-form");

                table = $('#languageDatatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('languages.datatables.list', app()->getLocale()) }}",
                    columns: [
                        {
                            data: 'code', name: 'code', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="code" data-title="{{ __('all.short_name') }}e" data-type="text" data-pk="${row.id}">${data}</a>`
                            }
                        },
                        {
                            data: 'local_name', name: 'local_name', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="local_name" data-title="{{ __('all.local_name') }}" data-type="text" data-pk="${row.id}">${data}</a>`
                            }

                        },
                        {
                            data: 'latin_name', name: 'latin_name', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="latin_name" data-title="{{ __('all.latin_name') }}" data-type="text" data-pk="${row.id}">${data}</a>`
                            }
                        },
                        {
                            data: 'status', name: 'status', orderable: false, searchable: false, className: "center-text",
                            render: function (d, t, r) {
                                return `<a href="#" class="changeStatus" data-name="status" data-value="${d}" data-type="select" data-pk="${r.id}" data-title="{{ __('all.select_status') }}"></a>`;
                            }
                        },

                        {data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text"},
                    ],
                    "drawCallback": function (setting) {
                        initializeEditable();
                        initializeStatusEditable();
                    },
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.add-lang', function () {
                    $('#savelang').val('Save');
                    $('#lang-form').trigger("reset");
                    hidden_id.val('');
                    langModal.modal('show');
                });

                /*---------------add and update records=========================================*/
                $('#lang-form').on('submit', function (e) {
                    e.preventDefault();
                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                langForm.trigger("reset");
                                langModal.modal('hide');
                                table.ajax.reload(null, false);
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

                    hidden_id.val(data.id);
                    short.val(data.code);
                    local.val(data.local_name);
                    latin.val(data.latin_name);
                    direction.val(data.direction);
                    $("#status").prop('checked', !!data.status);
                    langModal.modal('show');
                });

                /*---------------delete records=========================================*/
                $('body').on('click', '.delete', function () {
                    var data = table.row($(this).parents('tr')).data();
                    var url = "{{ route('language.destroy', [app()->getLocale(), '***']) }}";
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
            });//..... end of ready() .....//

            function initializeEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('add.update.lang',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message);
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//

            function initializeStatusEditable() {
                $('.changeStatus').editable({
                    source: [
                        {value: 0, text: 'DeActive'},
                        {value: 1, text: 'Active'}
                    ],
                    url: '{{ route('add.update.lang', app()->getLocale()) }}',
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
