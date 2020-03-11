
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"></p>
          <p class="app-sidebar__user-designation">Admin</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="javascipt:;"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item" href="{{route('Pages')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Pages</span></a></li>
        <li class="treeview" id='Users_overall'><a class="app-menu__item" href="javascipt:;" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('usersList') }}"><i class="icon fa fa-circle-o"></i>All Users</a></li>
            <li><a class="treeview-item" href="{{ route('usersEnable') }}"><i class="icon fa fa-circle-o"></i>Enabled Users</a></li>
            <li><a class="treeview-item" href="{{ route('usersDisable') }}"><i class="icon fa fa-circle-o"></i>Disabled Users</a></li>
          </ul>
        </li>
		<li class="treeview" id='Users_overall'><a class="app-menu__item" href="javascipt:;" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Projects</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{ route('allProjects') }}"><i class="icon fa fa-circle-o"></i>All Projects</a></li>
          </ul>
        </li>
       
      </ul>
    </aside>
    

   