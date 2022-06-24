<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('jspd-admins')  }}">
      <i class="nav-icon fas fa-database"></i>
      <p>
        JSPD
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-3  nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('jspd-admins.index') }}" class="nav-link {{ active('jspd-admins.index')  }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              <small>Proposal</small>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('jspd-admins.approved') }}" class="nav-link {{ active('jspd-admins.approved')  }}">
            <i class="nav-icon fas fa-check"></i>
            <p>
              <small>Lulus</small>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.failed') }}" class="nav-link {{ active('jspd-admins.failed')  }}">
            <i class="nav-icon fas fa-times"></i>
            <p>
              <small>Gagal</small>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.pending') }}" class="nav-link {{ active('jspd-admins.pending')  }}">
            <i class="nav-icon fas fa-hourglass"></i>
            <p>
              <small>Belum Ditanda</small>
            </p>
          </a>
        </li>


    </ul>
  </li> <!-- ./treeview -->
