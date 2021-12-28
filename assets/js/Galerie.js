var plat = new Array();
var tab = {
    Plat_1: {
        nom: "Soupe 1",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*  nutriScore : {
              energy: 600, //KJ
              fibers: 4, //g   
              fruit_percentage: 25, //%
              proteins: 2, //g
              saturated_fats: 20, //g
              sodium: 500, //mg
              sugar: 10 //g
          }*/
    },
    Plat_2: {
        nom: "Soupe 2",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*  nutriScore : {
              energy: 450, //KJ
              fibers: 4, //g   
              fruit_percentage: 60, //%
              proteins: 20, //g
              saturated_fats: 10, //g
              sodium: 350, //mg
              sugar: 10 //g
          }*/
    },
    Plat_3: {
        nom: "Soupe 3",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 103, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_4: {
        nom: "Soupe 4",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 50, //KJ
                fibers: 4, //g   
                fruit_percentage: 80, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 250, //mg
                sugar: 10 //g
            }*/
    },
    Plat_5: {
        nom: "Soupe 5",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*     nutriScore : {
                 energy: 105, //KJ
                 fibers: 4, //g   
                 fruit_percentage: 60, //%
                 proteins: 2, //g
                 saturated_fats: 2, //g
                 sodium: 500, //mg
                 sugar: 10 //g
             }*/
    },
    Plat_6: {
        nom: "Soupe 6",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 106, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_7: {
        nom: "Soupe 7",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 107, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_8: {
        nom: "Soupe 8",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 108, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_9: {
        nom: "Soupe 9",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*     nutriScore : {
                 energy: 109, //KJ
                 fibers: 4, //g   
                 fruit_percentage: 60, //%
                 proteins: 2, //g
                 saturated_fats: 2, //g
                 sodium: 500, //mg
                 sugar: 10 //g
             }*/
    },
    Plat_10: {
        nom: "Soupe 10",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 110, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_11: {
        nom: "Soupe 11",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 112, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_12: {
        nom: "Soupe 12",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*   nutriScore : {
               energy: 113, //KJ
               fibers: 4, //g   
               fruit_percentage: 60, //%
               proteins: 2, //g
               saturated_fats: 2, //g
               sodium: 500, //mg
               sugar: 10 //g
           }*/
    },
    Plat_13: {
        nom: "Soupe 13",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 114, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_14: {
        nom: "Soupe 14",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*    nutriScore : {
                energy: 115, //KJ
                fibers: 4, //g   
                fruit_percentage: 60, //%
                proteins: 2, //g
                saturated_fats: 2, //g
                sodium: 500, //mg
                sugar: 10 //g
            }*/
    },
    Plat_15: {
        nom: "Soupe 15",
        nombre: 1,
        aime: 0,
        reservation: 0,
        /*   nutriScore : {
               energy: 116, //KJ
               fibers: 4, //g   
               fruit_percentage: 60, //%
               proteins: 2, //g
               saturated_fats: 2, //g
               sodium: 500, //mg
               sugar: 10 //g
           }*/
    },
};


var nutri_Score = [];
var tabAime = [20];
var tabReserve = [20];
var tabselect = [20];
var tabImage = [20];
/************************************ Bouton AIME *********************************/

window.addEventListener("load", function (event) {

    FonctionAJAXImage();
    chargement();


});

function checkAime(index) {

    let coeur = document.getElementsByClassName("coeur")[index - 1];
    coeur.children.item("i").classList.toggle("fa-heart-o");
    coeur.children.item("i").classList.toggle("fa-heart");
    tabAime[index - 1] = coeur.children.item("i").classList.contains("fa-heart") ? 1 : 0;

    sauvegarde()

}

function checkReserv(index) {

    let coeur = document.getElementsByClassName("Reserver")[index - 1];
    coeur.children.item("i").classList.toggle("fa-square-o");
    coeur.children.item("i").classList.toggle("fa-check-square-o");
    tabReserve[index - 1] = (coeur.children.item("i").classList.contains("fa-check-square-o")) ? 1 : 0;

    document.getElementsByName("choixPlat" + index)[0].liste.value = tabReserve[index - 1] ? document.getElementsByName("choixPlat" + index)[0].liste.value : 1;
    tabselect[index - 1] = document.getElementsByName("choixPlat" + index)[0].liste.value;

    document.getElementsByClassName("Gal__liste")[index - 1].style.visibility = (coeur.children.item("i").classList.contains("fa-check-square-o")) ? "visible" : "hidden";
    sauvegarde()

}

function selected(index) {

    tabselect[index - 1] = document.getElementsByName("choixPlat" + index)[0].liste.value;
    sauvegarde()
}

let indice = 0;
let tache = null;
let varEnergy, varFibers, varFruit_percentage, varSaturated_fats, varProteins, varSodium, varSugar;



function chargement() {



    for (i = 0; i <= document.getElementsByTagName("H4").length; i++) {
        tabAime[i] = 0;
        tabReserve[i] = 0;;
    }

    if (typeof localStorage != "undefined") {

        let tache = JSON.parse(localStorage.getItem("PlatRestaurant"));

        for (let item in tache) {
            indice++;
        }

        for (index = 0; index < document.getElementsByTagName("H4").length; index++) {

            for (k = 1; k <= indice; k++) {

                if (document.getElementsByTagName("H4")[index].textContent == (tache["Plat_" + k]["nom"])) {


                    tabAime[index] = (isNaN(tache["Plat_" + k]["aime"])) ? 0 : tache["Plat_" + k]["aime"];
                    tabReserve[index] = (isNaN(tache["Plat_" + k]["reservation"])) ? 0 : tache["Plat_" + k]["reservation"];
                    tabselect[index] = (isNaN(tache["Plat_" + k]["nombre"])) ? 0 : tache["Plat_" + k]["nombre"];
                    tabImage[index] = tache["Plat_" + k]["image"];
                }

            }

        }

        for (let i = 0; i < document.getElementsByClassName("coeur").length; i++) {

            if (tabAime[i]) {

                let coeur = document.getElementsByClassName("coeur")[i];
                coeur.children.item("i").classList.toggle("fa-heart-o");
                coeur.children.item("i").classList.toggle("fa-heart");
            }

        }
        for (let i = 0; i < document.getElementsByClassName("Reserver").length; i++) {

            if (tabReserve[i]) {

                let coeur = document.getElementsByClassName("Reserver")[i];
                coeur.children.item("i").classList.toggle("fa-square-o");
                coeur.children.item("i").classList.toggle("fa-check-square-o");
                document.getElementsByClassName("Gal__liste")[i].style.visibility = "visible";
                document.getElementsByName("choixPlat" + (i + 1))[0].liste.value = (tabselect[i] == 0) ? 1 : tabselect[i];
            }

        }
        
        FonctionAJAX();


    } else {
        alert(encodeURI("local Storage non suporte sur ce navigateur !"));
    }

}

function FonctionAJAX() {
    
    var xhr = new XMLHttpRequest;
    
    xhr.open("GET", `/site/restaurant-bar-a-soupe/API/nutriscore.php?nom=all`, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            var dataAJAX = JSON.parse(xhr.response);

            for (item in dataAJAX) {

                index = item;

                if (dataAJAX[item].nom == document.getElementsByTagName("H4")[index].textContent) {

                    let nutriScoreResult = nutriScore.nutriScore.calculateClass({
                            energy: dataAJAX[item].energy,
                            fibers: dataAJAX[item].fibers,
                            fruit_percentage: dataAJAX[item].fruit_percentage,
                            proteins: dataAJAX[item].Plat_1proteins,
                            saturated_fats: dataAJAX[item].saturated_fats,
                            sodium: dataAJAX[item].sodium,
                            sugar: dataAJAX[item].sugar
                        },
                        "solid"
                    );

                let art = document.getElementsByClassName("img")[index];
                art.src = `assets/images/nutriscore_${nutriScoreResult}.png`;
                        
                }
            }
        }
    }
}



function sauvegarde() {

    for (index = 0; index < document.getElementsByTagName("H4").length; index++) {
        tab["Plat_" + (index + 1)]["nom"] = document.getElementsByTagName("H4")[index].textContent;
        tab["Plat_" + (index + 1)]["aime"] = tabAime[index];
        tab["Plat_" + (index + 1)]["reservation"] = tabReserve[index];
        tab["Plat_" + (index + 1)]["nombre"] = tabselect[index];
        tab["Plat_" + (index + 1)]["image"] = tabImage[index];
    }

    if (typeof localStorage != "undefined" && JSON) {

        localStorage.setItem("PlatRestaurant", JSON.stringify(tab));
    } else {
        alert("local Storage non suporte sur ce navigateur !");
    }


}

function FonctionAJAXImage() {
    var xhr = new XMLHttpRequest;

    xhr.open("GET", `/site/restaurant-bar-a-soupe/API/nutriscore.php?nom=all`, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            var dataAJAX = JSON.parse(xhr.response);
            let i = 0;
            for (item in dataAJAX) {

                tabImage[i++]=dataAJAX[item]['image'];
                
            }
        }
    }
}