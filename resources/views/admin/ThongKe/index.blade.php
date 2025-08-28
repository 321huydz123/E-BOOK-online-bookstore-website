@extends('layouts.admin-layout')
@section('noidung')
<!-- Begin Page Content -->
<div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Biểu đồ thống kê lợi nhuận</h5>
                  </div>
                  <div>
                    <select id="timeFilter" class="form-select">
                      <option value="1">1 Tháng</option>
                      <option value="2">1 Tuần</option>
                      <option value="3">1 Tuần trước</option>
                      <option value="4">1 tháng trước</option>
                    </select>
                  </div>
                </div>
                <div id="chart"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Số lượng sản phẩm</h5>
                    <div class="row align-items-center">
                      <div class="col-8">
                        <h4 class="fw-semibold mb-3">{{ $totalProducts }}
</h4>
                        <div class="d-flex align-items-center mb-3">
                          <span
                            class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                            <i class="ti ti-arrow-up-left text-success"></i>
                          </span>
                          <p class="text-dark me-1 fs-3 mb-0">{{ $newProducts }}</p>
                          <p class="fs-3 mb-0">Sản phẩm mới </p>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="me-4">
                            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2">Mới {{ $newProducts }}</span>
                          </div>
                          <div>
                            <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2">Trước đó {{ $remainingProducts }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-center">
                          <div id="breakup"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold"> Đơn hàng </h5>
                        <h4 class="fw-semibold mb-3">{{ $completedOrders }}</h4>
                        <div class="d-flex align-items-center pb-1">
                           <p class="text-dark me-1 fs-3 mb-0"> Tổng tiền: </p>
                          <p class="text-dark me-1 fs-3 mb-0">{{number_format($totalOrderValue, 0, ',', '.')  }}</p>
                          <p class="fs-3 mb-0">VNĐ</p>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div
                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-currency-dollar fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="earning"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Sản phẩm bán chạy</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tên</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Giá</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Số đơn</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Lợi Nhuận mang về</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                          @foreach($bestSellingProducts as $product)
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ $product->id }}</h6></td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{{ $product->ten_san_pham }}</h6>
                            <span class="fw-normal">Web Designer</span>
                        </td>
                        <td class="border-bottom-0">
                          <p class="mb-0 fw-normal">{{ number_format($product->gia_ban, 0, ',', '.') }} VND</p>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-3 fw-semibold">{{ $product->so_don }}</span>
                          </div>
                        </td>
                        <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 fs-4"> {{ number_format($product->gia_ban * $product->so_don * 0.2, 0, ',', '.') }} VND</h6>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                       <tr>
                         <td colspan="3"><strong>Tổng lợi nhuận:</strong></td>
                         <td><strong>{{ number_format($tongLoiNhuan, 0, ',', '.') }} VND</strong></td>
                       </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

<!-- /.container-fluid -->
@include('admin.ThongKe.page.script')
@endsection
