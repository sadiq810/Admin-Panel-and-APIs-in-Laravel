@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('all.change_password') }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            @if($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if(session()->has('success'))
                                <div class="alert alert-success">{{ session()->get('success') }}</div>
                            @endif
                            <form action="{{ route('change.password', app()->getLocale()) }}" method="post">
                                @csrf
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('all.old_password') }}</label>
                                    <input type="password" name="old_password" class="form-control" required/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('all.new_password') }}</label>
                                    <input type="password" class="form-control" name="new_password" required="required"/>
                                </div>
                                <div class="form-group col-md-6 col-md-offset-6">
                                    <input type="submit" id="saveBtn" class="btn btn-primary" value="{{ __('all.save') }}" style="float: right; margin-right: 0;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
