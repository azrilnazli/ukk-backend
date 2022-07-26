<li class="nav-item">
    <a href="{{ route('screening-scorings.dashboard') }}" class="nav-link {{ active('screening-scorings.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
</li>
{{--


  <li class="nav-item">
    <a href="{{ route('screening-scorings.index') }}" class="nav-link {{ active('screening-scorings.index') }}  ">
      <i class="nav-icon fas fa-star"></i>
      <small>
        My Proposal
      </small>
    </a>
  </li> --}}


  <li class="nav-item">
    <a href="{{ route('screening-scorings.pending_tasks') }}" class="nav-link {{ active('screening-scorings.pending_tasks') }}">
    <i class="nav-icon fas fa-hourglass"></i>
    <small>
        Proposal to verify
    </small>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('screening-scorings.finished_tasks') }}" class="nav-link {{ active('screening-scorings.finished_tasks') }}">
    <i class="nav-icon fas fa-check"></i>
    <small>
        Verified Proposal
    </small>
    </a>
</li>
