(function( $ ) {
    
    // change background-color of home '/' and other location to another background

    let body = $("#body_template"); $(body).attr('class','home_template');
    let location = window.location.href;
    let div_container = $('#container_temp');

    
    if(location === "http://localhost:8080/" || location === "http://localhost:8080/#" ){
            console.log('********')
            $(body).attr('class','home_template');

            // check if div have class container
            if( ! $(div_container).hasClass('container') ){

                $(div_container).addClass('container');

            }
        

    }else{

         // remove div class container for better design template 
         // check if div have class container
            if( $(div_container).hasClass('container') ){

                $(div_container).removeClass('container');
                
            }
            
            $(body).attr('class','');
        
    }


})( jQuery );