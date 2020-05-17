$(document).ready(function(){
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
        $("#Piano").css("opacity", "0.3");
    }
    function lightPiano() {
        $("#Piano").css("opacity", "1");
    }
  });
