@extends('layouts.admin-layout')
@section('noidung')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
<div class=" w-xs-100 chat-container">
                <div class="invoice-inner-part h-100">
                  <div class="invoiceing-box" id="content">
                    <div class="invoice-header d-flex align-items-center border-bottom p-3" >
                      <h4 class=" text-uppercase mb-0">Hóa Đơn</h4>
                      <div class="ms-auto">
                        <h4 class="invoice-number"></h4>
                      </div>
                    </div>
                    <div class="p-3" id="custom-invoice">
                      <div class="invoice-123" id="printableArea" style="display: block;">
                        <div class="row pt-3">
                          <div class="col-md-12">
                            <div>
                              <address>
                                <h6>&nbsp;Bên Gửi,</h6>
                                <h6 class="fw-bold">&nbsp;E Book Tri Thức Việt</h6>
                                <p class="ms-1">

                                  @if(!empty($configData['address']))

                     {{$configData['address']  }}
                       @else
                           vui lòng thêm địa chỉ

                        @endif

                                  <br>   @if(!empty($configData['phone_number']))

                     {{ $configData['phone_number'] }}
                       @else
                           vui lòng thêm số điện thoại

                        @endif
                                </p>
                              </address>
                            </div>
                            <div class="text-end">
                              <address>
                                <h6>Người nhận</h6>
                                <h6 class="fw-bold invoice-customer">
                                 {{  $donhang->user->ten }},
                                </h6>
                                <p class="ms-4">
                                  {{ $donhang->sdt }}
                                  <br>{{ $donhang->dia_chi }}
                                  <br>Mã đơn hàng : {{ $donhang->ma_hoa_don }}
                                </p>
                                <p class="mt-4 mb-1">
                                  <span>Ngày in hóa đơn :</span>
                                  <i class="ti ti-calendar"></i>
                                  {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                </p>
                                <p>
                                  <span>Ngày đặt hàng:</span>
                                  <i class="ti ti-calendar"></i>
                                 {{ $donhang->thoi_gian}}
                                </p>
                              </address>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="table-responsive mt-5">
                              <table class="table table-hover">
                                <thead>
                                  <!-- start row -->
                                  <tr>
                                    <th class="text-center">#</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th class="text-end">Số Lượng</th>
                                    <th class="text-end">Giá</th>
                                    <th class="text-end">Tổng giá</th>
                                  </tr>
                                  <!-- end row -->
                                </thead>
                                <tbody>
                                  <!-- start row -->
                                  {{-- <tr>
                                    <td class="text-center">1</td>
                                    <td>Milk Powder</td>
                                    <td class="text-end">2</td>
                                    <td class="text-end">$24</td>
                                    <td class="text-end">$48</td>
                                  </tr> --}}
                                  @php
                                      $i = 1;
                                  @endphp
                                  @foreach ($donhang->chiTietSanPham as $item )
                                 <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $item->ten_san_pham }}</td>
                                    <td class="text-end">{{ $item->so_luong }}</td>
                                    <td class="text-end">{{ number_format($item->gia, 0, ',', '.') }} VND</td>
                                    <td class="text-end">{{ number_format($item->so_luong * $item->gia, 0, ',', '.') }} VND</td>
                                  </tr>
                                  @endforeach

                                  <!-- end row -->
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="pull-right mt-4 text-end">
                              <p>Tổng số tiền: {{ number_format($donhang->tong_tien, 0, ',', '.') }} VND </p>
                              <p>Phụ thu (0%) : 0</p>
                              <hr>
                              <h3>
                                <b>Tổng :</b> {{ number_format($donhang->tong_tien, 0, ',', '.') }} VND
                              </h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-end no-print">
                              <a class="btn bg-danger-subtle text-danger" href="{{ route('don-hang') }}">
                             Hủy
                              </a>
                              <button onclick="generatePDF()" class="btn btn-primary btn-default print-page ms-6" type="button">
                                <span>
                                  <i class="ti ti-printer fs-5"></i>
                                  Xuất hóa đơn
                                </span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    async function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        var maHoaDon = "{{ $donhang->ma_hoa_don }}";
        var ngayIn = new Date().toISOString().split('T')[0];

        // Ẩn các phần tử không muốn xuất hiện
        document.querySelectorAll(".no-print").forEach(el => el.style.display = "none");

        const content = document.getElementById("content");

        await html2canvas(content, { scale: 2 }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const imgWidth = 190;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
            doc.save("hoa-don-" + maHoaDon + "-" + ngayIn + ".pdf");
        });

        // Hiển thị lại các phần tử sau khi xuất PDF
        document.querySelectorAll(".no-print").forEach(el => el.style.display = "");
    }
</script>

@endsection
