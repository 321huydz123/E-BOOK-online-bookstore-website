let showUser = document.getElementById("userShow");
let showPro = document.getElementById("showDH");
let showMD = document.getElementById("ma_don");
let showTT = document.getElementById("trang_thai");
function showDH(id) {
  User(id);
}
function User(vao) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: vao,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/donhang/showUser.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        showUser.innerHTML = response.result;
        pro(vao);
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}

function pro(id) {
  // Lấy thông tin sản phẩm
  madon(id);
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/donhang/showPro.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        showPro.innerHTML = response.result;
        trang_thai(id);
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function madon(id) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };
  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/donhang/showMD.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        showMD.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function trang_thai(id) {
  // Lấy thông tin sản phẩm
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };
  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/donhang/showTT.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        showTT.innerHTML = response.result;

        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function save() {
  // Lấy thông tin sản phẩm
  // Lấy thông tin sản phẩm
  id = "dh" + document.getElementById("idpro").value;
  let tr = document.getElementById(id);
  var productInfo = {
    id: document.getElementById("idpro").value,
    trang_thai: document.getElementById("trang_thai").value,
    ghi_chu: document.getElementById("ghi_chu").value,
    // Thêm thông tin khác nếu cần thiết
  };
  // // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/donhang/update.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        alert("Đổi trạng thái thành công");
        tr.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra");
      }
    }
  };
  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function huy() {
  document.getElementById("idpro").value = "";
  document.getElementById("trang_thai").value = "";
  document.getElementById("ghi_chu").value = "";
}
