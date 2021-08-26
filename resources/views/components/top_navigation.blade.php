<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('images/img.jpg')}}" alt="">{{ ucfirst(auth()->user()->name) }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="{{route('change.password', app()->getLocale())}}">
                                <i class="fa fa-key pull-right"></i> {{ __('all.change_password') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('logout', app()->getLocale())}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out pull-right"></i> {{ __('auth.logout') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="glyphicon glyphicon-globe"></i>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        @inject('langController', "App\Http\Controllers\LanguageController")

                        @foreach($langController->getActiveLanguages()->whereIn('code', ['en', 'ar']) as $lang)
                            @if(app()->getLocale() == $lang->code)
                                <li class="active"><a href="javascript:;">{{ $lang->local_name }}</a></li>
                            @else
                                <li>
                                    <a href="{{ route('change.lang', [app()->getLocale(), $lang->code]) }}" class="hreflang">
                                        {{ $lang->local_name }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>
</div>
