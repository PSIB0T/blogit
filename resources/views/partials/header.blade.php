<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">BlogIt</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="{{ route('blog.index') }}">Home</a></li>
      <li class="active"><a href="{{ route('blog.index') }}">Blog</a></li>
      <li><a href="{{ route('other.about') }}">About</a></li>
      @if(Auth::guest())
        <li><a href="{{ url('/login') }}">Login</a></li>
        <li><a href="{{ url('/register') }}">Register</a></li>
      @else
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ url('/logout') }}"onclick = "event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
      @endif
        <form id = "logout-form" action="{{url('/logout')}}" method="post" style="display:none">
          {{ csrf_field() }}
        </form>

    </ul>
  </div>
</nav>
