<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a class="simple-text logo-normal">
      {{ __('Appointments') }}
    </a>
  </div>
  @if(Auth::user()->org_id!=0)

  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">date_range</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
     
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
      @canany(['owner', 'admin']) 
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
        <i class="material-icons">menu</i>
          <p>{{ __('Users') }}
            <b class="caret"></b>
          </p>
        </a>
       
        <div class="collapse hide" id="laravelExample">
        @endcan
        @canany(['invitor', 'participator']) 
        <div class="collapse show" id="laravelExample">
        @endcan
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
              <i class="material-icons">edit</i>
              @canany(['owner', 'admin']) 
                <span class="sidebar-normal">{{ __('Edit Profile') }} </span>
                @endcan
            
                @canany(['invitor', 'participator']) 
                <p>{{ __('Edit Profile') }}</p>
                @endcan
              </a>
            </li>
            
            @canany(['owner', 'admin']) 
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
              <i class="material-icons">person</i>
                <span class="sidebar-normal"> {{ __('Management') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'tasks' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('tasks.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Tasks') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'meetings' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('meetings.index') }}">
          <i class="material-icons">people</i>
            <p>{{ __('Meetings') }}</p>
        </a>
      </li>
      <!--li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li-->
      @can('owner')
      <li class="nav-item{{ $activePage == 'requests' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('requests.index') }}">
          <i class="material-icons">mail_outline</i>
          <p>{{ __('Requests') }}</p>
        </a>
      </li>
@endcan
    </ul>
  </div>
  @else
  <ul class="nav">
  <div class="sidebar-wrapper">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
              <i class="material-icons">edit</i>
              @canany(['owner', 'admin']) 
                <span class="sidebar-normal">{{ __('Edit Profile') }} </span>
                @endcan
            
                @canany(['invitor', 'participator']) 
                <p>{{ __('Edit Profile') }}</p>
                @endcan
              </a>
        </li>
        <li class="nav-item{{ $activePage == 'home' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
              <i class="material-icons">search</i>
            
                <p>{{ __('Find Your Organization') }}</p>
                
              </a>
        </li>
</ul>
 @endif



</div>
