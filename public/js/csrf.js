(function( $ ) {

    let csrf = $('#csrf_input');

    console.log( $(csrf).attr('name') );

    //if exist
    if( $(csrf).length != null ){
        let array = {

            'name' : $(csrf).attr('name'),
            'value' : $(csrf).attr('value')
        };
    
        window.localStorage.setItem('csrf', JSON.stringify(array));    
    }else{
        
    }
 

})( jQuery );