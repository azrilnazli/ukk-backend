

  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('company-approvals.index')  }}">
      <i class="nav-icon fas fa-building"></i>
      <p>
        Company
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-3  nav nav-treeview">
      {{-- <li class="nav-item">
        <a href="{{ route('companies.index') }}" class="nav-link {{ active('companies.index') }}">
          <i class="nav-icon fas fa-list"></i>
          <p>
            Registered Companies
          </p>
        </a>
      </li> --}}

      <li class="nav-item">
        <a href="{{ route('company-approvals.index') }}" class="nav-link {{ active('company-approvals.index') }}">
          <i class="nav-icon fas fa-question"></i>
          <p>
            <small>Request for Approval</small>
          </p>
        </a>
      </li>

    </ul>
  </li> <!-- ./treeview -->
