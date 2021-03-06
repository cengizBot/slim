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
        console.log('kkkkk')
        // remove all child in header interface and interface_div_display
        $('#interface_div_display').empty();
        $('#header_interface').empty();
        $('#pagination').empty();


        $.get( "./api/Data/GetWorkers.php", function( results ) {

            let datas = JSON.parse(results);
       
            let count = datas.datas.length;
           
            //div content interface
            let div = $('#interface_div_display');
            //div header interface
            let header = $("#header_interface");
            
            //use for get int of page pagination
            let numPagination;

            // btn add employee
            let btn_add_employ = $('<button id="ddddd" style="display:inline-block;" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal_employee">Ajouter un employé</button>');
            //search barre employee
            let search_bar = $('<input style="display:inline-block;width:300px;margin-left:20px;margin-top:10px" id="search_employee" class="form-control" placeholder="Recherche par nom ...">');
            
            $(header).append(btn_add_employ,search_bar);
    
            //create ul for employes
            let ul = $('<ul id="display_employes">');


            //array to pagination
            let ArrayPagination = [];


                // start pagination ///
                // 6 is the maximum default number of employees to display in interface

                function TestInt(x) {
                    if (!Number.isInteger(x)) {
                      // not decimal
                      return false;
                    }
                    // decimal
                    return true;
                }

                numPagination = count/6;
                let k = TestInt(numPagination);
                
                if(k === false){
                    numPagination = Math.round(numPagination) + 1;
                }

                      
            function ReturnDataPag(x){

                let array = [];
                let k = x * 6;
                let j = k + 6;
                for(var i = k ; i < j; i ++){
                    if(datas.datas[i] === undefined){
                        return array;
                    }
                    array.push(datas.datas[i]);

                }

                return array;

            }

            for(let x = 0; x < numPagination; x ++ ){
                   
                    let Pag = {

                        "array" : x,
                        "datas" : ReturnDataPag(x)

                    };

                    ArrayPagination.push(Pag);
            }

        
            for(var i = 0; i < 6; i ++){
    
                //format date //
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
                let fleche_bas = $(`<a data-toggle="collapse" role="button"  aria-controls="collapse_${datas.datas[i].name}_${datas.datas[i].id}" class="none_deco" href="#collapse_${datas.datas[i].name}_${datas.datas[i].id}" ><img class="pointer fleche_margin" id="fleche_bas" src="./public/img/fleche_bas.png" > </a>`);
                let fleche_haut = $(`<a type="button" data-toggle="collapse" data-target="#collapse_${datas.datas[i].name}_${datas.datas[i].id}" aria-expanded="false" aria-controls="collapse_${datas.datas[i].name}_${datas.datas[i].id}" class="none_deco " ><img class="pointer fleche_margin" id="fleche_haut" src="./public/img/fleche_haut.png" ></a>`);
    
                //div more news about employee
                let div_collaspe = $(`<div class="collapse" id="collapse_${datas.datas[i].name}_${datas.datas[i].id}">`);
                let div_collaspe_card = $(`<div class="card card-body">`);
    
                //collapse card div
                let div_collaspe_card_fonction = $(`<div> Fonction : ${datas.datas[i].fonction}</div>`);
                let div_collaspe_card_age = $(`<div>Age : ${datas.datas[i].years}</div>`);
                let div_collaspe_card_date_enter = $(`<div> Date d'entrée : ${datas.datas[i].date_entrer} </div>`);

                //icone data
                let info = $(`<a style="float:right" href ="/employe/${datas.datas[i].id}"><img style="float:right" src="./public/img/info.png" id="user_info_${datas.datas[i].id}"></a>`);

    
                $(div_collaspe_card).append(div_collaspe_card_fonction,div_collaspe_card_age,div_collaspe_card_date_enter,info);
    
    
    
                // li of employee
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

                //// append to template //////////////////
                $( li ).append(div_name,div_firstname,div_email,div_flech);
                $( ul ).append(li,div_collaspe);
                // display in interface
                $(div).append(ul);
                //////////////
                ////////////////////////////////////////

            //end for
            }

            // add pagination boots to template
            let divPagination = $('#pagination');
            let navPagination = $('<nav aria-label="Page navigation example">');
            let ulPagination = $('<ul class="pagination">');
     
            for(let g = 0; g < numPagination; g ++){

                let liPagination = $(`<li class="page-item"><a id='paginationPageInterface' value="${g}" class="page-link" href="#">${g}</a></li>`);
                $(ulPagination).append(liPagination);
                $(navPagination).append(ulPagination);

                divPagination.append(navPagination);
            }


            $("#pagination a").on('click',function(){
                let pageNum = $(this).attr('value');
                $(div).empty();
                paginationData(pageNum);
            });

            function paginationData(x){
                
                let arrayDatas = ArrayPagination[parseInt(x)].datas;
                
                for(var i = 0; i < 6; i ++){

                        let PagUl = $('<ul id="display_employes">');
            
                        //format date //
                        var Time_ = new Date(arrayDatas[i].date_entrer)
        
                        var years_ = Time.getFullYear()
                        var month_ = Time.getMonth() + 1;
                        var day_ = Time.getDate();
        
            
                        if(day_ < 10 ){
            
                            day_ = "0" + day;
            
                        }
            
                        if(month_ < 10){
            
                            month_ = "0" + month;
            
                        }
            
                        arrayDatas[i].date_entrer = day_ + "/" + month_ + "/" + years_;
                        
                        //ucfirst
                        arrayDatas[i].name = arrayDatas[i].name.charAt(0).toUpperCase() + arrayDatas[i].name.slice(1);
                        arrayDatas[i].firstname = arrayDatas[i].firstname.charAt(0).toUpperCase() + arrayDatas[i].firstname.slice(1);
                        arrayDatas[i].email = arrayDatas[i].email.charAt(0).toUpperCase() + arrayDatas[i].email.slice(1);
                        arrayDatas[i].fonction = arrayDatas[i].fonction.charAt(0).toUpperCase() + arrayDatas[i].fonction.slice(1);
            
                        // icone employe
                        let img_ = $('<img src="./public/img/employ.png" style="width: 45px" >');
                        //icone fleche
                        let fleche_bas_ = $(`<a data-toggle="collapse" role="button"  aria-controls="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" class="none_deco" href="#collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" ><img class="pointer fleche_margin" id="fleche_bas" src="./public/img/fleche_bas.png" > </a>`);
                        let fleche_haut_ = $(`<a type="button" data-toggle="collapse" data-target="#collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" aria-expanded="false" aria-controls="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" class="none_deco " ><img class="pointer fleche_margin" id="fleche_haut" src="./public/img/fleche_haut.png" ></a>`);
            
                        //div more news about employee
                        let div_collaspe_ = $(`<div class="collapse" id="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}">`);
                        let div_collaspe_card_ = $(`<div class="card card-body">`);
            
                        //collapse card div
                        let div_collaspe_card_fonction_ = $(`<div> Fonction : ${arrayDatas[i].fonction}</div>`);
                        let div_collaspe_card_age_ = $(`<div>Age : ${arrayDatas[i].years}</div>`);
                        let div_collaspe_card_date_enter_ = $(`<div> Date d'entrée : ${arrayDatas[i].date_entrer} </div>`);

                        //icone data
                        let info_ = $(`<a style="float:right" href ="/employe/${arrayDatas[i].id}"><img style="float:right" src="./public/img/info.png" id="user_info_${datas.datas[i].id}"></a>`);

                        $(div_collaspe_card_).append(div_collaspe_card_fonction_,div_collaspe_card_age_,div_collaspe_card_date_enter_,info_);
        
                        // li of employee
                        let li_ = $(`<li class="puce_none flex_line max_width" id="employe_${arrayDatas[i].name}" >`);
            
                        let div_name_ = $(`<div class='style_display_employ div_border_r' id='${arrayDatas[i].name}' >`);
                        let div_firstname_ = $(`<div class='style_display_employ div_border_r' id='${arrayDatas[i].firstname}' >`);
                        let div_email_ = $(`<div class='style_display_employ' id='${arrayDatas[i].email}' >`);
                        let div_flech_ = $(`<div class='style_display_employ' >`);
            
                        $( li_ ).append(img_);
            
                        // data append txt ////
                        $( div_name_ ).text(`Nom : ${arrayDatas[i].name}`);
                        $( div_firstname_ ).text(`Prénom : ${arrayDatas[i].firstname}`);
                        $( div_email_ ).text(`Email : ${arrayDatas[i].email}`);
                        //////////////////////
            
                        // append fleche
                        $( div_flech_ ).append(fleche_bas_,fleche_haut_);
                        ////////////////
            
                        //append collapse
                        $(div_collaspe_).append(div_collaspe_card_);

                        //// append to template //////////////////
                        $( li_ ).append(div_name_,div_firstname_,div_email_,div_flech_);
                        $( PagUl ).append(li_,div_collaspe_);
                        // display in interface
                        $(div).append(PagUl);
                        //////////////
                        ////////////////////////////////////////

                    // //end for
                }

            }


                //search barr                 
                $("#search_employee").keyup(function(){
                    
                    let val = $("#search_employee").val();
                    $("#interface_div_display").empty();
                    console.log(val);


                    $.ajax({
                        type: "POST",
                        url: './api/Data/Search.php',
                        dataType: "html",
                        data: `search=${val}`,
                        success: function(data){
                            let datas = JSON.parse(data);
                            let count = datas.datas.length;
                            console.log(datas);
                            console.log(count);
                            
                            if($("#search_employee").val() === ""){
                                paginationData(0);
                                return false;
                            }


                            let arrayDatas = datas.datas

                            for(var i = 0; i < count; i ++){

                                

                                let PagUl = $('<ul id="display_employes">');
                    
                                //format date //
                                var Time_ = new Date(arrayDatas[i].date_entrer)
                
                                var years_ = Time.getFullYear()
                                var month_ = Time.getMonth() + 1;
                                var day_ = Time.getDate();
                
                    
                                if(day_ < 10 ){
                    
                                    day_ = "0" + day;
                    
                                }
                    
                                if(month_ < 10){
                    
                                    month_ = "0" + month;
                    
                                }
                    
                                arrayDatas[i].date_entrer = day_ + "/" + month_ + "/" + years_;
                                
                                //ucfirst
                                arrayDatas[i].name = arrayDatas[i].name.charAt(0).toUpperCase() + arrayDatas[i].name.slice(1);
                                arrayDatas[i].firstname = arrayDatas[i].firstname.charAt(0).toUpperCase() + arrayDatas[i].firstname.slice(1);
                                arrayDatas[i].email = arrayDatas[i].email.charAt(0).toUpperCase() + arrayDatas[i].email.slice(1);
                                arrayDatas[i].fonction = arrayDatas[i].fonction.charAt(0).toUpperCase() + arrayDatas[i].fonction.slice(1);
                    
                                // icone employe
                                let img_ = $('<img src="./public/img/employ.png" style="width: 45px" >');
                                //icone fleche
                                let fleche_bas_ = $(`<a data-toggle="collapse" role="button"  aria-controls="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" class="none_deco" href="#collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" ><img class="pointer fleche_margin" id="fleche_bas" src="./public/img/fleche_bas.png" > </a>`);
                                let fleche_haut_ = $(`<a type="button" data-toggle="collapse" data-target="#collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" aria-expanded="false" aria-controls="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}" class="none_deco " ><img class="pointer fleche_margin" id="fleche_haut" src="./public/img/fleche_haut.png" ></a>`);
                    
                                //div more news about employee
                                let div_collaspe_ = $(`<div class="collapse" id="collapse_${arrayDatas[i].name}_${arrayDatas[i].id}">`);
                                let div_collaspe_card_ = $(`<div class="card card-body">`);
                    
                                //collapse card div
                                let div_collaspe_card_fonction_ = $(`<div> Fonction : ${arrayDatas[i].fonction}</div>`);
                                let div_collaspe_card_age_ = $(`<div>Age : ${arrayDatas[i].years}</div>`);
                                let div_collaspe_card_date_enter_ = $(`<div> Date d'entrée : ${arrayDatas[i].date_entrer} </div>`);
        
                                //icone data
                                let info_ = $(`<a style="float:right" href ="/employe/${arrayDatas[i].id}"><img style="float:right" src="./public/img/info.png" id="user_info_${datas.datas[i].id}"></a>`);
        
                                $(div_collaspe_card_).append(div_collaspe_card_fonction_,div_collaspe_card_age_,div_collaspe_card_date_enter_,info_);
                
                                // li of employee
                                let li_ = $(`<li class="puce_none flex_line max_width" id="employe_${arrayDatas[i].name}" >`);
                    
                                let div_name_ = $(`<div class='style_display_employ div_border_r' id='${arrayDatas[i].name}' >`);
                                let div_firstname_ = $(`<div class='style_display_employ div_border_r' id='${arrayDatas[i].firstname}' >`);
                                let div_email_ = $(`<div class='style_display_employ' id='${arrayDatas[i].email}' >`);
                                let div_flech_ = $(`<div class='style_display_employ' >`);
                    
                                $( li_ ).append(img_);
                    
                                // data append txt ////
                                $( div_name_ ).text(`Nom : ${arrayDatas[i].name}`);
                                $( div_firstname_ ).text(`Prénom : ${arrayDatas[i].firstname}`);
                                $( div_email_ ).text(`Email : ${arrayDatas[i].email}`);
                                //////////////////////
                    
                                // append fleche
                                $( div_flech_ ).append(fleche_bas_,fleche_haut_);
                                ////////////////
                    
                                //append collapse
                                $(div_collaspe_).append(div_collaspe_card_);
        
                                //// append to template //////////////////
                                $( li_ ).append(div_name_,div_firstname_,div_email_,div_flech_);
                                $( PagUl ).append(li_,div_collaspe_);
                                // display in interface
                                $(div).append(PagUl);
                                //////////////
                                ////////////////////////////////////////
        
                            // //end for
                        }

                        },
                        error: function(){
                            
                            console.log("error");
                        }
                      
                    });

                })


              
        });

    })


    
    if(getCookie('Menu')){
        console.log('+++++++++++++');
        console.log($('#menu_rh'));

        $('#menu_rh').click();
        document.cookie = 'Menu=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

    }



})( jQuery );