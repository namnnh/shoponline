<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-avatar">
                <div class="dropdown">
                    <div>
                        <img alt="image" class="img-circle avatar" width="100" src="{{ Auth::user()->present()->avatar }}">
                    </div>
                    <div class="name"><strong>{{ Auth::user()->present()->nameOrEmail }}</strong></div>
                </div>
            </li>
            <li class="{{ Request::is('/') ? 'active open' : ''  }}">
                <a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active' : ''  }}">
                    <i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')
                </a>
            </li>
            <li class="{{ Request::is('user*') ? 'active open' : ''  }}">
                <a href="{{route('user.list')}}" class="{{ Request::is('user*') ? 'active' : ''  }}">
                    <i class="fa fa-users fa-fw"></i> @lang('app.users')
                </a>
            </li>

            <li class="{{ Request::is('activity*') ? 'active open' : ''  }}">
                <a href="#" class="{{ Request::is('activity*') ? 'active' : ''  }}">
                    <i class="fa fa-list-alt fa-fw"></i> @lang('app.activity_log')
                </a>
            </li>

            <li class="{{ Request::is('role*') || Request::is('permission*') ? 'active open' : ''  }}">
                <a href="#">
                    <i class="fa fa-user fa-fw"></i>
                    @lang('app.roles_and_permissions')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#" class="{{ Request::is('role*') ? 'active' : ''  }}">
                                @lang('app.roles')
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ Request::is('permission*') ? 'active' : ''  }}">@lang('app.permissions')</a>
                        </li>
                </ul>
            </li>

            <li class="{{ Request::is('settings*') ? 'active open' : ''  }}">
                <a href="#">
                    <i class="fa fa-gear fa-fw"></i> @lang('app.settings')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#"
                               class="{{ Request::is('settings') ? 'active' : ''  }}">
                                @lang('app.general')
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ Request::is('settings/auth*') ? 'active' : ''  }}">
                                @lang('app.auth_and_registration')
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="{{ Request::is('settings/notifications*') ? 'active' : ''  }}">
                                @lang('app.notifications')
                            </a>
                        </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>