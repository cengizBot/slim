




$('#list_interface_menu li').each(function(){

    let id = $(this).attr('id');

    //effect animate for menu interface

    $(this).mouseover(function(){
       
        
        switch (id) {
            case "rh_icone":

                $("#" + id + "_img").attr("src","/public/img/rhHumainWhite.png");

                break;
        
            case "inventaire_icone":
                $("#" + id + "_img").attr("src","/public/img/rhHumainWhite.png");
                break;
        }

        $(this).animate({
            padding : "+20px",
            backgroundColor : "#967474"
          }, 500, function() {
          
          });
    })

    $(this).mouseleave(function(){

        switch (id) {
            case "rh_icone":

                $("#" + id + "_img").attr("src","/public/img/rhHumainBlack.png");

                break;
        
            case "inventaire_icone":
                $("#" + id + "_img").attr("src","/public/img/rhHumainBlack.png");
                break;
        }

        $(this ).animate({
            padding : "-20px"
          }, 500, function() {
         
          });
    })

})

