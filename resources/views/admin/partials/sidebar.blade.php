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
            <li class="{{ Request::is('admin') ? 'active open' : ''  }}">
                <a href="{{ route('dashboard') }}" class="{{ Request::is('/') ? 'active' : ''  }}">
                    <i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')
                </a>
            </li>
            @permission(['users.manage','roles.manage', 'permissions.manage'])
            <li class="{{ Request::is('admin/role*') || Request::is('admin/permission*') || Request::is('admin/user*') ? 'active' : ''  }}">
                <a href="#">
                    <i class="fa fa-users fa-fw"></i>
                    @lang('app.user_manager')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li class="{{ Request::is('admin/user*') ? 'active open' : ''  }}">
                            <a href="{{route('admin.user.list')}}" class="{{ Request::is('user*') ? 'active' : ''  }}">
                                <i class="fa fa-user fa-fw"></i> @lang('app.users')
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/role*') ? 'active open' : ''  }}">
                            <a href="{{route('admin.role.index')}}" class="{{ Request::is('role*') ? 'active' : ''  }}">
                                 <i class="fa fa-user-md fa-fw"></i> @lang('app.roles')
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/permission*') ? 'active open' : ''  }}">
                            <a href="{{route('admin.permission.index')}}"
                               class="{{ Request::is('permission*') ? 'active' : ''  }}">
                               <i class="fa fa-user-secret fa-fw"></i> @lang('app.permissions')</a>
                        </li>
                </ul>
            <li>
            @endpermission

            @permission('users.activity')
            <li class="{{ Request::is('admin/activity*') ? 'active open' : ''  }}">
                <a href="{{route('admin.activity.index')}}" class="{{ Request::is('activity*') ? 'active' : ''  }}">
                    <i class="fa fa-list-alt fa-fw"></i> @lang('app.activity_log')
                </a>
            </li>
            @endpermission

            <li class="{{ Request::is('admin/category*')|| Request::is('admin/option*') ? 'active' : ''  }}">
                <a href="#">
                    <i class="fa fa-tags fa-fw"></i> @lang('app.catalog_manager')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li class="{{ Request::is('admin/category*') ? 'active open' : ''  }}">
                            <a href="{{route('admin.category')}}" class="{{ Request::is('category*') ? 'active' : ''  }}">
                                <i class="fa fa-picture-o fa-fw"></i> @lang('app.category')
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/option*') ? 'active open' : ''  }}">
                            <a href="{{route('admin.option')}}" class="{{ Request::is('option*') ? 'active' : ''  }}">
                                <i class="fa fa-picture-o fa-fw"></i> @lang('app.option')
                            </a>
                        </li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/media*') ? 'active open' : ''  }}">
                <a href="{{route('admin.media.index')}}" class="{{ Request::is('media*') ? 'active' : ''  }}">
                    <i class="fa fa-picture-o fa-fw"></i> @lang('app.media')
                </a>
            </li>
            
            @permission(['settings.general', 'settings.auth', 'settings.notifications'])
            <li class="{{ Request::is('admin/settings*') ? 'active' : ''  }}">
                <a href="#">
                    <i class="fa fa-gear fa-fw"></i> @lang('app.settings')
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                        <li class="{{ Request::is('admin/settings') ? 'active open' : ''  }}">
                            <a href="{{route('admin.settings.general')}}"
                               class="{{ Request::is('settings') ? 'active' : ''  }}">
                                @lang('app.general')
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/settings/auth') ? 'active open' : ''  }}">
                            <a href="{{route('admin.settings.auth')}}"
                               class="{{ Request::is('settings/auth*') ? 'active' : ''  }}">
                                @lang('app.auth_and_registration')
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/settings/notifications') ? 'active open' : ''  }}">
                            <a href="{{route('admin.settings.notifications')}}"
                               class="{{ Request::is('settings/notifications*') ? 'active' : ''  }}">
                                @lang('app.notifications')
                            </a>
                        </li>
                </ul>
            </li>
            @endpermission
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>