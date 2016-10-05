$(document).on("ready", function(){

  $("#regions").removeClass('collapse').addClass('open');

  //alert(location.hash);

  $(window).on("hashchange", function(){
    loadRegion(location.hash.substring(1, location.hash.length));
  });

  $(".side-nav").bind("DOMSubtreeModified", function(){
    if($(".region").length < 1) return;

    loadRegion(location.hash.substring(1, location.hash.length));
  });

  function loadRegion(region){
    //alert("Loading " + region);
    var found = false;
    $(".region").each(function(k, v){
      if($(".region").eq(k).attr('id') == region) found = true;
    });
    if(!found){
      return;
    }

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "scripts/ajax.php",
      data: {
        action: "loadRegion",
        region: region
      },
      cache: false,
      success: function(data) {
        if(data["error"]){
          alert(data["error"]);
        }else{
          $("#content").html(data["html"]);
          
        }
      },
      error: function(xhr, status, error) {
        alert("error");
      }
    });
  }
});

$(document).on("click", ".pokemon", function(){
  var pokemon = $(this);

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "scripts/ajax.php",
    data: {
      action: "updatePokemon",
      region: $(this).data("region"),
      pokemon: $(this).data("num"),
      selected: $(this).hasClass("selected")
    },
    cache: false,
    success: function(data) {
      if(data["error"]){
        alert(data["error"]);
      }else{
        pokemon.toggleClass("selected");
      }
    },
    error: function(xhr, status, error) {
      alert("error");
    }
  });
});
