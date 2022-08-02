
  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('pitching-admins.index')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Pitching
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('pitching-admins.dashboard') }}" class="nav-link {{ active('pitching-admins.dashboard') }}">
          <i class="nav-icon fas fa-pencil-alt"></i>
          <small>
            Home
          </small>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('pitching-admins.pending-tasks') }}" class="nav-link {{ active('pitching-admins.pending-tasks') }}">
          <i class="nav-icon fas fa-hourglass"></i>
          <small>
            Pending Tasks
          </small>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('pitching-admins.finished-tasks') }}" class="nav-link {{ active('pitching-admins.finished-tasks') }}">
          <i class="nav-icon fas fa-check"></i>
          <small>
            Finished Tasks
          </small>
        </a>
      </li>


    </ul>
  </li>


