$(document).ready(function(){

    //------------------------------------------------------------------------------
    //LISTENERS

    $("#_228").hover(function(){
        rectInHover("228");
        }, function(){
        rectUnHover("228");
    });
    $("#s228").hover(function(){
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
        });

    $("#labs").hover(function(){
        rectInHover("221");
        rectInHover("228");
        rectInHover("230");
        }, function(){
        rectUnHover("221");    
        rectUnHover("228");
        rectUnHover("230");
        });

    $("#labsb").hover(function(){
        rectInHover("288");
        rectInHover("290");
        rectInHover("292");
        rectInHover("297b");
        }, function(){
        rectUnHover("288");    
        rectUnHover("290");
        rectUnHover("292");
        rectUnHover("297b");
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
