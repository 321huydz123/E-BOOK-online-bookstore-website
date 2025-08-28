@extends('layouts.admin-layout')
@section('noidung')


<div  style="padding-top:90px ">
 @php
        $loggedIn_userId = auth()->user()->id;
        $loggedIn_userName = auth()->user()->ten;
    @endphp
<div class="card overflow-hidden chat-application">
            <div class="d-flex align-items-center justify-content-between gap-6 m-3 d-lg-none">
              <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#chat-sidebar" aria-controls="chat-sidebar">
                <i class="ti ti-menu-2 fs-5"></i>
              </button>
              <form class="position-relative w-100">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
              </form>
            </div>
            <div class="d-flex">
              <div class="w-30 d-none d-lg-block border-end user-chat-box">
                <div class="px-4 pt-9 pb-6">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                      <div class="position-relative">
                      <img src="{{ asset(auth()->user()->anh ? auth()->user()->anh : 'admin/images/profile/user-1.jpg' ) }}"
     alt="user1" width="54" height="54" class="rounded-circle">

                        <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                          <span class="visually-hidden">New alerts</span>
                        </span>
                      </div>
                      <div class="ms-3">
                        <h6 class="fw-semibold mb-2"> {{ auth()->user()->ten }}</h6>
                        <p class="mb-0 fs-2">Admin</p>
                      </div>
                    </div>

                  </div>
                  <form class="position-relative mb-4">
                    <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                  </form>

                </div>
                <div class="app-chat">
                  <ul id="conversations" class="chat-users mb-0 mh-n100 simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">

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



                  </div></div></div></div><div class="simplebar-placeholder" style="width: 345px; height: 560px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 282px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                </div>
            </ul>
                </div>
              </div>
              <div class="w-70 w-xs-100 chat-container">
                <div class="chat-box-inner-part h-100">
                  <div class="chat-not-selected h-100 d-none">
                    <div class="d-flex align-items-center justify-content-center h-100 p-5">
                      <div class="text-center">
                        <span class="text-primary">
                          <i class="ti ti-message-dots fs-10"></i>
                        </span>
                        <h6 class="mt-2">Open chat from the list</h6>
                      </div>
                    </div>
                  </div>
                  <div class="chatting-box d-block d-none" id="appchat">
                    <div class="p-9 border-bottom chat-meta-user d-flex align-items-center justify-content-between ">
                      <div class="hstack gap-3 current-chat-user-name ">
                        <div class="position-relative">
                          <img  id="targetImage"  width="48" height="48" class="rounded-circle">
                          <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                            <span class="visually-hidden">New a lerts</span>
                          </span>
                        </div>
                        <div>

                            {{-- pc chỗ tên người nhắn  --}}
                          <h6 class="mb-1 name fw-semibold d-none"  id="recipient-name-display"></h6>
                          <p class="mb-0 d-none"  id="recipient-role-display">Người dùng</p>
                        </div>
                      </div>
                      <ul class="list-unstyled mb-0 d-flex align-items-center">
                        <li>
                          <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                            <i class="ti ti-phone"></i>
                          </a>
                        </li>
                        <li>
                          <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                            <i class="ti ti-video"></i>
                          </a>
                        </li>
                        <li>
                          <a class="chat-menu text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5 app-chat-active" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="d-flex parent-chat-box app-chat-right ">
                      <div class="chat-box w-xs-100"  >
                        <div class="chat-box-inner p-9" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -20px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                            <div class="simplebar-content"
                           >
                          <div class="chat-list chat active-chat overflow-auto"  id="chat-container" data-user-id="1" style="max-height: 577px;">


                          </div>


                        </div></div></div></div><div class="simplebar-placeholder" style="width: 806px; height: 577px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div></div></div>
                        <div class="px-9 py-6 border-top chat-send-message-footer">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 w-85">
                              {{-- <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)">
                                <i class="ti ti-mood-smile text-dark bg-hover-primary fs-7"></i>
                              </a> --}}
                              <input type="text" id="msg-input" class="form-control message-type-box text-muted border-0 p-0 ms-2"  placeholder="Type a Message" onkeypress="checkEnter(event)" fdprocessedid="0p3op">
                            </div>
                            <ul class="list-unstyledn mb-0 d-flex align-items-center">
                              <li>
                                <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                                  <i class="ti ti-photo-plus"></i>
                                </a>
                              </li>
                              <li>

                                <button type="button" onclick="sendMessage(currentChannel)"  class="btn btn-light m-1">
                                    <i class="ti ti-send"></i>
                                </button>



                              </li>

                            </ul>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="offcanvas offcanvas-start user-chat-box chat-offcanvas" tabindex="-1" id="chat-sidebar" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                    Chats
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                @include('admin.TroChuyen.page.app')

               {{-- app --}}
              </div>
            </div>
          </div>
          </div>

        

@include('admin.TroChuyen.page.script')

@endsection
