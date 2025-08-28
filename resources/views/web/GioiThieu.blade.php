@extends('layouts.user')
@section('noidung')
<main class="main" style="background-color: #fff;">

    <body>

        <div class="container1">
            <div class="nd">
                – <strong style="color : blue ">EduBook.com</strong> là trang thương mại điện tử chuyên giới thiệu và
                bán lẻ sách ngoại ngữ với những đầu sách chọn lọc và hay nhất hiện nay. <br>
                <p>Các đầu sách được chúng tôi phân loại theo từng chuyên mục, từng trình độ giúp người học dễ dàng chọn
                    được bộ giáo trình phù hợp với trình độ của mình. Việc học ngoại ngữ sẽ trở nên hiệu quả hơn, tiết
                    kiệm thời gian hơn khi bạn chọn đúng sách và đúng phương pháp học.
                </p> <br>

            </div>

            <div class="main">
                <strong style="color : green ">Tầm nhìn:</strong>
                <strong style="color : blue ">EduBook</strong><strong style="color : red ">.com</strong> hướng tới là
                trở thành website bán lẻ sách, truyện với đủ thể loại chủ đề trên thế giới trực tuyến số 1 tại Việt Nam.
                Là địa chỉ mua sách tin cậy của hàng triệu độc giả trên cả nước. Góp phần phổ biến và nâng cao trí tuệ.
                Đến với EduBook.com, khách hàng sẽ được hưởng các tiện ích sau: <br>
                <br>
                <br>

                – Dịch vụ chăm sóc khách hàng chu đáo trước & sau khi mua hàng. <br>
                <br>
                – Dễ dàng tìm được đầu sách, tài liệu học ngoại ngữ theo đúng trình độ, nhu cầu với giá hợp lý nhất.
                <br>
                <br>
                – Thường xuyên có chương trình giảm giá, ưu đãi với hàng nghìn đầu sách. <br>
                <br>
                – Giao hàng tận nơi, nhận hàng và thanh toán tại chỗ. <br>
                <br>
                + Trong vòng 24h đối với đơn hàng tại Hà Nội (Nội thành) <br>
                <br>
                + Trong vòng 3 – 7 ngày đối với đơn hàng tại ngoại thành Hà Nội và tỉnh/ thành khác. <br>
                <br>
                + Qúy khách được kiểm tra hàng trước khi nhận, thanh toán. <br>
                <br>

            </div>
            <div class="foot">
                Quý khách có nhu cầu đặt mua sách/ … qua điện thoại hay phản hồi ý kiến xin vui lòng liên hệ: <br>
                <br>
                – Qua Hotline : <u style="color : red ">{{ $configData['phone_number'] }} </u> <br>
                <br>
                – Qua email: <u style="color : red ">{{ ENV('MAIL_USERNAME') }} </u> <br>
                <br>
            </div>
        </div>
    </body>
</main>

@endsection
