

  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('company-approvals.index')  }}">
      <i class="nav-icon fas fa-building"></i>
      <p>
        Company
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1  ml-1 nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('companies.index') }}" class="nav-link {{ active('companies.index') }}">
          <i class="nav-icon fa fa-cloud-upload"></i>
          <p>
            <small>Registered Companies</small>
          </p>
        </a>
      </li>

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
