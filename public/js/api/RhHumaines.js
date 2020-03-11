(function( $ ) {

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

    let csrf_token = getCookie('csrf_token');


    $("#menu_rh").click(function(){

        // remove all child in header interface and interface_div_display
        $('#interface_div_display').empty();
        $('#header_interface').empty();

        $.get( "./api/Data/GetWorkers.php", function( results ) {

            let datas = JSON.parse(results);
            let count = datas.datas.length;
           
            //div content interface
            let div = $('#interface_div_display');
            //div header interface
            let header = $("#header_interface");


            // btn add employee
            let btn_add_employ = $('<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal_employee">Ajouter un employé</button>');
            // modal employe form
            

            $(header).append(btn_add_employ);
    
            //create ul for employes
            let ul = $('<ul id="display_employes">');
           
            for(var i = 0; i < count; i ++){
    
                //format date ////
                var Time = new Date(datas.datas[i].date_entrer)
  
                var years = Time.getFullYear()
                var month = Time.getMonth() + 1;
                var day = Time.getDate();
   
    
                if(day < 10 ){
    
                    day = "0" + day;
    
                }
    
                if(month < 10){
    
                    month = "0" + month;
    
                }
    
                datas.datas[i].date_entrer = day + "/" + month + "/" + years;
                
    
    
                //ucfirst
                datas.datas[i].name = datas.datas[i].name.charAt(0).toUpperCase() + datas.datas[i].name.slice(1);
                datas.datas[i].firstname = datas.datas[i].firstname.charAt(0).toUpperCase() + datas.datas[i].firstname.slice(1);
                datas.datas[i].email = datas.datas[i].email.charAt(0).toUpperCase() + datas.datas[i].email.slice(1);
                datas.datas[i].fonction = datas.datas[i].fonction.charAt(0).toUpperCase() + datas.datas[i].fonction.slice(1);
    
    
    
                // icone employe
                let img = $('<img src="./public/img/employ.png" style="width: 45px" >');
                //icone fleche
                let fleche_bas = $(`<a data-toggle="collapse" role="button"  aria-controls="collapse_${datas.datas[i].name}" class="none_deco" href="#collapse_${datas.datas[i].name}" ><img class="pointer fleche_margin" id="fleche_bas" src="./public/img/fleche_bas.png" > </a>`);
                let fleche_haut = $(`<a type="button" data-toggle="collapse" data-target="#collapse_${datas.datas[i].name}" aria-expanded="false" aria-controls="collapse_${datas.datas[i].name}" class="none_deco " ><img class="pointer fleche_margin" id="fleche_haut" src="./public/img/fleche_haut.png" ></a>`);
    
                //div more news about employe
                let div_collaspe = $(`<div class="collapse" id="collapse_${datas.datas[i].name}">`);
                let div_collaspe_card = $(`<div class="card card-body">`);
    
                //collapse card div
                let div_collaspe_card_fonction = $(`<div> Fonction : ${datas.datas[i].fonction}</div>`);
                let div_collaspe_card_age = $(`<div>Age : ${datas.datas[i].years}</div>`);
                let div_collaspe_card_date_enter = $(`<div> Date d'entrée : ${datas.datas[i].date_entrer} </div>`);
    
                $(div_collaspe_card).append(div_collaspe_card_fonction,div_collaspe_card_age,div_collaspe_card_date_enter);
    
    
    
                // li of employe
                let li = $(`<li class="puce_none flex_line max_width" id="employe_${datas.datas[i].name}" >`);
    
                let div_name = $(`<div class='style_display_employ div_border_r' id='${datas.datas[i].name}' >`);
                let div_firstname = $(`<div class='style_display_employ div_border_r' id='${datas.datas[i].firstname}' >`);
                let div_email = $(`<div class='style_display_employ' id='${datas.datas[i].email}' >`);
                let div_flech = $(`<div class='style_display_employ' >`);
    
                $( li ).append(img);
    
                // data append txt ////
                $( div_name ).text(`Nom : ${datas.datas[i].name}`);
                $( div_firstname ).text(`Prénom : ${datas.datas[i].firstname}`);
                $( div_email ).text(`Email : ${datas.datas[i].email}`);
                //////////////////////
    
                // append fleche
                $( div_flech ).append(fleche_bas,fleche_haut);
                ////////////////
    
                //append collapse
                $(div_collaspe).append(div_collaspe_card);
    
                // append to template ////////
                $( li ).append(div_name,div_firstname,div_email,div_flech);
                $( ul ).append(li,div_collaspe);
                $(div).append(ul);
                //////////////
    
            }
    
            
        });
    })


})( jQuery );