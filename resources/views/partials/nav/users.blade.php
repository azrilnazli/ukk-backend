<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('users')  }}">
      <i class="nav-icon fas fa-user"></i>
      <p>
        User
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1  nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ active('users.index') }}">
          <i class="nav-icon fas fa-users"></i>
          <p>
            <small>  Users</small>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('user-roles.index') }}" class="nav-link {{ active('user-roles.index') }}">
          <i class="nav-icon fas fa-cubes"></i>
          <p>
            <small> Roles</small>
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/permissions" class="nav-link {{ active('permissions') }}">
          <i class="nav-icon fa fa-lock"></i>
          <p>
            <small> Permission</small>
          </p>
        </a>
      </li>
    </ul>
  </li> <!-- ./treeview -->
