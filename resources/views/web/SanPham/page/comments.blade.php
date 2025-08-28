<div class="tab-pane fade" id="Reviews">
    <!-- Comments Section -->
    <div class="comments-area">
        <div class="row">
            <!-- Customer Questions and Answers -->
            <div class="col-lg-8">
                <h4 class="mb-30">Câu hỏi & trả lời của khách hàng</h4>
                <div class="comment-list" id="list_comment">
                    @forelse($datacmt as $item)
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user d-flex">
                                <div class="thumb text-center">
                                    <img
                                src="{{ $item->user->anh ? asset($item->user->anh) : 'https://img.lovepik.com/free-png/20211130/lovepik-cartoon-avatar-png-image_401205251_wh1200.png' }}"
                                alt="User Image"
                                style="height: 80%;">

                                    <h6><a href="#">{{ $item->user->ten }}</a></h6>
                                </div>
                                <div class="desc">
                                    <div class="product-rate d-inline-block">
                                       <div class="product-rating" style="width: {{ $item->danh_gia * 20 }}%;"></div>

                                    </div>
                                    <p>{{ $item->noi_dung_binh_luan }}</p>
                                    <div class="d-flex justify-content-between">
                                        <p class="font-xs">{{ $item->ngay_binh_luan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Chưa có bình luận nào.</p>
                    @endforelse
                     <div id="hienbinhluan"></div>
                </div>
            </div>

            <!-- Customer Feedback Summary -->
           <div class="col-lg-4">
                <h4 class="mb-30">Phản hồi khách hàng</h4>
                <div class="d-flex mb-30">
                    <div class="product-rate d-inline-block mr-15">
                        <div class="product-rating" style="width: {{ $avgPercentage }}%;"></div>
                    </div>
                    <h6>{{ $avg }} out of 5</h6>
                </div>
                <input type="hidden" id="id_productcmt" data-id-product="{{ $data->id }}">
                <!-- Star Progress Bars -->
                @foreach(range(5, 1) as $i)
                    <div class="progress">
                        <span>{{ $i }} star</span>
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $count > 0 ? ($starCounts[$i] / $count) * 100 : 0 }}%;"
                            aria-valuenow="{{ $count > 0 ? round(($starCounts[$i] / $count) * 100, 1) : 0 }}"
                            aria-valuemin="0" aria-valuemax="100">
                            {{ $count > 0 ? round(($starCounts[$i] / $count) * 100, 1) : 0 }}%
                        </div>
                    </div>
                @endforeach

            </div>

<style>
    .rating .star {
    font-size: 2rem;
    cursor: pointer;
    color: #ccc;
    transition: color 0.3s;
}

.rating .star:hover,
.rating .star.active {
    color: #f0c040; /* Màu vàng */
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        let selectedRating = 0;


        // Thêm sự kiện click cho các ngôi sao
        stars.forEach((star) => {
            star.addEventListener("click", function () {
                const rating = this.getAttribute("data-value");
                selectedRating = rating;

                // Loại bỏ class 'active' trên tất cả các sao
                stars.forEach((s) => s.classList.remove("active"));

                // Thêm class 'active' cho các sao được chọn
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.add("active");
                }

                console.log(`Bạn đã chọn ${rating} sao.`);
            });
        });

        // Xử lý gửi dữ liệu qua AJAX
        document.querySelector(".button-contactForm").addEventListener("click", function (e) {
            e.preventDefault();

            // Lấy nội dung bình luận
            const comment = document.querySelector("#comment").value;
            const idProductCmt = document.getElementById("id_productcmt").getAttribute("data-id-product");

            // Kiểm tra dữ liệu trước khi gửi
            if (!selectedRating) {
                alert("Vui lòng chọn số sao trước khi gửi bình luận.");
                return;
            }

            if (!comment.trim()) {
                alert("Vui lòng nhập nội dung bình luận.");
                return;
            }

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: "{{ route('web.gui-binh-luan') }}", // Đường dẫn xử lý ở server
                type: "POST",
                data: {
                    rating: selectedRating,
                    comment: comment,
                    id_product: idProductCmt, // ID sản phẩm
                    _token: "{{ csrf_token() }}" // Token bảo mật
                },
                success: function (response) {
                    if (response.success) {
                        // alert("Bình luận của bạn đã được gửi thành công!");
                        // Xóa nội dung form sau khi gửi
                        const newComment = `
                    <div class="single-comment justify-content-between d-flex">
                        <div class="user d-flex">
                            <div class="thumb text-center">
                                <img src="${response.user_image}" alt="User Image" style="height: 80%;">
                                <h6><a href="#">${response.user_name}</a></h6>
                            </div>
                            <div class="desc">
                                <div class="product-rate d-inline-block">
                                   <div class="product-rating" style="width: ${response.rating * 20}%;"></div>
                                </div>
                                <p>${response.comment}</p>
                                <div class="d-flex justify-content-between">
                                    <p class="font-xs">${response.date}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                     document.getElementById("list_comment").insertAdjacentHTML("afterbegin", newComment);
                        document.querySelector("#comment").value = "";
                        stars.forEach((s) => s.classList.remove("active"));
                        selectedRating = 0;
                    } else {
                        alert("Đã xảy ra lỗi khi gửi bình luận. Vui lòng thử lại.");
                    }
                },
                error: function () {
                    alert("Không thể gửi bình luận. Vui lòng kiểm tra kết nối mạng.");
                }
            });
        });
    });
</script>



    <!-- Comment Form -->
    <div class="comment-form">
        <h4 class="mb-15">Bình luận</h4>
        {{-- <form action="{{ route('comments.store') }}" method="POST"> --}}
            {{-- @csrf --}}


        <div class="rating d-inline-block mb-30" id="rating-stars">
            <i class="fas fa-star star" data-value="1"></i>
            <i class="fas fa-star star" data-value="2"></i>
            <i class="fas fa-star star" data-value="3"></i>
            <i class="fas fa-star star" data-value="4"></i>
            <i class="fas fa-star star" data-value="5"></i>
        </div>


            <div class="form-group">
                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="5" placeholder="Viết bình luận" maxlength="50"
                ></textarea>
            </div>
            <button type="submit" class="button button-contactForm">Gửi</button>
        {{-- </form> --}}
    </div>
</div>
