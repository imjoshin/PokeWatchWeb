$(document).on("ready", function(){
  window.initDone = false;

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "scripts/ajax.php",
    data: {
      action: "init",
    },
    cache: false,
    success: function(data) {
      if(data["login"]){
        $(".side-nav").hide();
        $(".navbar-toggle").hide();
        $("#content").html(data["login"]);
      }else{
        $("#regions").html(data["regions"]);
        $("#regions").data("loaded", "1");
      }
      window.initDone = true;
    },
    error: function(xhr, status, error) {

    }
  });

  //Login stuff
  $(document).on("click", '#login-form-link', function(e) {
		$("#login").delay(100).fadeIn(100);
 		$("#register").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$(document).on("click", '#register-form-link', function(e) {
		$("#register").delay(100).fadeIn(100);
 		$("#login").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

  $(document).on("click", "#login-submit", function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "scripts/ajax.php",
      data: {
        action: "login",
        username: $("#username-l").val(),
        password: $("#password-l").val()
      },
      cache: false,
      success: function(data) {
        if(data["error"]){
          alert(data["error"]);
        }else{
          window.location = "http://mtupogo.com";

        }
      },
      error: function(xhr, status, error) {

      }
    });
  });

  $(document).on("click", "#register-submit", function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "scripts/ajax.php",
      data: {
        action: "register",
        username: $("#username-r").val(),
        password: $("#password-r").val(),
        cpassword: $("#confirm-password-r").val(),
        address: $("#address-r").val()
      },
      cache: false,
      success: function(data) {
        if(data["error"]){
          alert(data["error"]);
        }else{
          window.location = "http://mtupogo.com";
        }
      },
      error: function(xhr, status, error) {
        alert("error");
      }
    });
  });

  $(document).on("click", "#signout", function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "scripts/ajax.php",
      data: {
        action: "signout"
      },
      cache: false,
      success: function(data) {
        window.location = "http://mtupogo.com";
      }
    });
  });

  $(document).on("change", ".regionCheck", function(){
    var selected = $(this).prop("checked");
    var region = $(this).data("region");
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "scripts/ajax.php",
      data: {
        action: "updateRegion",
        region: region,
        selected: selected
      },
      cache: false,
      success: function(data) {
        if(data["error"]){
          alert(data["error"]);
        }else{
          if($(".regionWrapper").length > 0 && $(".regionWrapper").data("region") == region){
            if(selected){
              $(".regionWrapper").slideDown(300);
            }else{
              $(".regionWrapper").slideUp(300);
            }
          }
        }
      },
      error: function(xhr, status, error) {
        alert("error");
      }
    });
  });
});
