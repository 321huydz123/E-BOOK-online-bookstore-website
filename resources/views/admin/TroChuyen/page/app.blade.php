  <div class="px-4 pt-9 pb-6">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                      <div class="position-relative">
                        <img src="{{ asset(auth()->user()->anh ? auth()->user()->anh : 'admin/images/profile/user-1.jpg' ) }}" alt="user1" width="54" height="54" class="rounded-circle">
                        <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                          <span class="visually-hidden">New alerts</span>
                        </span>
                      </div>
                      <div class="ms-3">
                        <h6 class="fw-semibold mb-2">{{ auth()->user()->ten }}</h6>
                        <p class="mb-0 fs-2">Admin</p>
                      </div>
                    </div>

                  </div>
                  <form class="position-relative mb-4">
                    <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                  </form>
                  <div class="dropdown">
                    <a class="text-muted fw-semibold d-flex align-items-center" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Recent Chats<i class="ti ti-chevron-down ms-1 fs-5"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item" href="javascript:void(0)">Sort by time</a>
                      </li>
                      <li>
                        <a class="dropdown-item border-bottom" href="javascript:void(0)">Sort by Unread</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0)">Hide favourites</a>
                      </li>
                    </ul>
                  </div>
                </div>

 <div class="app-chat">
      <ul id="conversations-app" class="chat-users mh-n100 simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">

 @foreach ($datalistuser as $conversation)
  @php
    // Xác định người dùng khác (không phải người dùng đăng nhập)
    $otherUser = $conversation->userOne && $conversation->userOne->id != auth()->id()
                ? $conversation->userOne
                : $conversation->userTwo;
  @endphp
  <li data-id="{{ $conversation->id }}" data-name="{{ $otherUser->ten }}" data-img="{{ $otherUser->anh ?? 'admin/images/profile/user-1.jpg' }}">
    <a href="javascript:void(0)" class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light-subtle" id="chat_user_{{ $conversation->id }}" data-user-id="{{ $conversation->id }}">
      <div class="d-flex align-items-center">
        <span class="position-relative">
          <img src="{{ asset($otherUser->anh ?? 'admin/images/profile/user-1.jpg') }}" alt="{{ $otherUser->ten }}" width="48" height="48" class="rounded-circle">
        {{-- @if ($conversation->messages->isNotEmpty() && $conversation->messages->first()->trang_thai == 0)
          <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-danger">
            <span class="visually-hidden">Tin nhắn chưa đọc</span>
          </span>
          @else
          <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
            <span class="visually-hidden">Đã đọc</span>
          </span>
          @endif --}}
        </span>
        <div class="ms-3 d-inline-block w-75">
          <h6 class="mb-1 fw-semibold chat-title" data-username="{{ $otherUser->ten }}">
            {{ $otherUser->ten }}
          </h6>
          @if ($conversation->messages->first())
            @php
                $message = $conversation->messages->first();
            @endphp
            @if ($message->nguoi_gui == auth()->id())
                <span class="fs-3 text-truncate text-body-color d-block">
                    Bạn: {{ $message->noi_dung }}
                </span>
            @else
                <span class="fs-3 text-truncate text-dark text-body-color d-block {{ $message->trang_thai == 0 ? 'fw-semibold' : '' }}">
                    {{ $message->noi_dung }}
                </span>
            @endif
        @else
            <span class="fs-3 text-truncate text-body-color d-block">
                Không có tin nhắn.
            </span>
        @endif


        </div>
      </div>
      <p class="fs-2 mb-0 text-muted">
        @if ($conversation->messages->first())
          {{ $conversation->messages->first()->created_at->diffForHumans() }}
        @endif
      </p>
    </a>
  </li>
@endforeach
                  </div>
                </div>
            </div>
        </div>
        <div class="simplebar-placeholder" style="width: 330px; height: 560px;"></div>
    </div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 282px; display: block; transform: translate3d(0px, 0px, 0px);">
                </div>
            </div>
        </ul>
                </div>
