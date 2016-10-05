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


  }
});
