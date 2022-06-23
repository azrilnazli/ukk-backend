<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('videos')  }}">
      <i class="nav-icon fas fa-video"></i>
      <p>
        Video
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-3 nav nav-treeview">
      <li class="nav-item">
        <a href="/videos" class="nav-link  {{ active('videos.index') }}">
          <i class="nav-icon fas fa-check"></i>
          <p>Success</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/videos/failed" class="nav-link  {{ active('videos.failed') }}">
          <i class="fas fa-times nav-icon"></i>
          <p>Failed</p>
        </a>
      </li>
      <li class="nav-item">
          <a href="/videos/encoding_status" class="nav-link  {{ active('videos.encoding_status') }}">
            <i class="fas fa-upload nav-icon"></i>
            <p>Realtime Encoding</p>
          </a>
        </li>

      <li class="nav-item">
        <a href="/queue/jobs" class="nav-link  {{ active('videos.jobs') }}">
          <i class="fas fa-cog nav-icon"></i>
          <p>Queue Monitor</p>
        </a>
      </li>
    </ul>
  </li>
