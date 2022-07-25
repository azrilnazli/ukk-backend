<li class="nav-item">
    <a href="{{ route('screening-signers.dashboard') }}" class="nav-link {{ active('screening-signers.dashboard') }}">
      <i class="nav-icon fas fa-home"></i>
      <p>
        Home
      </p>
    </a>
</li>




  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('screening-signers.index')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Signers
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('screening-signers.pending-tasks') }}" class="nav-link {{ active('screening-signers.pending-tasks') }} {{ active('screening-signers.show') }}">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <small>
                Assign Proposal
              </small>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('screening-signers.finished-tasks') }}" class="nav-link {{ active('screening-signers.finished-tasks') }}  ">
              <i class="nav-icon fas fa-hand-o-right"></i>
              <small>
                Assigned Proposal
              </small>
            </a>
          </li>
    </ul>
  </li>



  <li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('screening-verifications')  }}">
      <i class="nav-icon fas fa-book"></i>
      <p>
        Verification
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('screening-verifications.pending-tasks') }}" class="nav-link {{ active('screening-verifications.pending-tasks') }} {{ active('screening-verifications.show') }}">
              <i class="nav-icon fas fa-pencil-alt"></i>
              <small>
                Verify Proposal
              </small>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('screening-verifications.finished-tasks') }}" class="nav-link {{ active('screening-verifications.finished-tasks') }}  ">
              <i class="nav-icon fas fa-hand-o-right"></i>
              <small>
                Verified Proposal
              </small>
            </a>
          </li>
    </ul>
  </li>


