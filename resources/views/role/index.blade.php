@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.manage_roles') }} <small>{{ __('all.list') }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <button class="btn btn-info btn-sm btn-round addNew"><i class="fa fa-plus"></i>{{ __('all.add_new') }}</button>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('all.title') }}</th>
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
                <form id="mainForm" method="post" action="{{ route('roles.save', app()->getLocale()) }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.add_edit_role') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">{{ __('all.title') }}</label>
                                    <input type="text" id="title" class="form-control" name="title" required="required"/>
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

        <div id="roleMenu" class="modal fade bs-example-modal-xl lang-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="menuForm" method="post" action="{{ route('role.menus.save', app()->getLocale()) }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('all.assign_menu_to_role') }}</h4>
                        </div>
                        <div class="modal-body ">
                            <div class="row" id="roleMenuContainer" style="padding: 20px 63px;">

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
            var mainForm = null;
            var addEditModal = null;
            var saveBtn = null;
            var hidden_id = null;
            var title = null;
            var table = null;

            $(document).ready(function () {
                mainForm = $('#mainForm');
                addEditModal = $('#addEditModal');
                saveBtn = $('#saveBtn');
                hidden_id = $('#hidden_id');
                title = $('#title');

                table = $('#datatable-responsive').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: "{{ route('roles.list', app()->getLocale()) }}",
                    columns: [
                        { data: 'title', name: 'title', render: function (data, t, row) {
                                return `<a href="#" class="editable__field" data-name="title" data-title="{{ __('all.enter_title') }}" data-type="text" data-pk="${row.id}">${data}</a>`
                            }
                        },
                        {data: 'action', name: 'action', orderable: false, searchable: false, className: "center-text"}
                    ],
                    "drawCallback": function (setting) {
                        initializeEditable();
                    },
                });

                /*---------------show Modal=========================================*/
                $('body').on('click', '.addNew', function () {
                    hidden_id.val('');
                    mainForm.trigger("reset");
                    addEditModal.modal('show');
                });

                /*---------------add and update records=========================================*/
                $('#mainForm').on('submit', function (e) {
                    e.preventDefault();
                    saveBtn.prop('disabled', true);
                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                mainForm.trigger("reset");
                                addEditModal.modal('hide');
                                table.ajax.reload(null, false);
                            } else showNotification(data.message, 'error', 'Error');

                            saveBtn.prop('disabled', false);
                        },
                        error: function (data) {
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                            saveBtn.prop('disabled', false);
                        }
                    });
                });

                $('body').on('submit', '#menuForm', function (e) {
                    e.preventDefault();

                    $(this).ajaxSubmit({
                        success: function (data) {
                            if (data.status) {
                                showNotification(data.message);
                                $('#roleMenu').modal('hide');
                            } else showNotification(data.message, 'error', 'Error');
                        },
                        error: function (data) {
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                            $('#roleMenu').modal('hide');
                        }
                    });
                });

                /*---------------edit records=========================================*/
                $(document).on('click', '.edit', function () {
                    var data = table.row($(this).parents('tr')).data();
                    hidden_id.val(data.id);
                    title.val(data.title);
                    addEditModal.modal('show');
                });

                $(document).on('click', '.assignMenus', function () {
                    var data = table.row($(this).parents('tr')).data();
                    $('#roleMenuContainer').html('');

                    $.ajax({
                        type: "get",
                        url: '{{ route('role.menu.view', app()->getLocale()) }}?role_id='+data.id,
                        success: function (response) {
                            $('#roleMenuContainer').html(response);
                            $('#roleMenu').modal('show');
                        }, error: function (data) {
                            showNotification("{{ __('all.internal_server_error') }}", 'error', 'Error');
                        }
                    });
                });

                /*---------------delete records=========================================*/
                $('body').on('click', '.delete', function () {
                    var data = table.row($(this).parents('tr')).data();
                    var url = "{{ route('role.destroy', [app()->getLocale(), '***']) }}";
                    url = url.replace('***', data.id);
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
            });

            function initializeEditable() {
                $('.editable__field').editable({
                    mode: 'inline',
                    url: "{{route('update.role.field',app()->getLocale())}}",
                    success: function (response, newvalue) {
                        showNotification(response.message, response.status ? 'success': 'error');
                        table.ajax.reload(null, false);
                    }
                });
            }//..... end of initializeEditable() ....//
        </script>
    </div>
@endsection
