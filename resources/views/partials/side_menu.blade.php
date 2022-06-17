@php
function active($menu){
    $route = Route::currentRouteName();

    if(preg_match("/{$menu}/i", $route)) {
      return "active";
      } else{
      return null;
      }
}
@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-header"></li>

  @hasanyrole('super-admin|admin')
  <li class="nav-item">
    <a href="/home" class="nav-link {{ active('home') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
  </li>
  @endhasanyrole


  @hasrole('super-admin')
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
                Manage Tender
            </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tender-details.index') }}" class="nav-link {{ active('tender-details.index')  }}">
            <i class="nav-icon fa fa-pencil"></i>
            <p>
                Tender Detail
            </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tender-requirements.index') }}" class="nav-link {{ active('tender-requirements.index')  }}">
            <i class="nav-icon fa fa-pencil"></i>
            <p>
                Tender Requirement
            </p>
            </a>
        </li>


        {{-- <li class="nav-item">
          <a href="{{ route('tenders-categories') }}" class="nav-link {{ active('tenders-categories')  }}">
            <i class="nav-icon fas fa-check"></i>
            <p>
              Tender Category
            </p>
          </a>
        </li> --}}

        {{-- <li class="nav-item">
          <a href="{{ route('tenders.index') }}" class="nav-link {{ active('tenders.index')  }}">
            <i class="nav-icon fas fa-times"></i>
            <p>
              Tender
            </p>
          </a>
        </li> --}}

    </ul>
  </li> <!-- ./treeview -->
  @endhasrole

  @hasrole('JSPD-URUSETIA')
  <li class="nav-item">
    <a href="{{ route('scorings.dashboard') }}" class="nav-link {{ active('scorings.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('signers.index') }}" class="nav-link {{ active('signers.index') }} {{ active('signers.search') }}">
      <i class="nav-icon fas fa-pencil-alt"></i>
      <p>
        Assign
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('signers.tasks') }}" class="nav-link {{ active('signers.tasks') }}  ">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Tasks
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('scorings.tasks') }}" class="nav-link {{ active('scorings.tasks') }}  {{ active('scorings.search') }}">
      <i class="nav-icon fas fa-list"></i>
      <p>
        Proposal
      </p>
    </a>
  </li>
  @endhasrole

  @hasrole('JSPD-PENANDA')
  <li class="nav-item">
    <a href="{{ route('scorings.dashboard') }}" class="nav-link {{ active('scorings.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('scorings.tasks') }}" class="nav-link {{ active('scorings.tasks') }}">
      <i class="nav-icon fas fa-list"></i>
      <p>
        Proposal
      </p>
    </a>
  </li>
  @endhasrole



  @hasrole('super-admin')
  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('users')  }}">
      <i class="nav-icon fas fa-user"></i>
      <p>
        User
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-3  nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ active('users.index') }}">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Users
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('roles') }}" class="nav-link {{ active('roles') }}">
          <i class="nav-icon fas fa-cubes"></i>
          <p>
            Roles
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/permissions" class="nav-link {{ active('permissions') }}">
          <i class="nav-icon fa fa-lock"></i>
          <p>
            Permission
          </p>
        </a>
      </li>
    </ul>
  </li> <!-- ./treeview -->
  @endhasrole


  @hasanyrole('super-admin|JSPD-ADMIN|admin')
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
              Proposal
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('jspd-admins.approved') }}" class="nav-link {{ active('jspd-admins.approved')  }}">
            <i class="nav-icon fas fa-check"></i>
            <p>
              Lulus
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.failed') }}" class="nav-link {{ active('jspd-admins.failed')  }}">
            <i class="nav-icon fas fa-times"></i>
            <p>
              Gagal
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('jspd-admins.pending') }}" class="nav-link {{ active('jspd-admins.pending')  }}">
            <i class="nav-icon fas fa-hourglass"></i>
            <p>
              Belum Ditanda
            </p>
          </a>
        </li>


    </ul>
  </li> <!-- ./treeview -->
  @endhasanyrole


  @hasanyrole('super-admin|admin')
  <li class="nav-item">
  <a href="/companies" class="nav-link {{ active('companies') }}">
      <i class="nav-icon fa fa-users"></i>
      <p>
      Vendor
      </p>
  </a>
  </li>


    <li class="nav-item has-treeview menu-close">
      <a href="#" class="nav-link {{ active('tender_submissions')  }}">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Proposal
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="ml-3  nav nav-treeview">

        <li class="nav-item">
          <a href="/tender_submissions" class="nav-link {{ active('tender_submissions') }}">
            <i class="nav-icon fas fa-search"></i>
            <p>
              View Proposals
            </p>
          </a>
        </li>


      </ul>
    </li>

    <li class="nav-item has-treeview menu-close">
      <a href="#" class="nav-link {{ active('videos')  }}">
        <i class="nav-icon fas fa-video"></i>
        <p>
          Video
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="ml-3 nav nav-treeview">
        <li class="nav-item">
          <a href="/videos" class="nav-link  {{ active('videos.index') }}">
            <i class="nav-icon fas fa-check"></i>
            <p>Success</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/videos/failed" class="nav-link  {{ active('videos.failed') }}">
            <i class="fas fa-times nav-icon"></i>
            <p>Failed</p>
          </a>
        </li>
        <li class="nav-item">
            <a href="/videos/encoding_status" class="nav-link  {{ active('videos.encoding_status') }}">
              <i class="fas fa-upload nav-icon"></i>
              <p>Realtime Encoding</p>
            </a>
          </li>

        <li class="nav-item">
          <a href="/queue/jobs" class="nav-link  {{ active('videos.jobs') }}">
            <i class="fas fa-cog nav-icon"></i>
            <p>Queue Monitor</p>
          </a>
        </li>
      </ul>
    </li>
    @endhasanyrole

    @hasrole('JSPD')
    <li class="nav-item">
        <a href="/home" class="nav-link {{ active('proposals') }}">
          <i class="nav-icon fas fa-list"></i>
          <p>
            All Proposals
          </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/home" class="nav-link {{ active('proposals') }}">
          <i class="nav-icon fas fa-check"></i>
          <p>
            Marked
          </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/home" class="nav-link {{ active('proposals') }}">
          <i class="nav-icon fas fa-hourglass"></i>
          <p>
            Pending
          </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="/home" class="nav-link {{ active('proposals') }}">
          <i class="nav-icon fas fa-search"></i>
          <p>
            Scores
          </p>
        </a>
    </li>
    @endhasrole

  </ul>
