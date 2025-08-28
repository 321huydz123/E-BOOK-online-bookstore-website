
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
<script>
    //  function checkEnter(event) {
    //     if (event.key === 'Enter') {
    //         sendMessage(currentChannel);
    //     }
    // }
    function checkEnter(event) {
    console.log("Phím đã được nhấn:", event.key); // Kiểm tra phím được nhấn
    if (event.key === 'Enter') {
        console.log("Gửi tin nhắn...");
        sendMessage(currentChannel);
    }
}

    var ablyKey = "{{ env('ABLY_API_KEY') }}";
    var ably = new Ably.Realtime.Promise({
        key: ablyKey
     });

      var recipientId = null;
      var currentChannel = null;
      var recipientName = null;
      var recipientImage = null;
      var login_userId = '<?php echo $loggedIn_userId; ?>';
      // console.log(login_userId);
      var UserListApp = $('#conversations-app');
      var UserList = $('#conversations');
    //   var v =document.getElementById('v1');

    //  app
    UserListApp.on('click', 'li', function() {
          recipientId = $(this).attr('data-id');
          recipientName = $(this).attr('data-name');
          recipientImage = $(this).attr('data-img');

          $('#appchat').removeClass('d-none');
          $('#recipient-name-display').text(recipientName);
          $('#recipient-name-display').removeClass('d-none');
          $('#recipient-role-display').removeClass('d-none');
        //   $('#showinput').removeClass('d-none');
        //   $('#border-bottom').addClass('border-bottom');
        //   UserList.find('a').removeClass('selected-user');  // Remove from all anchors
        //   $(this).addClass('selected-user');  // Add to the clicked anchor
          let assetPath = "{{ asset('') }}"; // Lấy đường dẫn gốc từ hàm asset var
          fullImagePath = assetPath + recipientImage; // Ghép đường dẫn gốc với đường dẫn ảnh
          $('#targetImage').attr('src', fullImagePath);

            console.log('Recipient ID: ', recipientId);
        //     console.log('Recipient Name: ', recipientName);
        //     console.log('Recipient img: ', recipientImage);



          $.ajax({
              url: "{{ route('kiem-tra-cuoc-tro-chuyen') }}",
              method: 'GET',
              data: { recipientId: recipientId },
              success: function(response) {
                  if (response.channelExists) {
                      subscribeToChannel(response.channelName);
                    // console.log(response.channelName);


                  } else {
                    //   createNewChannel(recipientId);


                  }
              },
              error: function(xhr, status, error) { console.error(error); }
          });
      });
    // end app


      UserList.on('click', 'li', function() {
          recipientId = $(this).attr('data-id');
          recipientName = $(this).attr('data-name');
          recipientImage = $(this).attr('data-img');

           $('#appchat').removeClass('d-none');
          $('#recipient-name-display').text(recipientName);
          $('#recipient-name-display').removeClass('d-none');
          $('#recipient-role-display').removeClass('d-none');
        //   $('#recipientNameContainer').removeClass('d-none');
        //   $('#recipientimgContainer').removeClass('d-none');
        //   $('#showinput').removeClass('d-none');
        //   $('#border-bottom').addClass('border-bottom');
        //   UserList.find('a').removeClass('selected-user');  // Remove from all anchors
        //   $(this).addClass('selected-user');  // Add to the clicked anchor
          let assetPath = "{{ asset('') }}"; // Lấy đường dẫn gốc từ hàm asset var
          fullImagePath = assetPath + recipientImage; // Ghép đường dẫn gốc với đường dẫn ảnh
          $('#targetImage').attr('src', fullImagePath);

            console.log('Recipient ID: ', recipientId);
        //     console.log('Recipient Name: ', recipientName);
        //     console.log('Recipient img: ', recipientImage);



          $.ajax({
              url: "{{ route('kiem-tra-cuoc-tro-chuyen') }}",
              method: 'GET',
              data: { recipientId: recipientId },
              success: function(response) {
                  if (response.channelExists) {
                      subscribeToChannel(response.channelName);
                    // console.log(response.channelName);


                  } else {
                    //   createNewChannel(recipientId);


                  }
              },
              error: function(xhr, status, error) { console.error(error); }
          });
      });

      function sendMessage(currentChannel) {
          var messageInput = document.getElementById('msg-input');
          var message = messageInput.value.trim();

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
                      oldMessage(msg, recipientName);
                    //   console.log(msg.message_person );

                  });
                  }else{
                //   console.log(5);

                  }

              }
          });

          currentChannel.subscribe(function(message) {
              displayMessage(message, recipientName);
          });
          $('#chat-container').html('');

      }

      function createNewChannel(recipientId) {

      $.ajax({
          url: '{{ route('them-cuoc-tro-chuyen') }}',
          method: 'GET',
          data: { recipientId: recipientId },
          success: function (response) {
              if(response.success == true)

              subscribeToChannel(response.channelName);
              else
              console.log(response.error);
          },

      });
  }

      function displayMessage(messageObject, recipientName) {
        var isLocalSender = messageObject.connectionId == ably.connection.id;

          const chatContainer = $('#chat-container');
            const message1= `<div class="hstack gap-3 align-items-start mb-7 justify-content-end">
                              <div class="text-end">
                                <div class="p-2 bg-info-subtle text-dark rounded-1 d-inline-block fs-3">
                                ${messageObject.data.text}
                                </div>
                              </div>
                            </div>`



         const message2 =` <div class="hstack gap-3 align-items-start mb-7 justify-content-start">
                         <div style="margin-left: 40px;">

                                <div class="p-2 text-bg-light rounded-1 d-inline-block text-dark fs-3">
                                  ${messageObject.data.text}
                                </div>
                              </div>
                            </div>`

          chatContainer.append(isLocalSender ? message1 : message2);
          chatContainer.scrollTop(chatContainer[0].scrollHeight);
      }

      function oldMessage(messageObject, recipientName) {
          var isLocalSender = messageObject.nguoi_gui == login_userId ;
          const chatContainer = $('#chat-container');


        const message2= `<div class="hstack gap-3 align-items-start mb-7 justify-content-end">
                              <div class="text-end">
                                <h6 class="fs-2 text-muted"> ${new Date(messageObject.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })}</h6>
                                <div class="p-2 bg-info-subtle text-dark rounded-1 d-inline-block fs-3">
                                ${messageObject.noi_dung}
                                </div>
                              </div>
                            </div>`



         const message1 =` <div class="hstack gap-3 align-items-start mb-7 justify-content-start">
                            <div style="margin-left: 40px;">

                                <h6 class="fs-2 text-muted">
                                 ${new Date(messageObject.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })}
                                </h6>
                                <div class="p-2 text-bg-light rounded-1 d-inline-block text-dark fs-3">
                                   ${messageObject.noi_dung}
                                </div>
                              </div>
                            </div>`

          chatContainer.append(isLocalSender ? message2 : message1);
          chatContainer.scrollTop(chatContainer[0].scrollHeight);

      }
      $(document).ready(function () {
    $('#text-srh').on('keyup', function () {
        const keyword = $(this).val().toLowerCase();
        $('#conversations li').each(function () {
            const name = $(this).data('ten')?.toLowerCase() || '';
            $(this).toggle(name.includes(keyword));
        });
    });
});

  </script>

