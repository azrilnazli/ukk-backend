
  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('screening-admins.index')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Screening
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('screening-admins.dashboard') }}" class="nav-link {{ active('screening-admins.dashboard') }}">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <small>
                Home
              </small>
            </a>
          </li>


    </ul>
  </li>


