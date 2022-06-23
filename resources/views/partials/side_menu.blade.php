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


    @hasrole('super-admin')
        @include('partials.nav.home')
        @include('partials.nav.users')
        @include('partials.nav.contents')
        @include('partials.nav.tenders')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')
        @include('partials.nav.tender_submissions')
        @include('partials.nav.videos')
    @endhasrole

    @hasrole('admin')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.tender_submissions')
        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-ketua')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')
        @include('partials.nav.tender_submissions')
        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-admin')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')
        @include('partials.nav.tender_submissions')
        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-assistant')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.tender_submissions')
    @endhasrole

    @hasrole('jspd-urusetia')
        @include('partials.nav.scorings-urusetia')
    @endhasrole

    @hasrole('jspd-penanda')
        @include('partials.nav.scorings-penanda')
    @endhasrole

</ul>
