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
        @include('partials.nav.home')
    @endhasanyrole

    @hasrole('super-admin')
        @include('partials.nav.contents')
    @endrole

    @hasrole('super-admin')
        @include('partials.nav.tenders')
    @endhasrole

    @hasanyrole('super-admin|admin')
        @include('partials.nav.company_approvals')
    @endhasanyrole

    @hasrole('JSPD-URUSETIA')
        @include('partials.nav.scorings-urusetia')
    @endhasrole

    @hasrole('JSPD-PENANDA')
        @include('partials.nav.scorings-penanda')
    @endhasrole

    @hasrole('super-admin')
            @include('partials.nav.users')
    @endhasrole

    @hasanyrole('super-admin|JSPD-ADMIN')
            @include('partials.nav.jspd_admins')
    @endhasanyrole

    @hasanyrole('super-admin|admin')
            @include('partials.nav.tender_submissions')
            @include('partials.nav.videos')
    @endhasanyrole

  </ul>
