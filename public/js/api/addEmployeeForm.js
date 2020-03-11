(function( $ ) {

    let string_r =  /^[a-zA-Z]*$/;
    let stringSpace_r =  /^[a-zA-Z ]*$/;
    let email_r = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let int_r = /^[0-9]*$/;
    let date_picker_r = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/;

    let form = $('#add_employee_form');

  $(document).submit('#add_employee_form',function(){
       
    let name = $('#name_input');
    let firstname = $('#firstname_input');
    let email = $('#email_input');
    let fonction = $('#fonction_input');
    let city = $('#ville_input');
    let years = $('#years_input');
    let date_enter = $('#enter_date');

    let error = 0;
    let array_input = [name,firstname,email,fonction,city,years,date_enter];

    // let csrf_array = window.localStorage.getItem('csrf') != null ? window.localStorage.getItem('csrf') : "";

    // // csrf does not exist, a redirect to "/" because home page reinitialize the localstorage csrf
    // if( csrf_array.length === 0 ){
    //   var newURL = window.location.protocol + "//" + window.location.host;
    //   return window.location.href = newURL + "/";
      
    // }

    // let csrf_parse = JSON.parse(csrf_array);

    
    for (var item in array_input) {
       
      let input = array_input[item];
      // <small> display error in forms for input
      let small = $('#check_' + $(input).attr('name')  + "_input");
      $(small).empty();

      //remove class input error or success background
      if($(input).hasClass('input_error')){
        $(input).removeClass('input_error');
      }
      if($(input).hasClass('input_success')){
        $(input).removeClass('input_success');
      }

      //if length null 
      if($(input).val().length === 0)
      {

       console.log(this);
       // add form error msg in <small>  
       $(small).text('Erreur champ vide');
       $(input).addClass('input_error');
       error ++;

      }else{

        switch ( $(input).attr('name') ) {

          case "name":

              if(!string_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;

              }else{
                $(input).addClass('input_success');
              }
              
              break;
          
          case "firstname":
             
              if(!string_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
            
              break;

          case "email":
             
              if(!email_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
            
              break;
          case "ville":

              if(!stringSpace_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
              
              break;

          case "fonction":

              if(!string_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
              
              break;

          case "years":

              if(!int_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
              
              break;

          case "enter_date":

              if(!date_picker_r.test($(input).val())){

                $(small).text('Erreur champ incorrect');
                $(input).addClass('input_error');
                error ++;
              }else{
                $(input).addClass('input_success');
              }
              
              break;
        }

      }

    }

    if(error === 0){

      

    }else{
      event.preventDefault();
    }
  
    


  });



})( jQuery );