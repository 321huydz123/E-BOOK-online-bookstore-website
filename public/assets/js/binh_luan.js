function comment() {
  var productInfo = {
    id: document.getElementById("id").value,
    comment: document.getElementById("comment").value,
    // Thêm thông tin khác nếu cần thiết
  };

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "api/comment/add_comment.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Xử lý kết quả từ máy chủ nếu cần
        var response = JSON.parse(xhr.responseText);
        // var response = JSON.parse(xhr.responseText);
        document.getElementById("list_comment").innerHTML = response.result;
        document.getElementById("comment").value = "";
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
