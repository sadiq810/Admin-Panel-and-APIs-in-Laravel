<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li style="border-bottom: 0.1em solid #666666">
                <a href="{{ route('dashboard', app()->getLocale()) }}">
                    <i class="fa fa-dashboard"></i>{{ __('menu.dashboard') }}
                </a>
            </li>
            @canany(['languages', 'roles', 'users'])
                <li style="border-bottom: 0.1em solid #666666">
                    <a>
                        <i class="fa fa-cogs"></i>{{ __('menu.configuration') }}<span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        @can('languages')
                            <li><a href="{{ route('language.index', app()->getLocale()) }}">{{ __('menu.language') }}</a></li>
                        @endcan
                        @can('roles')
                                <li><a href="{{ route('roles.index', app()->getLocale()) }}">{{ __('menu.manage_roles') }}</a></li>
                        @endcan
                        @can('users')
                                <li><a href="{{ route('users.index', app()->getLocale()) }}">{{ __('menu.users') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @can('categories')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('category.index', app()->getLocale()) }}">
                        <i class="fa fa-list"></i>{{ __('menu.categories') }}
                    </a>
                </li>
            @endcan

            @can('pages')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('pages.index', app()->getLocale()) }}">
                        <i class="fa fa-pagelines"></i>{{ __('menu.pages') }}
                    </a>
                </li>
            @endcan

            @can('faqs')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('faqs.index', app()->getLocale()) }}">
                        <i class="fa fa-question"></i>{{ __('menu.faqs') }}
                    </a>
                </li>
            @endcan

            @can('blogs')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('blog.index', app()->getLocale()) }}">
                        <i class="fa fa-list-alt"></i>{{__('menu.manage_blog')}}
                    </a>
                </li>
            @endcan

            @can('features')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('features.index', app()->getLocale()) }}">
                        <i class="fa fa-fire-extinguisher"></i>{{ __('menu.manage_features') }}
                    </a>
                </li>
            @endcan

            @can('orders')
                <li style="border-bottom: 0.1em solid #666666">
                    <a href="{{ route('orders.index', app()->getLocale()) }}">
                        <i class="fa fa-shopping-cart"></i>{{ __('menu.manage_orders') }}
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
