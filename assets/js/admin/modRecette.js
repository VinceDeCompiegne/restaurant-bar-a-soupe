function lectureRecette(id_recette){
    
    var xhr = new XMLHttpRequest;

    xhr.open("GET", `https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/API/admin/detail_recette.php?id_recette=`+id_recette, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            callBackLecture(xhr.response);
            
        }
    }
}

var imageAJAX=null;

function callBackLecture(data){

    var dataAJAX = JSON.parse(data);

    let div = document.getElementById("detail");
    //a.innerHTML="";
    //console.log(data);
    var dataAJAX = JSON.parse(data);
    
    let span = document.createElement("div");
        span.id= "detail__div";
        div.appendChild(span);
        
        let result = 0;
        
        // string=`<form id="formModif" style="display:block;" action="login.php" method="post">`;
        string= `<Table class="pageAd__tbl_mod" span="2" ><tbody><tr>
        <th></th><th></th></tr>`;
        string += '<tr>';
        string += '<td>Photo</td>';
        string += `<td><img class="pageAd__npt_rcp" name="nom" src="https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/assets/images/recette/${dataAJAX['image']}" style="max-height:75px;width:auto;"></img></td>`;
        string += '</tr>';
        string += '<tr>';
        string += '<td>Nom recette</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="nom" value="' + dataAJAX['nom'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>energy</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="energy" value="' + dataAJAX['energy'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>fibers</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="fibers" value="' + dataAJAX['fibers'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>fruit_percentage</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="fruit_percentage" value="' + dataAJAX['fruit_percentage'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>proteins</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="proteins" value="' + dataAJAX['proteins'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>saturated_fats</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="saturated_fats" value="' + dataAJAX['saturated_fats'] + '"></td>';
        string += '</tr>';
        string += '<tr>';       
        string += '<td>sodium</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="sodium" value="' + dataAJAX['sodium'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>sugar</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="sugar" value="' + dataAJAX['sugar'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>prix</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="prix" value="' + dataAJAX['prix'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>aime</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="aime" value="' + dataAJAX['aime'] + '"></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>image</td>';
        string += '<td>';
        string += `<select onchange="selectOnchange(this.value);" id="image-select">`;
        string += '</select>';
        string += '</tr>';
        string += '<tr>';
        string += '<td COLSPAN="9" ROWSPAN="2"><textarea class="pageAd__npt_area" role="textbox" style="height:100px;" name="description" maxlength="1024">'+ dataAJAX['description'] +'</textarea></td>';
        string += '</tr>';
        string += '</tbody></Table>';
        string += '<div id="pageAd__npt_div"><button class="pageAd__spp_ok" name="modifier" onclick="validMod(' + dataAJAX['id'] + ')">OK</button>';
        // string += '</form>';

        string +=`<button class="pageAd__spp_ok" onclick="functionClose()">Fermer</button></div>`;
  
        span.innerHTML=string;

        getListe(dataAJAX['image']);

        if (!document.getElementById('mydialogUser').open){
            document.getElementById('mydialogUser').showModal();  
        }
}

function validMod(id){

    var e1 = document.getElementsByClassName("pageAd__npt_rcp")[1];
    var e2 = document.getElementsByClassName("pageAd__npt_rcp")[2];
    var e3 = document.getElementsByClassName("pageAd__npt_rcp")[3];
    var e4 = document.getElementsByClassName("pageAd__npt_rcp")[4];
    var e5 = document.getElementsByClassName("pageAd__npt_rcp")[5];
    var e6 = document.getElementsByClassName("pageAd__npt_rcp")[6];
    var e7 = document.getElementsByClassName("pageAd__npt_rcp")[7];
    var e8 = document.getElementsByClassName("pageAd__npt_rcp")[8];
    var e9 = document.getElementsByClassName("pageAd__npt_rcp")[9];
    var e10 = document.getElementsByClassName("pageAd__npt_rcp")[10];
    var e11 = document.getElementsByClassName("pageAd__npt_area")[0];
    var e12 = document.getElementById("image-select");

     //if (e9.value == ""){e9.value=0};
    if ((e1.value=="")||(e2.value=="")||(e3.value=="")||(e4.value=="")||(e5.value=="")||(e6.value=="")||(e7.value=="")||(e8.value=="")||(e9.value=="")||(e10.value=="")||(e11.value=="")) {
         alert("Probléme de champ(s) vide(s).");
        return 0;
     }

    let nom = e1.value;
    let energy = e2.value;
    let fibers = e3.value;
    let fruit_percentage = e4.value;
    let proteins = e5.value;
    let saturated_fats = e6.value;
    let sodium = e7.value;
    let sugar = e8.value;
    let prix = e9.value;
    let aime = e10.value;
    let description = e11.value;
    let image = e12.value;

     let tab = {
        ':nom':nom,
        ':energy': energy ,
        ':fibers':fibers ,
        ':fruit_percentage':fruit_percentage,
        ':proteins':proteins,
        ':saturated_fats':saturated_fats,
        ':sodium':sodium,
        ':sugar':sugar,
        ':id':id,
        ':prix':prix,
        ':aime':aime,
        ':image': image,
        ':description':description,
     }

     var str_json = JSON.stringify(tab);

     var xhr = new XMLHttpRequest;

     xhr.open("GET", `https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/API/admin/save_recette.php?id_recette=`+str_json, true);
     xhr.send();
 
     xhr.onreadystatechange = function () {
         if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {
            //alert(xhr.response);
             callBackModif(xhr.response);
             
         }
     }

}

function callBackModif(data){
    console.log(data);
    if (data == "ok"){
        document.location.reload();
    }
}


function getListe(selected){

let xhr2 = new XMLHttpRequest;
let strSel = null;
xhr2.open("GET", `https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/API/admin/liste_image.php`, true);
xhr2.send();

xhr2.onreadystatechange = function () {
    if ((xhr2.readyState == 4) && ((xhr2.status == 200) || (xhr2.status == 0))) {

        imageAJAX = JSON.parse(xhr2.response);

        let optionSelect = document.getElementById("image-select");
        optionSelect.innerHTML="";

        for (item in imageAJAX){
            group = imageAJAX[item].split("/");
            fichier = group[group.length - 1];
            strSel = (selected!=fichier)?"":"SELECTED";
            
            optionSelect.innerHTML+= `<option value="${fichier}" ${strSel}>${fichier}</option>`; 
        }
        
    }
}
}


function selectOnchange(fichier){
    document.getElementsByClassName("pageAd__npt_rcp")[0].src=`https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/assets/images/recette/${fichier}`;

}
    