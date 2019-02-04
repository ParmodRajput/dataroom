
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('/')}}">
          <img src="{{url('/')}}/dist/img/prodata_logo.png" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{url('/')}}">
          <img src="{{url('/')}}/dist/img/avatar5.png" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">

            <i class="fas fa-user"></i>
            <span class="profile-text">{{ Auth::user()->name }}</span>
            <i class="fa fa-caret-down down-arrow"  data-toggle="dropdown" aria-hidden="true"></i>
            <div class="dropdown-menu list-iteam">
              <ul>
                <li><a href="{{url('/')}}/account" >My Personal Info</a></li>
                <li><a href="{{url('/')}}/account/security" >My Security Setting</a></li>
                <li><a href="{{url('/')}}/projects" >All projects</a></li>
                <li><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                    {{ csrf_field() }}
                    <input type="submit" name="submit" value ="logout">
                </form>
              </li> 
               </ul>    

            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
	