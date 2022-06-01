@php

  function active($menu){
    $route = Route::currentRouteName();

    if(preg_match("/{$menu}/i", $route)) {
      return "active";
      } else{
      return null;
      }
    }

//     $a = 'users.index';
// $search = 'users';
// if(preg_match("/{$search}/i", $a)) {
//     echo 'true';
// }


@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-header"></li>

    <li class="nav-item">
      <a href="/home" class="nav-link {{ active('home') }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Home
        </p>
      </a>
    </li>



  @hasrole('super-admin')
  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('users')  }}">
      <i class="nav-icon fas fa-user"></i>
      <p>
        User
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

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

  
  @hasanyrole('super-admin|jspd-admin')
  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('users')  }}">
      <i class="nav-icon fas fa-database"></i>
      <p>
        JSPD
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

      <li class="nav-item">
        <a href="{{ route('scorings.index') }}" class="nav-link {{ active('users.index') }}">
          <i class="nav-icon fa fa-dashboard"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('scorings.index') }}" class="nav-link {{ active('scorings.index') }}">
          <i class="nav-icon fas fa-archive"></i>
          <p>
            Proposals
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('scorings.index') }}" class="nav-link {{ active('users.index') }}">
          <i class="nav-icon fas fa-pencil-alt"></i>
          <p>
            Assign Penanda
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('scorings.index') }}" class="nav-link {{ active('users.index') }}">
          <i class="nav-icon fa fa-area-chart"></i>
          <p>
            Activity
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
      <a href="#" class="nav-link {{ active('tenders')  }}">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Proposal
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="/tenders" class="nav-link {{ active('tenders') }}">
            <i class="nav-icon fas fa-pencil-alt"></i>
            <p>
              Manage Tender
            </p>
          </a>
        </li>

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
      <ul class="nav nav-treeview">
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
