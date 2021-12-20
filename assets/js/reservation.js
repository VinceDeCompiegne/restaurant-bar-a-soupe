var tabAime = [20];
var tabReserve = [20];
window.addEventListener("load", function (event) {
    chargement()
});

function chargement() {

    for (i = 0; i <= 15; i++) {
        tabAime[i] = 0;
        tabReserve[i] = 0;;
    }

    if (typeof localStorage != "undefined") {

        let tache = JSON.parse(localStorage.getItem("PlatRestaurant"));
        //console.log(tache);

        if (tache == null) {
            document.getElementsByClassName("ReservBouton")[0].disabled=true;
            return;
        };
        document.getElementsByClassName("ReservBouton")[0].disabled=false;
        
        for (index = 1; index <= 15; index++) {
            tabAime[index] = tache["Plat_" + index]["aime"];
            tabReserve[index] = tache["Plat_" + index]["reservation"];
        }

        for (let i = 1; i <= 15; i++) {

            if (tabReserve[i]) {
                let nbrPlat = (isNaN(tache["Plat_" + i]["nombre"])) ? 1 : tache["Plat_" + i]["nombre"];
                nbrPlat = (tache["Plat_" + i]["nombre"] == 0) ? 1 : tache["Plat_" + i]["nombre"];
                image = (tache["Plat_" + i]["nombre"] == "") ? "Bol_Fumant_M.gif" : "/recette/" + tache["Plat_" + i]["image"];
                createPlat(tache["Plat_" + i]["nom"], " X " + nbrPlat);
            }

        }

    } else {
        alert(encodeURI("local Storage non suporte sur ce navigateur !"));
    }

}

function createPlat(titre, nbr) {
    let res1 = document.getElementById("ReservationLigne");
    let art = document.createElement("article");
    art.classList.add("PlatRes");
    art.id = "Plat1";
    res1.appendChild(art);

    let h4 = document.createElement("h4");
    h4.textContent = titre;
    art.appendChild(h4);

    let img = document.createElement("img");
    img.src = "assets/images/"+image;
    img.alt = "Photo Plat 1";
    img.style.maxHeight="200px";
    img.style.maxwidth="200px";
    art.appendChild(img);

    let div = document.createElement("div");
    div.classList.add("BoutonReservation");
    art.appendChild(div);

    let p = document.createElement("p");
    p.classList.add("ResCoeur");
    p.textContent = nbr;
    art.appendChild(p);

}
request = new XMLHttpRequest();

function reservation(reserv) {
    
    let speudo = document.getElementById("speudo");

        if (typeof localStorage != "undefined") {

            let tache = JSON.parse(localStorage.getItem("PlatRestaurant"));
            
            let tab = [];

            for (item in tache) {
                if (tache[item]["reservation"]) {
                    tache[item]["pseudo"]=speudo.value;
                    tache[item]["reserv"]=reserv;
                    tache[item]["id"]=document.getElementById("numTicket").innerHTML;
                    tab.push(tache[item]);
                }
            }
            
            try {
                var str_json = "reservation=" + JSON.stringify(tab);
  
                request.open("GET", "./API/reservation.php?"+str_json, true);
                request.setRequestHeader("Content-type", "application/json");
                request.send();
                console.log(str_json);

                request.onreadystatechange = function() {
                    if ((request.readyState==4) && ((request.status==200)||(request.status==0))){
                        /*On déporte le code de traitement de la réponse 
                        dans la fonction nommée ici Callback*/
                        respond(request.response);
                    }
                }

            } catch (err) {
                console.log(err);
            }

        }
}

var idReservation = null;
var varTimer = 0;
var scrutation = 0;
var boutonDetail = true;
function respond(data) {


        console.log(data);
        //document.getElementById("debug").innerHTML=data;
        let msg = JSON.parse(data);


        document.getElementById("numTicket").innerHTML = msg.id;

        if (boutonDetail){
            document.getElementById("numTicket").innerHTML = msg.id;
            document.getElementById("btn__Annulation").disabled=false;
            document.getElementById("Rsrvation_detail").innerHTML = `<button id="pagRsrv__Dtl" onclick="fonctionAJAX(${msg.id},'${document.getElementById("speudo").value}');" disabled="false">Detail</button>`;       
            document.getElementById("pagRsrv__Dtl").disabled=false;
            boutonDetail = false;
        };
        

        
        if (msg.message!=""){
            document.getElementById("msgTicket").innerHTML = msg.message;
            if((msg.valid!="ok")&&(scrutation=1)){varTimer = setTimeout(reservation(1), 30000);scrutation++;}
        }
        
        if((idReservation != null)&&(idReservation != msg.id)&&(!boutonDetail)){
            if (varTimer != 0){clearTimeout(varTimer)};
            idReservation = null;
            varTimer=0;
            scrutation=0;
            boutonDetail=true;
            document.getElementById("btn__Annulation").disabled=true;
            document.getElementById("pagRsrv__Dtl").disabled =true;
            document.getElementById("numTicket").innerHTML = msg.id;
        };
        if(((varTimer=0)&&(!boutonDetail))||(msg.valid!="")){
            document.getElementById("btn__Annulation").disabled=true;
            document.getElementById("pagRsrv__Dtl").disabled =true;
            document.getElementById("numTicket").innerHTML = msg.id;
        }
        
        idReservation=msg.id;

        if(msg.pseudo!=""){
            document.getElementById("speudo").value = msg.pseudo;
        };
        if (msg.msgError!=""){document.getElementById("test").innerHTML = msg.msgError};

    
}

