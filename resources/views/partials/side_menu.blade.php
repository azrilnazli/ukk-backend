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
        @include('partials.nav.users')
    @endhasrole

    @hasrole('super-admin')
        @include('partials.nav.contents')
    @endrole

    @hasrole('super-admin')
        @include('partials.nav.tenders')
    @endhasrole

    @hasanyrole('super-admin|admin')
        @include('partials.nav.company_approvals')
    @endhasanyrole

    @hasanyrole('super-admin|jspd-admin')
        @include('partials.nav.jspd_admins')
    @endhasanyrole

    @hasrole('jspd-urusetia')
        @include('partials.nav.scorings-urusetia')
    @endhasrole

    @hasrole('jspd-penanda')
        @include('partials.nav.scorings-penanda')
    @endhasrole

    @hasanyrole('super-admin|admin')
        @include('partials.nav.tender_submissions')
        @include('partials.nav.videos')
    @endhasanyrole

</ul>
