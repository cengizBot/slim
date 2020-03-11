

let inscription = $('#form_inscription_home');
let connexion = $('#form_connexion_home');
let display_inputs = $('#display_inputs');
let form = $('#form_client');
let btn = $('#form_client button');
// div have child error or success msg to form submit "/"
let interface_submit_msg = $('#interface_submit_client_inscription');

// get cookie 
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

// get the cookie if exist for go to automatically connexion form
// create a false client click in button connexion
let error_conn_user = getCookie('INTCONN');



$(inscription).click(function(){

    if($('#title_form').text() != "Formulaire d'inscription" ){

        $('#title_form').text("Formulaire d'inscription");

    }

    //change title of form h4
    if($('#title_form').text() )


    if($(interface_submit_msg).attr('id') != "interface_submit_client_inscription" ){
        $(interface_submit_msg).attr('id', 'interface_submit_client_inscription');
        $(interface_submit_msg).empty();
    }


    $(form).attr('action','/inscription');

    let div = $("<div class='form-group' id='samepassword_champ'>");
    let label_email = $('<label for="exampleInputPassword1">Same Password</label>');
    let input_email = $('<input type="password" name="samepassword" class="form-control" id="samepassword" placeholder="Same Password">');
    let small_msg = $('<small id="error_samepassword" class="form-text text-muted"></small>');

    let check = $(display_inputs).children('#samepassword_champ');

    if(check.length === 0){
        // create new element samepassword for form if empty
        $(div).append(label_email);
        $(div).append(input_email);
        $(div).append(small_msg);
     
        $(display_inputs).append(div);

    }

    if( $(btn).text() != "inscription" ){
        $(btn).text('Inscription');
    }


    

})

$(connexion).click(function(){

    if($('#title_form') != "Formulaire de connexion" ){

        $('#title_form').text("Formulaire de connexion");

    }

    if($(interface_submit_msg).attr('id') != "interface_submit_client_connexion" ){
        $(interface_submit_msg).attr('id', 'interface_submit_client_connexion');
        $(interface_submit_msg).empty();
    }
    
    $(form).attr('action','/connexion')

    $('#samepassword_champ').hide(1500, function () {
        $('#samepassword_champ').remove();
        
    });
 
    
    if( $(btn).text() != "connexion" ){
        $(btn).text('Connexion');
    }

})



if(error_conn_user){

    // add if to div parent contains error or success msg to client ofrm submit
    // why this? because the user click on the connection button and fail conn to the server
    //the attribute of the parent div to the error or success and connection renewal interface_submit_client_connexion
    $(interface_submit_msg).attr('id', 'interface_submit_client_connexion');

    //click jquery on button to go conn form 
    $('#form_connexion_home').click();
    //delete cookie after client conn error
    document.cookie = "INTCONN=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
 
}
