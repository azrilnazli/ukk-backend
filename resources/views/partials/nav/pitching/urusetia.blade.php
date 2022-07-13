<li class="nav-item">
    <a href="{{ route('pitching-signers.dashboard') }}" class="nav-link {{ active('pitching-signers.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
</li>




  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('pitching-signers')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Signers
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pitching-signers.pending-tasks') }}" class="nav-link {{ active('pitching-signers.pending-tasks') }} {{ active('pitching-signers.show') }}">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <small>
                Assign Proposal
              </small>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('pitching-signers.finished-tasks') }}" class="nav-link {{ active('pitching-signers.finished-tasks') }}  ">
              <i class="nav-icon fas fa-hand-o-right"></i>
              <small>
                Assigned Proposal
              </small>
            </a>
          </li>
    </ul>
  </li>



  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('pitching-verifications')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Verification
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pitching-signers.pending-tasks') }}" class="nav-link {{ active('pitching-signers.pending-tasks') }} {{ active('pitching-signers.show') }}">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <small>
                Verify Proposal
              </small>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('pitching-signers.finished-tasks') }}" class="nav-link {{ active('pitching-signers.finished-tasks') }}  ">
              <i class="nav-icon fas fa-hand-o-right"></i>
              <small>
                Verified Proposal
              </small>
            </a>
          </li>
    </ul>
  </li>


