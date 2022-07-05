<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('jspd-admins')  }}">
      <i class="nav-icon fas fa-database"></i>
      <p>
        JSPD
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1  nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('jspd-admins.index') }}" class="nav-link {{ active('jspd-admins.index')  }}">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              <small>Proposal List</small>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('jspd-admins.approved') }}" class="nav-link {{ active('jspd-admins.approved')  }}">
            <i class="nav-icon fas fa-check"></i>
            <p>
              <small>Approved Proposal</small>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.failed') }}" class="nav-link {{ active('jspd-admins.failed')  }}">
            <i class="nav-icon fas fa-times"></i>
            <p>
              <small>Rejected Proposal</small>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.awaiting') }}" class="nav-link {{ active('jspd-admins.awaiting')  }}">
            <i class="nav-icon fas fa-hourglass"></i>
            <p>
              <small>Pending Proposal</small>
            </p>
          </a>
        </li>




        <li class="nav-item">
            <a href="{{ route('jspd-admins.pending_tasks') }}" class="nav-link {{ active('jspd-admins.pending_tasks') }}">
            <i class="nav-icon fas fa-search"></i>
            <small>
                Proposal to approve
            </small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('jspd-admins.finished_tasks') }}" class="nav-link {{ active('jspd-admins.finished_tasks') }}">
            <i class="nav-icon fas fa-check"></i>
            <small>
                Approved Proposal
            </small>
            </a>
        </li>

    </ul>
  </li> <!-- ./treeview -->
