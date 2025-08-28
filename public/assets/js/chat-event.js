// // Lựa chọn các phần tử DOM
// const form = document.querySelector(".typing-area");
// const inputField = form.querySelector(".input-field");
// const sendBtn = document.getElementById("button");
// const chatBox = document.querySelector(".chat-box");
// // Lấy giá trị incoming_id từ một trường ẩn trong form
// const incoming_id = form.querySelector(".incoming_id").value;

// // Ngăn chặn sự kiện gửi form mặc định
// // form.onsubmit = (e) => {
// //   e.preventDefault();
// // };
// // Cuộn hộp chat xuống dưới cùng để hiển thị tin nhắn mới nhất
// scrollToBottom();
// // Đặt trọng tâm vào trường nhập
// inputField.focus();

// // Sự kiện khi người dùng gõ vào trường nhập
// inputField.onkeyup = () => {
//   if (inputField.value != "") {
//     sendBtn.classList.add("active"); // Thêm class "active" vào nút gửi khi trường nhập không trống
//   } else {
//     sendBtn.classList.remove("active"); // Loại bỏ class "active" khỏi nút gửi khi trường nhập trống
//   }
// };


// // Hàm cuộn xuống dưới cùng của chat box
// function scrollToBottom() {
//   chatBox.scrollTop = chatBox.scrollHeight;
// }
