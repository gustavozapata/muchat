//PWA SERVICE WORKER
window.addEventListener("load", async e => {
  // fetchNewMessage();
  // isUserOnline();

  if ("serviceWorker" in navigator) {
    try {
      navigator.serviceWorker.register("../serviceWorker.js");
      console.log("SW registered");
    } catch (error) {
      console.log("SW registration failed");
    }
  }
});

autoScrollChat();

//SEND NEW MESSAGE
$("#elchat form").submit(function() {
  var message = $("#message").val();
  if (message.trim() != "") {
    $.post("./controller/send.php", { message: message }, function(data) {
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
  }

  autoScrollChat();

  $("#message").val("");
  return false;
});

setInterval(function() {
  fetchNewMessage();
  isUserOnline();
}, 5000);

//FETCH NEW MESSAGE(S)
function fetchNewMessage() {
  $.get("./controller/fetch.php?message=1", function(data) {
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

//CHECK USER ONLINE/OFFLINE
function isUserOnline() {
  $.get("./controller/fetch.php?status=1", function(status) {
    var users = document.querySelectorAll(".users-connected span");
    // isTyping(status);
    for (var i = 0; i < status.length; i++) {
      if (status[i].online != users[i].dataset.on) {
        if (status[i].online == "1") {
          $(".chat-log").append(
            `<div><p class="time connected-msg">${
              status[i].username
            } se ha conectado</p></div>`
          );
        } else {
          $(".chat-log").append(
            `<div><p class="time connected-msg">${
              status[i].username
            } se ha desconectado</p></div>`
          );
        }
        autoScrollChat();
      }
    }

    $(".users-connected p").each(function(j) {
      $(this).html(
        `<span ${
          status[j].online == 1
            ? 'class="connected" data-on="1"'
            : 'data-on="0"'
        }></span>${status[j].username} ${
          status[j].typing == 1 ? '<div id="typing"> typing...</div>' : ""
        }`
      );
    });
  });
}

//USER IS TYPING
$("#message").on("keyup", function(e) {
  if (
    e.keyCode !== 13 &&
    e.keyCode !== 32 &&
    e.keyCode !== 8 &&
    e.keyCode != 46
  ) {
    if (
      $(this)
        .val()
        .trim().length > 2
    ) {
      $.get("./controller/fetch.php?typing=1");
    }
  }
});

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
