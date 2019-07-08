//COMING SOON
//signup
$(".signup a").on("click", function() {
  $(".coming-soon").toggleClass("coming-soon-open");
  var posY = $(this).offset().top;
  var posX = $(this).offset().left;
  $(".coming-soon").css({
    top: posY - 25 + "px",
    left: posX + 25 + "px"
  });
});

//LOGIN CHANGE STATUS
$("#input-username").on("keyup", function() {
  if ($(this).val().length > 1) {
    $("#statusIcon").text("🦁");
    $("#statusText").text("Nice username");
  } else {
    $("#statusIcon").text("💬");
    $("#statusText").text("Let us log in");
  }
});
$("#input-password").on("keyup", function() {
  if ($(this).val().length > 1) {
    $("#statusIcon").text("🙈");
    $("#statusText").text("Oops!");
  } else {
    $("#statusIcon").text("🦁");
    $("#statusText").text("Nice username");
  }
});
