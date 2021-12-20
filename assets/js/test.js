window.addEventListener("load", function(event) {

    var tab = {Plat_1 : {aime : 0, reservation : 0},
    Plat_2 : {aime : 0, reservation : 0},
    Plat_3 : {aime : 0, reservation : 0},
    Plat_4 : {aime : 0, reservation : 0},
    Plat_5 : {aime : 0, reservation : 0},
    Plat_6 : {aime : 0, reservation : 0},
    Plat_7 : {aime : 0, reservation : 0},
    Plat_8 : {aime : 0, reservation : 0},
    Plat_9 : {aime : 0, reservation : 0},
    Plat_10 : {aime : 0, reservation : 0},
    Plat_11 : {aime : 0, reservation : 0},
    Plat_12 : {aime : 0, reservation : 0},
    Plat_13 : {aime : 0, reservation : 0},
    Plat_14 : {aime : 0, reservation : 0},
    Plat_15 : {aime : 0, reservation : 0},
};
    console.log("test : " + tab["Plat_3"]["aime"]);


    var toto = 1;
    var tata = 1;

    var plat = new Array();
    var tab = new Array();

    for(i=0;i<30;i++)
    {

        plat=   {"titre":"plat_" + i,"reservation":toto,"aime":tata};
        tab.push(plat);
          
    }

    for (var item in tab) {
        console.log(tab[item]);

    };

    if(typeof localStorage != "undefined" && JSON){
        
        //console.log(tab);
        //console.log(JSON.stringify(tab));
        localStorage.setItem("PlatRestaurant",JSON.stringify(tab));

    }
    else {

        alert("local Storage non suporte sur ce navigateur !");

    }


    
    });



