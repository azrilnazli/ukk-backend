
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
          <i class="nav-icon fas fa-home"></i>
          <small>
            Home
          </small>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('screening-admins.pending-tasks') }}" class="nav-link {{ active('screening-admins.pending-tasks') }}">
          <i class="nav-icon fas fa-hourglass"></i>
          <small>
            Pending Tasks
          </small>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('screening-admins.finished-tasks') }}" class="nav-link {{ active('screening-admins.finished-tasks') }}">
          <i class="nav-icon fas fa-check"></i>
          <small>
            Finished Tasks
          </small>
        </a>
      </li>


    </ul>
  </li>


