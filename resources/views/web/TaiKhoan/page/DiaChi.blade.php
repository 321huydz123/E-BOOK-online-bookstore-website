<div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Địa chỉ khách hàng</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <div id="show_dia_chi" style="display: block;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Số thứ tự</th>
                                                                <th>địa chỉ</th>
                                                                <th>Trạng thái</th>
                                                                <th>Đặt làm mặc định</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody_dia_chi">
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                            @foreach ($diachi as $item )
                                                            <tr>                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $item->dia_chi }}</td>
                                                            <td>
                                                                @if($item->trang_thai == 1)
                                                                <span>Địa chỉ chính</span>
                                                            @else
                                                            <span>Ngừng hoạt động</span>
                                                            </td>
                                                            @endif
                                                            <td>

                                                            @if($item->trang_thai == 1)
                                                             Đã chọn
                                                             @else
                                                             <form action="{{ route('web.chon-dia-chi-mac-dinh',$item->id) }}" method="post">
                                                                    @csrf
                                                                     <input type="submit" class="btn btn-danger" value="Chọn">
                                                                </form>

                                                                @endif
                                                            </td>
                                                            </tr>



                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <button id="them" class="btn btn-danger">Thêm địa chỉ</button>
                                                </div>
                                                <form action="{{ route('web.them-dia-chi') }}" method="POST" id="form_dia_chi" style="display: none;">
                                                    @csrf
                                                  <div>
                                                    <select id="city">
                                                        <option value="" selected>Chọn tỉnh thành</option>
                                                    </select>

                                                    <select id="district">
                                                        <option value="" selected>Chọn quận huyện</option>
                                                    </select>

                                                    <select id="ward">
                                                        <option value="" selected>Chọn phường xã</option>
                                                    </select>

                                                    <!-- Thêm input để nhập địa chỉ chi tiết -->
                                                    <input type="text" id="detail-address" placeholder="Nhập địa chỉ chi tiết" style="margin-top: 10px; margin-bottom: 10px;" required>


                                                </div>

                                                <input id="result" name="dia_chi" style="margin-bottom: 10px;" readonly>




                                                  <button type="submit" class="btn btn-danger">Thêm</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
                                                <script>
                                                    const host = "https://provinces.open-api.vn/api/";

                                                    var callAPI = (api) => {
                                                        return axios.get(api)
                                                            .then((response) => {
                                                                renderData(response.data, "city");
                                                            });
                                                    }
                                                    callAPI('https://provinces.open-api.vn/api/?depth=1');

                                                    var callApiDistrict = (api) => {
                                                        return axios.get(api)
                                                            .then((response) => {
                                                                renderData(response.data.districts, "district");
                                                            });
                                                    }

                                                    var callApiWard = (api) => {
                                                        return axios.get(api)
                                                            .then((response) => {
                                                                renderData(response.data.wards, "ward");
                                                            });
                                                    }

                                                    var renderData = (array, select) => {
                                                        let row = ' <option disable value="">Chọn</option>';
                                                        array.forEach(element => {
                                                            row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`
                                                        });
                                                        document.querySelector("#" + select).innerHTML = row;
                                                    }

                                                    $("#city").change(() => {
                                                        callApiDistrict(host + "p/" + $("#city").find(':selected').data('id') + "?depth=2");
                                                        printResult();
                                                    });

                                                    $("#district").change(() => {
                                                        callApiWard(host + "d/" + $("#district").find(':selected').data('id') + "?depth=2");
                                                        printResult();
                                                    });

                                                    $("#ward").change(() => {
                                                        printResult();
                                                    });

                                                    // Thêm sự kiện cho input địa chỉ chi tiết
                                                    $("#detail-address").on('input', () => {
                                                        printResult();
                                                    });

                                                    var printResult = () => {
                                                        if ($("#city").find(':selected').data('id') &&
                                                            $("#district").find(':selected').data('id') &&
                                                            $("#ward").find(':selected').data('id')) {

                                                            // Lấy giá trị từ input địa chỉ chi tiết
                                                            let detailAddress = $("#detail-address").val().trim();

                                                            let result = detailAddress +
                                                                "," + $("#ward option:selected").text() +
                                                                "," + $("#district option:selected").text() +
                                                                "," + $("#city option:selected").text();

                                                            $("#result").val(result);
                                                        }
                                                    }
                                                </script>
