<li class="nav-item">
    <a href="{{ route('pitching-signers.dashboard') }}" class="nav-link {{ active('pitching-signers.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pitching-signers.index') }}" class="nav-link {{ active('pitching-signers.index') }} {{ active('pitching-signers.show') }}">
      <i class="nav-icon fas fa-pencil-alt"></i>
      <small>
        Assign Proposal
      </small>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('pitching-signers.tasks') }}" class="nav-link {{ active('pitching-signers.tasks') }}  ">
      <i class="nav-icon fas fa-hand-o-right"></i>
      <small>
        Assigned Proposal
      </small>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('pitching-signers.pending_tasks') }}" class="nav-link {{ active('pitching-signers.pending_tasks') }}  ">
      <i class="nav-icon fas fa-search"></i>
      <small>
       Verify Proposal
      </small>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('pitching-signers.finished_tasks') }}" class="nav-link {{ active('pitching-signers.finished_tasks') }}  ">
      <i class="nav-icon fa fa-thumbs-o-up"></i>
      <small>
       Verified Proposal
      </small>
    </a>
  </li>
{{--
  <li class="nav-item">
    <a href="{{ route('pitching-signers.tasks') }}" class="nav-link {{ active('pitching-signers.tasks') }}">
    <i class="nav-icon fas fa-list-alt"></i>
    <small>
        Proposal List
    </small>
    </a>
</li>

  <li class="nav-item">
    <a href="{{ route('pitching-signers.pending_tasks') }}" class="nav-link {{ active('pitching-signers.pending_tasks') }}">
    <i class="nav-icon fas fa-hourglass"></i>
    <small>
        Proposal to verify
    </small>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('pitching-signers.finished_tasks') }}" class="nav-link {{ active('pitching-signers.finished_tasks') }}">
    <i class="nav-icon fas fa-check"></i>
    <small>
        Verified Proposal
    </small>
    </a>
</li> --}}
