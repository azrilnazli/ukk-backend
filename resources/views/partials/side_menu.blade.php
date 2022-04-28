@php
  
  function active($menu){
    $route = Route::currentRouteName();
    if(preg_match("/{$menu}/i", $route)) {
      return "active";
      } else{
      return null;
      }
    }

//     $a = 'users.index';
// $search = 'users';
// if(preg_match("/{$search}/i", $a)) {
//     echo 'true';
// }


@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
   
    <li class="nav-header"></li>
    <li class="nav-item">
      <a href="/home" class="nav-link {{ active('home') }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Home 
        </p>
      </a>
    </li>

    <li class="nav-item">
        <a href="/users" class="nav-link {{ active('users') }}">
          <i class="nav-icon far fa-user"></i>
          <p>
            User
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/companies" class="nav-link {{ active('companies') }}">
          <i class="nav-icon fas fa-newspaper"></i>
          <p>
            Companies
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/categories" class="nav-link {{ active('categories') }}">
          <i class="nav-icon fas fa-list"></i>
          <p>
            Categories
          </p>
        </a>
      </li>

    <li class="nav-item">
      <a href="/videos" class="nav-link {{ active('videos') }}">
        <i class="nav-icon fas fa-video"></i>
        <p>
          Video
        </p>
      </a>
    </li>

  </ul>