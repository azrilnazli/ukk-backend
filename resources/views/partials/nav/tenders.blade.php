<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('tenders')  }}">
      <i class="nav-icon fas fa-list-alt"></i>
      <p>
        Tender
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-3 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('tenders.index') }}" class="nav-link {{ active('tenders.index') }}">
                <i class="nav-icon fas fa-pencil-alt"></i>
                <p>
                   <small> Manage Tender </small>
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tender-details.index') }}" class="nav-link {{ active('tender-details.index')  }}">
                <i class="nav-icon fa fa-pencil"></i>
                <p>
                    <small> Tender Detail </small>
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tender-requirements.index') }}" class="nav-link {{ active('tender-requirements.index')  }}">
                <i class="nav-icon fa fa-pencil"></i>
                <p>
                    <small>  Tender Requirement </small>
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('tender-categories.index') }}" class="nav-link {{ active('tender-categories.index')  }}">
                <i class="nav-icon fa fa-pencil"></i>
                <p>
                    <small>Tender Category </small>
                </p>
            </a>
        </li>

    </ul>
  </li> <!-- ./treeview -->
