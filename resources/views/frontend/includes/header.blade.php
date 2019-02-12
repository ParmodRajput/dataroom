
<div class="top_bar">
<div class="container">
<span class="top_right">

<ul class="navbar-nav navbar-nav-right header-menu">
   @if (Auth::check())
				
				<li class="nav-item dropdown d-none d-xl-inline-block">

				<div class="dropdown">
					  <button class="btn btn-frontend dropdown-toggle" type="button" data-toggle="dropdown">{{ Auth::user()->name }}
  <span class="caret"></span></button>
					  <ul class="dropdown-menu frontend_dropdown">
					    <li><a href="{{url('/')}}/projects" class="btn-projects" >All projects</a></li>
							<li><form id="logout-form" action="{{ route('logout') }}" method="POST" >
								{{ csrf_field() }}
								<input type="submit" name="submit" class="btn-logout"value ="logout">
							</form>
						</li> 
					  </ul>
                </div>
               
			</li>

			@else
			<li><a href="<?php echo url('/');?>/login">LOGIN</a></li>
			<li><a href="<?php echo url('/');?>/pricing">SIGNUP</a></li>
			@endif
</ul>
</span>
</div>
</div>
<div class="container">
<div class="logo"><a href="#"><img src="{{ asset('images/frontend/logo.png')}}" alt="logo" border="0" /></a></div>
<div class="nav">
                                                           
	<ul>
		<li><a href="{{url('platform')}}">Platform </a></li>
		<li><a href="{{url('solutions')}}">Solutions</a></li>
		<li><a href="{{url('support')}}">Support </a></li>
		<li><a href="{{url('clients')}}">Clients </a></li>
		<li><a href="{{url('pricing')}}">Pricing </a></li>
		<li><a href="{{url('contact')}}">Contact Us </a></li>

		</ul>

	</div>
</div>
