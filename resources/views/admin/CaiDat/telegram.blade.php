@extends('layouts.admin-layout')
@section('noidung')
<div class="container-xxl flex-grow-1 container-p-y">
            <div class="app-ecommerce">
                <form action="{{ route('Them-telegram') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Add Notification -->
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                        <div class="d-flex flex-column justify-content-center">
                            <h4 class="mb-1">Telegram</h4>
                        </div>
                        {{-- {{ dd($data) }} --}}
                        <div class="d-flex align-content-center flex-wrap gap-4">
                            <div class="d-flex gap-4">
                                {{-- <button type="button" class="btn btn-label-primary"
                                    onclick="window.location='{{ route('notifications.index') }}'">Cancel</button> --}}
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-send-notification">Lưu</button>
                        </div>
                    </div>


                    <div class="nav-align-top">
                        <ul class="nav nav-pills mb-4" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                                    aria-selected="true">Bot Đặt Hàng</button>
                            </li>


                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                                <div class="row">
                                    <!-- First column-->
                                    <div class="col-12 col-lg-12">
                                        <!-- Notification Information -->
                                        <div class=" mb-6">
                                            {{-- <div class="card-header">
                                                <h5 class="card-title mb-0">Telegram</h5>
                                            </div> --}}
                                            <div class="card-body">
                                                <!-- Description -->
                                                <div class="mb-6">
                                                    <label for="message" class="form-label">Mẫu Tin Nhắn</label>
                                                    <textarea class="form-control" name="message" id="editor" rows="9" placeholder="Message Template">{{ !empty($data['message'])
                                                        ? trim($data['message'])
                                                        : trim(
                                                            "🎉 Thông báo đơn hàng mới! 🎉
                                                                    📦 Tên sản phẩm: {TEN_SAN_PHAM}
                                                                    🆔 ID Người đặt: {ID_USER}
                                                                    🤝 Đơn hàng ID: {DON_HANG_ID}
                                                                    💵 Tổng tiền Paid: {TONG_TIEN}
                                                                    🕛 Thời gian thành toán: {PAYMENT_DATE}
                                                                    Chúc mừng bạn đã có đơn hàng mới! 🎉",
                                                        ) }}</textarea>

                                                </div>

                                                <div class="mb-6">
                                                    <label class="form-label" for="chatID">Chat ID</label>
                                                    <input type="text" class="form-control" id="chatID"
                                                        placeholder="Chat ID" name="chatID"
                                                        value="{{ !empty(env('TELEGRAM_CHAT_ID')) ? trim(env('TELEGRAM_CHAT_ID')) : env('TELEGRAM_CHAT_ID') }}"
                                                        aria-label="Notification title">
                                                </div>

                                                <div class="form-password-toggle">
                                                    <label class="form-label" for="botToken">Bot Token</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" class="form-control" id="botToken"
                                                            name="botToken"
                                                            value="{{ !empty(env('TELEGRAM_BOT_TOKEN')) ? trim(env('TELEGRAM_BOT_TOKEN')) : env('TELEGRAM_BOT_TOKEN') }}"
                                                            placeholder="············"
                                                            aria-describedby="basic-default-password">
                                                        <span class="input-group-text cursor-pointer"
                                                            id="basic-default-password"><i class="bx bx-hide"></i></span>
                                                    </div>
                                                </div>


                                                <div class="accordion mt-4" id="accordionExample">
                                                    <div class="card accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button type="button" class="accordion-button collapsed"
                                                                data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                                aria-expanded="false" aria-controls="accordionThree">
                                                               Hướng dẫn sử dụng
                                                            </button>
                                                        </h2>
                                                        <div id="accordionThree" class="accordion-collapse collapse"
                                                            aria-labelledby="headingThree"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div
                                                                    class="ant-space css-14brfei ant-space-vertical ant-space-gap-row-small ant-space-gap-col-small">
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei">1. Sử dụng <a
                                                                                class="ant-typography css-14brfei"
                                                                                href="https://www.thegioididong.com/game-app/huong-dan-tao-bot-telegram-don-gian-ai-cung-co-the-thuc-hien-1395501"
                                                                                target="_blank" rel="noopener noreferrer">
                                                                               người hướng dẫn
                                                                                đây </a> để tạo bot và nhận mã thông báo.
                                                                        </span>
                                                                    </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei">2. Tạo một
                                                                            mới
                                                                            điện tín
                                                                            nhóm và thêm bot của bạn vào nhóm. </span>
                                                                    </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei">3. Gửi một
                                                                            nhắn tin tới
                                                                            cái
                                                                            nhóm trước khi chuyển sang bước tiếp theo.
                                                                        </span> </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei">4. Một khi bạn
                                                                            có
                                                                            bot
                                                                            mã thông báo, hãy chuẩn bị URL theo định dạng sau:
                                                                            <code>https://api.telegram.org/bot[BOT_TOKEN]/getUpdates</code>.
                                                                        </span> </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei"> 5. Thay thế
                                                                            [BOT_TOKEN]
                                                                           trong URL bằng mã thông báo bot của bạn (thay thế
                                                                            toàn bộ
                                                                            [BOT_TOKEN] giữ chỗ bằng bot thực tế của bạn
                                                                            mã thông báo). Vì
                                                                            ví dụ: nếu mã thông báo bot của bạn là
                                                                            <code>66232322283:AAEadassdasdasdasdasdOOE</code>,
                                                                            cái
                                                                            URL tương ứng sẽ là
                                                                            <code>https://api.telegram.org/bot66232322283:AAEadassdasdasdasdasdOOE/getUpdates</code>.
                                                                        </span> </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei"> 6. Dán
                                                                            sự chuẩn bị
                                                                            URL từ bước 4 vào tab trình duyệt mới. </span>
                                                                    </div>
                                                                    <div class="ant-space-item py-1"> <span
                                                                            class="ant-typography css-14brfei">7. Truy xuất
                                                                            nhóm
                                                                            NHẬN DẠNG
                                                                            như thể hiện trong hình ảnh dưới đây. Lưu ý: Đảm bảo
                                                                            sao chép
                                                                            dấu trừ (ví dụ: trong hình ảnh, ID nhóm là
                                                                            -1002334314285). </span> </div>
                                                                    <div class="ant-space-item py-1">
                                                                        <div class="ant-image css-14brfei"> <img
                                                                                class="ant-image-img css-14brfei w-100"
                                                                                src="https://feline.doctorx.vn/assets/telegram.png">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>


                </form>
            </div>
        </div>
        @endsection
