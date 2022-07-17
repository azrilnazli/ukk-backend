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
    <i class="nav-icon fas fa-list-alt"></i>
    <small>
        Proposal List
    </small>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('scorings.pending_tasks') }}" class="nav-link {{ active('scorings.pending_tasks') }}">
    <i class="nav-icon fas fa-hourglass"></i>
    <small>
        Proposal to sign
    </small>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('scorings.finished_tasks') }}" class="nav-link {{ active('scorings.finished_tasks') }}">
    <i class="nav-icon fas fa-check"></i>
    <small>
        Signed Proposal
    </small>
    </a>
</li>
