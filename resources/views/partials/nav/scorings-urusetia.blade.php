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
