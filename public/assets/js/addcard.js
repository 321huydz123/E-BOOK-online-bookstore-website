const add = document.getElementById("add_card");
const form = document.querySelector(".add_card");
let card = document.getElementById("card");
let table = document.getElementById("tbody");
function addToCart(id) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/card/add_card.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        sum(id);
        alert("Thêm vào giỏ hàng thành công");
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function down(id) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/card/down_card.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        sum(id);
        table.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}

function up(id) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/card/up_card.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        sum(id);
        table.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function dele(id) {
  // Lấy thông tin sản phẩm
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/card/delete_card.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        sum(id);
        table.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function sum(id) {
  var productInfo = {
    id: id,
    // Thêm thông tin khác nếu cần thiết
  };

  // Sử dụng AJAX để gửi dữ liệu đến máy chủ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/card/sum_card.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        card.innerHTML = response.result;
        // Cập nhật nội dung thẻ có id là "card" với dữ liệu từ máy chủ
      } else {
        // Xử lý lỗi nếu có
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng");
      }
    }
  };

  // Chuyển đổi object thành JSON và gửi đi
  xhr.send(JSON.stringify(productInfo));
}
function selectAll() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(function (checkbox) {
    checkbox.checked = true;
  });
}

// Hàm để bỏ chọn tất cả các ô checkbox
function deselectAll() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(function (checkbox) {
    checkbox.checked = false;
  });
}
