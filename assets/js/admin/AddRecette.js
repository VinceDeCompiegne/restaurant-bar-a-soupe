function addRecette(){

    var xhr = new XMLHttpRequest;

    xhr.open("GET", `/site/restaurant-bar-a-soupe/API/admin/liste_image.php`, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            callBackAddRecette(xhr.response);
            
        }
    }

}

function callBackAddRecette(data){

    //console.log(data);

    let dataAJAX = JSON.parse(data);

    let div = document.getElementById("detail");

    
    
    let span = document.createElement("div");
        span.id= "detail__div";
        div.appendChild(span);
        
        let result = 0;
        
        string= `<Table class="pageAd__tbl_mod" span="2" ><tbody><tr>
        <th></th><th></th></tr>`;
        string += '<tr>';
        string += '<td>Photo</td>';
        string += `<td><img class="pageAd__npt_rcp" name="nom" src="/site/restaurant-bar-a-soupe/assets/images/recette/Bol.png" style="max-height:75px;width:auto;"></img></td>`;
        string += '</tr>';
        string += '<tr>';
        string += '<td>Nom recette</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="nom" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>energy</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="energy" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>fibers</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="fibers" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>fruit_percentage</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="fruit_percentage" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>proteins</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="proteins" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>saturated_fats</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="saturated_fats" value=""></td>';
        string += '</tr>';
        string += '<tr>';       
        string += '<td>sodium</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="sodium" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>sugar</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="sugar" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>prix</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="prix" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>aime</td>';
        string += '<td><input type="textbox" class="pageAd__npt_rcp" name="aime" value=""></td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td>image</td>';
        string += '<td>';

        string += '<select onchange="selectOnchange(this.value);" id="image-select">';

        let group;
        let fichier;

        for (item in dataAJAX){
            group = dataAJAX[item].split("/");
            fichier = group[group.length - 1];
            string += `<option value="${fichier}">${fichier}</option>`;
            
        }   

        string +='</select>';
         
        string += '</td>';
        string += '</tr>';
        string += '<tr>';
        string += '<td COLSPAN="9" ROWSPAN="2"><textarea class="pageAd__npt_area" role="textbox" style="height:100px;" name="description" maxlength="1024"></textarea></td>';
        string += '</tr>';
        string += '</tbody></Table>';
        string += '<div id="pageAd__npt_div"><button class="pageAd__spp_ok" name="modifier" onclick="validAdd()">OK</button>';
        
        string +=`<button class="pageAd__spp_ok" onclick="functionClose()">Fermer</button></div>`;
  
        span.innerHTML=string;

        selectOnchange("Bol.png"); 

        if (!document.getElementById('mydialogUser').open){
            document.getElementById('mydialogUser').showModal();  
        }
}

function validAdd(){

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
        ':energy': energy ,
        ':fibers': fibers ,
        ':fruit_percentage': fruit_percentage,
        ':proteins': proteins,
        ':saturated_fats': saturated_fats,
        ':sodium': sodium,
        ':sugar': sugar,
        ':nom': nom,
        ':prix': prix,
        ':aime': aime,
        ':img': image,
        ':description': description,

     }
     var str_json = JSON.stringify(tab);

     var xhr = new XMLHttpRequest;

     xhr.open("GET", `/site/restaurant-bar-a-soupe/API/admin/add_recette.php?id_recette=`+str_json, true);
     xhr.send();
 
     xhr.onreadystatechange = function () {
         if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {
 
             callBackModif(xhr.response);
             
         }
     }

}

function callBackModif(data){
    console.log(data);
    if ((dataerrorInfo = "OK")||(data.errorInfo = "23000")){
        document.location.reload();
    }
}

function selectOnchange(fichier){
    document.getElementsByClassName("pageAd__npt_rcp")[0].src=`/site/restaurant-bar-a-soupe/assets/images/recette/${fichier}`;

}