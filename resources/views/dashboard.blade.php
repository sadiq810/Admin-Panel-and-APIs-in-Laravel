@extends('layout.main')
@section('content')
    <div class="row tile_count">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-book"></i>
                </div>
                <div class="count">{{ $orders }}</div>

                <h3>{{__('all.order')}}</h3>
               {{-- <p>Lorem ipsum psdea itgum rixt.</p>--}}
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-pagelines"></i>
                </div>
                <div class="count">{{$categories}}</div>

                <h3>{{__('all.total_categories')}}</h3>
               {{-- <p>Lorem ipsum psdea itgum rixt.</p>--}}
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-globe"></i>
                </div>
                <div class="count">{{$languages}}</div>

                <h3>{{__('all.total_active_languages')}}</h3>
               {{-- <p>Lorem ipsum psdea itgum rixt.</p>--}}
            </div>
        </div>
    </div>
@endsection
