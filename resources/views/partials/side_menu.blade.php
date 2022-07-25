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
<div class="mr-1">

<ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
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

        @include('partials.nav.videos')
    @endhasrole

    @hasrole('admin')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')

        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-ketua')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')

        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-admin')
        @include('partials.nav.home')
        @include('partials.nav.jspd_admins')
    @endhasrole

    @hasrole('jspd-assistant')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')

        @include('partials.nav.videos')
    @endhasrole

    @hasrole('jspd-urusetia')
        @include('partials.nav.scorings-urusetia')
    @endhasrole

    @hasrole('jspd-penanda')
        @include('partials.nav.scorings-penanda')
    @endhasrole

    @hasrole('pitching-urusetia')
        @include('partials.nav.pitching.urusetia')
    @endhasrole

    @hasrole('pitching-penanda')
        @include('partials.nav.pitching.penanda')
    @endhasrole

    @hasrole('screening-urusetia')
        @include('partials.nav.screening.urusetia')
    @endhasrole

    @hasrole('screening-penanda')
        @include('partials.nav.screening.penanda')
    @endhasrole

    @hasanyrole('ketua-urusetia')
        @include('partials.nav.home')
        @include('partials.nav.company_approvals')
        @include('partials.nav.jspd_admins')
        @include('partials.nav.pitching.ketua')
        @include('partials.nav.screening.ketua')
        @include('partials.nav.videos')
    @endhasanyrole


</ul>
</div>
