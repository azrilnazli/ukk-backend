<li class="nav-item has-treeview menu-close">
    <a href="#" class="nav-link {{ active('videos')  }}">
      <i class="nav-icon fas fa-video"></i>
      <p>
        Video
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="ml-1 nav nav-treeview">
      <li class="nav-item">
        <a href="/videos" class="nav-link  {{ active('videos.index') }}">
            <small><i class="nav-icon fas fa-list-alt"></i>
          <p>Videos</p></small>
        </a>
      </li>
      <li class="nav-item">
        <a href="/videos/failed" class="nav-link  {{ active('videos.failed') }}">
            <small><i class="text-danger nav-icon fas fa-list-alt"></i>
          <p class="text-red">Failed Video</p></small>
        </a>
      </li>

      <li class="nav-item">
          <a href="/videos/encoding_status" class="nav-link  {{ active('videos.uploaded_encoding_status') }}">
            <small><i class="fas fa-upload nav-icon"></i>
            <p><small>Uploaded Encoding Status</small></p></small>
          </a>
        </li>
        <li class="nav-item">
            <a href="/videos/failed_status" class="nav-link  {{ active('videos.failed_encoding_status') }}">
              <small><i class="fas fa-upload nav-icon text-warning"></i>
              <p class="text-warning"><small>Re-Encode Status</small></p></small>
            </a>
          </li>


      <li class="nav-item">
        <a href="/queue/jobs" class="nav-link  {{ active('videos.jobs') }}">
            <small><i class="fas fa-cog nav-icon"></i>
          <p>Queue Monitor</p></small>
        </a>
      </li>
    </ul>
  </li>
