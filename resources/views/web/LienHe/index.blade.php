@extends('layouts.user')
@section('noidung')
 @php
        $loggedIn_userId = auth()->user()->id;

    @endphp
    <style>
        .input-container {
    display: flex;
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 10px; /* Tạo khoảng cách giữa input và button */
    background: #f9f6f6; /* Màu nền nhẹ */
    padding: 10px;
    border-radius: 20px; /* Bo tròn giống Messenger */
}

.input-field {
    flex: 1; /* Giúp input mở rộng hết phần còn lại */
    padding: 10px;
    border: none;
    border-radius: 20px;
    outline: none;
}

.v2 {
    background-color: #0084ff; /* Màu xanh giống Messenger */
    border: none;
    padding: 10px 15px;
    border-radius: 20px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.v2 i {
    font-size: 18px;
}

    </style>
<main class="main" style="background-color: #fff;">

    <body>
        <div class="wrapper">
            <section class="chat-area">
                <header>
                     <a href="users.php" class="back-icon">
                    {{-- <i class="fas fa-arrow-left"></i> --}}
                </a>
                    <img src="https://images2.thanhnien.vn/528068263637045248/2023/4/23/edit-truc-anh-16822518118551137084698.png" alt="">
                <div class="details">
                    <span>Tư Vấn Viên</span>
                    <div></div>
                </div>

                </header>
                <div class="chat-box" id="chat-container">



                </div>
              <div class="input-container">
    <input type="text" onkeypress="checkEnter(event)" id="msg-input" class="input-field" placeholder="Nhập nội dung ở đây...">
    <button class="v2" onclick="sendMessage(currentChannel)">
        <i class="fab fa-telegram-plane"></i>
    </button>
</div>

            </section>
        </div>
    </body>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy tên kênh từ localStorage
        var channelName = localStorage.getItem('channelName');
        console.log(channelName);
        // var recipientImage = localStorage.getItem('recipientImage');

        // var recipientName = localStorage.getItem('recipientName');



        if (channelName){
            // Gọi hàm subscribeToChannel với tên kênh từ localStorage
            subscribeToChannel(channelName);
            localStorage.removeItem('channelName');
            localStorage.removeItem('recipientName');
            localStorage.removeItem('recipientImage');
        }
    });


</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
<script>
     function checkEnter(event) {
        if (event.key === 'Enter') {
            sendMessage(currentChannel);
        }
    }
    var ablyKey = "{{ env('ABLY_API_KEY') }}";
    var ably = new Ably.Realtime.Promise({
        key: ablyKey
    });
var currentChannel = null;

var login_userId = '<?php echo $loggedIn_userId; ?>';
function sendMessage(currentChannel) {
          var messageInput = document.getElementById('msg-input');
          var message = messageInput.value.trim();

        //   console.log('123');
          if (message !== '') {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var baseUrl = '{{ route('luu-tin-nhan') }}';
               var fullUrl = baseUrl.replace(':namechannel',currentChannel.name);

                $.ajax({
                    url: `${fullUrl}`,
                    method: 'POST',
                    data: {
                        ten_cuoc_tro_chuyen: currentChannel.name,
                        nguoi_gui: login_userId,
                        noi_dung: message
                    },
                    success: function(response) {
                        if (response.success) {
                            currentChannel.publish(currentChannel.name, { text: message, sender: 'local' });
                            messageInput.value = '';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                    }
                });
    }

      }




      function subscribeToChannel(channelName) {
                  console.log(5);

        localStorage.setItem('channelName', channelName);
          if (currentChannel) {
              currentChannel.unsubscribe();
          }
          currentChannel = ably.channels.get(channelName);

        var baseUrl = '{{ route('tai-tin-nhan') }}';
        var fullUrl = baseUrl.replace(':channelName',channelName);

          $.ajax({
              url:  `${fullUrl}`,
              method: 'GET',
            data: { name:channelName },


              success: function(response) {

                  if(response.getmessExists){

                  response.messages.forEach((msg) => {
                      oldMessage(msg);
                      console.log(msg);

                  });
                  }else{

                  }

              }
          });

          currentChannel.subscribe(function(message) {
              displayMessage(message);
          });
          $('#chat-container').html('');

      }



      function displayMessage(messageObject) {
        var isLocalSender = messageObject.connectionId == ably.connection.id;

          const chatContainer = $('#chat-container');
            const message1=
                            `<div class="d-flex flex-row justify-content-end">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary"> ${messageObject.data.text}</p>

                    </div>

                  </div>`



         const message2 =`  <div class="d-flex flex-row justify-content-start">
                    <div>
                      <p style="background: #fff" class="small p-2 ms-3 mb-1 rounded-3 "> ${messageObject.data.text}
                      </p>

                    </div>
                  </div>`

          chatContainer.append(isLocalSender ? message1 : message2);
          chatContainer.scrollTop(chatContainer[0].scrollHeight);
      }

      function oldMessage(messageObject) {
          var isLocalSender = messageObject.nguoi_gui == login_userId ;
          const chatContainer = $('#chat-container');


        const message2= `<div class="d-flex flex-row justify-content-end">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary"> ${messageObject.noi_dung}</p>
                      <p class="small me-3 mb-3 rounded-3 text-muted"> ${new Date(messageObject.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })}</p>
                    </div>

                  </div>`




         const message1 = `<div class="d-flex flex-row justify-content-start">

                    <div>
                      <p style="background: #fff" class="small p-2 ms-3 mb-1 rounded-3 "> ${messageObject.noi_dung}
                      </p>
                      <p class="small ms-3 mb-3 rounded-3 text-muted float-end"> ${new Date(messageObject.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })}</p>
                    </div>
                  </div>`

          chatContainer.append(isLocalSender ? message2 : message1);
          chatContainer.scrollTop(chatContainer[0].scrollHeight);

      }
  </script>

@endsection
