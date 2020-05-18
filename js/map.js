$(document).ready(function(){

    //------------------------------------------------------------------------------
    //LISTENERS

    $("#_228").hover(function(){
        rectInHover("228");
        obscurePiano();
        }, function(){
        rectUnHover("228");
        lightPiano();
    });
    $("#s228").hover(function(){
        rectInHover("228");
        obscurePiano();
        }, function(){
        rectUnHover("228");
        lightPiano();
    });
    $("#t228").hover(function(){
        rectInHover("228");
        obscurePiano();
        }, function(){
        rectUnHover("228");
        lightPiano();
    });

    $("#_221").hover(function(){
        rectInHover("221");
        obscurePiano();
        }, function(){
        rectUnHover("221");
        lightPiano();
      });
    $("#s221").hover(function(){
        rectInHover("221");
        obscurePiano();
        }, function(){
        rectUnHover("221");
        lightPiano();
      });
    $("#t221").hover(function(){
        rectInHover("221");
        obscurePiano();
        }, function(){
        rectUnHover("221");
        lightPiano();
      });

    $("#_230").hover(function(){
        rectInHover("230");
        obscurePiano();
        }, function(){
        rectUnHover("230");
        lightPiano();
      });
    $("#s230").hover(function(){
        rectInHover("230");
        obscurePiano();
        }, function(){
        rectUnHover("230");
        lightPiano();
      });
    $("#t230").hover(function(){
        rectInHover("230");
        obscurePiano();
        }, function(){
        rectUnHover("230");
        lightPiano();
      });
    
    $("#_288").hover(function(){
        rectInHover("288");
        obscurePiano();
        }, function(){
        rectUnHover("288");
        lightPiano();
      });
    $("#s288").hover(function(){
        rectInHover("288");
        obscurePiano();
        }, function(){
        rectUnHover("288");
        lightPiano();
      });
    $("#t288").hover(function(){
        rectInHover("288");
        obscurePiano();
        }, function(){
        rectUnHover("288");
        lightPiano();
      });

    $("#_290").hover(function(){
        rectInHover("290");
        obscurePiano();
        }, function(){
        rectUnHover("290");
        lightPiano();
      });
    $("#s290").hover(function(){
        rectInHover("290");
        obscurePiano();
        }, function(){
        rectUnHover("290");
        lightPiano();
      });
    $("#t290").hover(function(){
        rectInHover("290");
        obscurePiano();
        }, function(){
        rectUnHover("290");
        lightPiano();
      });

    $("#_292").hover(function(){
        rectInHover("292");
        obscurePiano();
        }, function(){
        rectUnHover("292");
        lightPiano();
      });
    $("#s292").hover(function(){
        rectInHover("292");
        obscurePiano();
        }, function(){
        rectUnHover("292");
        lightPiano();
      });
    $("#t292").hover(function(){
        rectInHover("292");
        obscurePiano();
        }, function(){
        rectUnHover("292");
        lightPiano();
      });

    $("#_297b").hover(function(){
        rectInHover("297b");
        obscurePiano();
        }, function(){
        rectUnHover("297b");
        lightPiano();
      });
    $("#s297b").hover(function(){
        rectInHover("297b");
        obscurePiano();
        }, function(){
        rectUnHover("297b");
        lightPiano();
      });
    $("#t297b").hover(function(){
        rectInHover("297b");
        obscurePiano();
        }, function(){
        rectUnHover("297b");
        lightPiano();
      });

    $("#labs").hover(function(){
        rectInHover("221");
        rectInHover("228");
        rectInHover("230");
        obscurePiano();
        }, function(){
        rectUnHover("221");    
        rectUnHover("228");
        rectUnHover("230");
        lightPiano();
      });

    $("#labsb").hover(function(){
        rectInHover("288");
        rectInHover("290");
        rectInHover("292");
        rectInHover("297b");
        obscurePiano();
        }, function(){
        rectUnHover("288");    
        rectUnHover("290");
        rectUnHover("292");
        rectUnHover("297b");
        lightPiano();
      });

    $("#dipartimento").hover(function(){
        rectInHover("221");
        rectInHover("228");
        rectInHover("230");
        rectInHover("288");
        rectInHover("290");
        rectInHover("292");
        rectInHover("297b");
        obscurePiano();
        }, function(){
        rectUnHover("221");    
        rectUnHover("228");
        rectUnHover("230");
        rectUnHover("288");    
        rectUnHover("290");
        rectUnHover("292");
        rectUnHover("297b");
        lightPiano();
      });

    //------------------------------------------------------------------------------
    
    function rectInHover(id) {
        rect_id = "#_" + id;
        text_id = "#t" + id;
        side_id = "#s" + id;
        $(text_id).css("transition", "all 0.8s ease");
        $(rect_id).css("transition", "all 0.8s ease");
        $(text_id).css("transform-origin", "center");
        $(text_id).css("transform", "translateX(-14px) translateY(-28px)");
        $(rect_id).css("fill", "blue");
        $(side_id).css("color", "#111");
        $(side_id).css("margin-left", "15px");
        $(side_id).css("border-radius", "0%");
        obscurePiano();
    }
    function rectUnHover(id) {
        rect_id = "#_" + id;
        text_id = "#t" + id;
        side_id = "#s" + id;
        $(text_id).css("transform", "translateX(0) translateY(0)");
        $(rect_id).css("fill", "cyan");
        $(side_id).css("color", "#bbb");
        $(side_id).css("margin-left", "25px");
        $(side_id).css("border-radius", "50%");
        lightPiano();
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
