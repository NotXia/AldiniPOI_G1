$(document).ready(function() {

    //------------------------------------------------------------------------------
    //LISTENERS

    /*
   $("#s228").hover(function(){
      rectInHover("228");
   }, function(){
      rectUnHover("228");
   });
   $("#_228").hover(function(){
      rectInHover("228");
   }, function(){
      rectUnHover("228");
   });
   $("#t228").hover(function(){
      rectInHover("228");
   }, function(){
      rectUnHover("228");
   });

    $("#_221").hover(function(){
        rectInHover("221");
        }, function(){
        rectUnHover("221");
        });
    $("#s221").hover(function(){
        rectInHover("221");
        }, function(){
        rectUnHover("221");
        });
    $("#t221").hover(function(){
        rectInHover("221");
        }, function(){
        rectUnHover("221");
        });

    $("#_230").hover(function(){
        rectInHover("230");
        }, function(){
        rectUnHover("230");
        });
    $("#s230").hover(function(){
        rectInHover("230");
        }, function(){
        rectUnHover("230");
        });
    $("#t230").hover(function(){
        rectInHover("230");
        }, function(){
        rectUnHover("230");
        });

    $("#_288").hover(function(){
        rectInHover("288");
        }, function(){
        rectUnHover("288");
        });
    $("#s288").hover(function(){
        rectInHover("288");
        }, function(){
        rectUnHover("288");
        });
    $("#t288").hover(function(){
        rectInHover("288");
        }, function(){
        rectUnHover("288");
        });

    $("#_290").hover(function(){
        rectInHover("290");
        }, function(){
        rectUnHover("290");
        });
    $("#s290").hover(function(){
        rectInHover("290");
        }, function(){
        rectUnHover("290");
        });
    $("#t290").hover(function(){
        rectInHover("290");
        }, function(){
        rectUnHover("290");
        });

    $("#_292").hover(function(){
        rectInHover("292");
        }, function(){
        rectUnHover("292");
        });
    $("#s292").hover(function(){
        rectInHover("292");
        }, function(){
        rectUnHover("292");
        });
    $("#t292").hover(function(){
        rectInHover("292");
        }, function(){
        rectUnHover("292");
        });

    $("#_297b").hover(function(){
        rectInHover("297b");
        }, function(){
        rectUnHover("297b");
        });
    $("#s297b").hover(function(){
        rectInHover("297b");}, function(){
        rectUnHover("297b");});
    $("#t297b").hover(function(){
        rectInHover("297b");
        }, function(){
        rectUnHover("297b");
     });*/

/*
    $("#labs").hover(function(){
        rectInHover("221");
        rectInHover("228");
        rectInHover("230");
        $(".mapbiennio").css("transition", "0.4s");
        $(".mapbiennio").css("opacity", "0.3");
        }, function(){
        rectUnHover("221");
        rectUnHover("228");
        rectUnHover("230");
        $(".mapbiennio").css("opacity", "1");
        });

    $("#labsb").hover(function(){
        rectInHover("288");
        rectInHover("290");
        rectInHover("292");
        rectInHover("297b");
        $(".maptriennio").css("transition", "0.4s");
        $(".maptriennio").css("opacity", "0.3");
        }, function(){
        rectUnHover("288");
        rectUnHover("290");
        rectUnHover("292");
        rectUnHover("297b");
        $(".maptriennio").css("opacity", "1");
        });

    $("#dipartimento").hover(function(){
        rectInHover("221");
        rectInHover("228");
        rectInHover("230");
        rectInHover("288");
        rectInHover("290");
        rectInHover("292");
        rectInHover("297b");
        }, function(){
        rectUnHover("221");
        rectUnHover("228");
        rectUnHover("230");
        rectUnHover("288");
        rectUnHover("290");
        rectUnHover("292");
        rectUnHover("297b");
        });
*/
    //------------------------------------------------------------------------------

    function rectInHover(id) {
        rect_id = "#_" + id;
        text_id = "#t" + id;
        side_id = "#s" + id;
        box_id = "#box_" + id;
        $(box_id).css("transition", "all 0.8s ease");
        $(box_id).css("transform-origin", "center");
        $(box_id).css("transform", "translateX(-5px) translateY(-10px)");
        $(text_id).css("fill", "#fefefe");
        $(rect_id).css("fill", "#3e5cdd");
        $(side_id).css("color", "#111");
        $(side_id).css("margin-right", "15px");
        // obscurePiano();
    }
    function rectUnHover(id) {
        rect_id = "#_" + id;
        text_id = "#t" + id;
        side_id = "#s" + id;
        box_id = "#box_" + id;
        $(box_id).css("transform", "translateX(0) translateY(0)");
        $(text_id).css("fill", "#4c4c4c");
        $(rect_id).css("fill", "#8e8e8e");
        $(side_id).css("color", "#bbb");
        $(side_id).css("margin-right", "0px");
        // lightPiano();
    }

    function obscurePiano() {
        $("#Piano").css("transition", "all 0.8s ease");
        $("#Piano").css("opacity", "0.2");
        $("#Livello_2").css("transition", "all 0.8s ease");
        $("#Livello_2").css("opacity", "0.2");
    }
    function lightPiano() {
        $("#Piano").css("opacity", "1");
        $("#Livello_2").css("opacity", "1");
    }
  });
