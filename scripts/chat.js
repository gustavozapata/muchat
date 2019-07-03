autoScrollChat();

//SEND NEW MESSAGE
$("#elchat form").submit(function() {
  var message = $("#message").val();

  $.post("send.php", { message: message }, function(data) {
    $(".chat-log").append(
      "<div class='yo'>" +
        "<p class='user'>" +
        data[0].firstName +
        " " +
        data[0].lastName +
        "</p>" +
        "<p class='time'>" +
        data[0].time +
        "</p>" +
        "<p class='message'>" +
        data[0].message +
        "</p>" +
        "</div>"
    );
  });

  autoScrollChat();

  $("#message").val("");
  return false;
});

setInterval(fetchNewMessage, 5000);

//FETCH NEW MESSAGE(S)
function fetchNewMessage() {
  $.get("fetch.php", function(data) {
    if (data != null) {
      for (var i = 0; i < data.length; i++) {
        $(".chat-log").append(
          "<div>" +
            "<p class='user'>" +
            data[i].firstName +
            " " +
            data[i].lastName +
            "</p>" +
            "<p class='time'>" +
            data[i].time +
            "</p>" +
            "<p class='message'>" +
            data[i].message +
            "</p>" +
            "</div>"
        );
        autoScrollChat();
      }
    }
  });
}

//SCROLL TO BOTTOM OF PAGE
function autoScrollChat() {
  $("html, body").animate(
    {
      scrollTop: $(".chat-log")[0].scrollHeight
    },
    1000
  );
}

//COMING SOON
//camera
$("#elchat img").on("click", function() {
  $(".coming-soon").toggleClass("coming-soon-open");
  var posY = $(this).offset().top;
  var posX = $(this).offset().left;
  $(".coming-soon").css({
    top: posY - 25 + "px",
    left: posX - 70 + "px"
  });
});

$(".profile-image").on("click", function() {
  $(".coming-soon").toggleClass("coming-soon-open");
  var posY = $(this).offset().top;
  var posX = $(this).offset().left;
  $(".coming-soon").css({
    top: posY + 40 + "px",
    left: posX - 70 + "px"
  });
});
