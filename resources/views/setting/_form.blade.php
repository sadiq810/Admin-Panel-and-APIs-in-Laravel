@extends('layout.main')
@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('menu.manage_setting') }} <small>{{ __('all.list') }}</small></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form action="{{route('setting.update',app()->getLocale())}}" method="post"
                              enctype="multipart/form-data">
                            <div class="panel panel-primary">
                                @csrf
                                <div class="panel-body">
                                    @foreach($data as $key => $val)

                                        @if($val->key == 'header_logo' || $val->key == 'footer_logo')
                                            <div class="row">
                                                <div class="form-group  col-lg-6" style="margin-bottom: 2px;">

                                                    <label class="control-label">{{trans('all.' . $val->key)}}
                                                        :</label>
                                                    <input type="file" class="form-control" value="{{$val->value}}"
                                                           name="{{$val->key}}">

                                                </div>
                                                @if(isset($val->value))
                                                    <div class="form-group col-lg-6" style="margin-top: 12px; !important;">

                                                        <img class="img img-thumbnail" style="width: 50px; height: 50px"
                                                             src="{{asset('uploads/'.$val->value)}}">
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="form-group " style="margin-bottom: 2px;">
                                                <label class="control-label">{{trans('all.' . $val->key)}}:</label>
                                                <div class="input-group col-lg-12">

                                                    <input type="text" class="form-control" value="{{$val->value}}"
                                                           name="{{$val->key}}">

                                                </div>
                                            </div>
                                        @endif


                                    @endforeach

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{trans('all.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>


            $(document).ready(function () {

                @if(session()->has('success'))

                showNotification('{{session()->get('success')}}')

                @endif

                @if($errors->any())

                showNotification('{{ implode(' ', $errors->all()) }}')

                @endif
            });//..... end of ready() .....//

        </script>
    </div>
@endsection
