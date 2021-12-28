
var mail;
var actif;
var type;
var password;

function fonctionAJAX() {
    var xhr = new XMLHttpRequest;

    xhr.open("POST", `https://vincent-deramaux.hd.free.fr/site/restaurant-bar-a-soupe/API/utilisateur/liste_utilisateur.php`, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            callBack(xhr.response);
            
            }
        }
    }


    function callBack(data){
    
        let div = document.getElementById("detail");
        //a.innerHTML="";
        //console.log(data);
        var dataAJAX = JSON.parse(data);
        
        let span = document.createElement("div");
            span.id= "detail__div";
            div.appendChild(span);
    
            
            let result = 0;
            
            string = `<div class="detail_h2"><H2">Liste Utilisateurs</H2></div>`;
            string += '<div style="display:block;"><div style="display:flex"><table cellspacing="10px"><tbody>';
            string +="<tr><th>mail</th><th>Supprimer</th><th>active</th><th>type</th></tr>";
        let i = 0;  
        for (item in dataAJAX) {
         
            string +=`<tr>  
                        <td><input type="text" class="mail" value="${dataAJAX[item][0]}" disabled="true"></td>
                        <td><button onclick="functionDelete('${dataAJAX[item][0]}','${dataAJAX[item][2]}');">supp.</button></td>
                        <td><div>
                        <input type="checkbox" id="actif${++i}" onclick="checkActive('${i}','${dataAJAX[item][0]}','${dataAJAX[item][2]}')" ${(dataAJAX[item][1]==1)?"checked":""}>
                        </div></td>
                        <td>${dataAJAX[item][2]}</tr>`;
                        
        }
        string +=`<tr>  
        <td><input type="text" class="IptCompte"></td>
        <td><button disabled="true">supp.</button></td>
        <td><div><input type="checkbox" class="IptCompte" class="IptCompte" checked disabled="true"><label for="scales"></label></div></td>
        <td><SELECT class="IptCompte" ><OPTION  VALUE="serveur">serveur<OPTION VALUE="admin">admin</SELECT></td>                     
        </tr>`;      
        
            string+="<tr><td></td><td></td><td></td><td>Confirmation</td></tr></tbody></table>";
            span.innerHTML=string;

            string += '<table cellspacing="10px" style="width:150px;"><tbody>';
            string +="<tr><th>Mot de passe</th></tr>";
          
        for (item in dataAJAX) {
            
            string +=`<tr><td><input type="password" class="Mdp" disabled="true"></td></tr>`;
        }
        string +=`<tr><td><input type="password" class="IptCompte"></td></tr>`;
        string +=`<tr><td><input type="password" class="IptCompte"></td></tr>`; 

            string+=`</tbody></table>`;
            string+=`<script>
            
            </script>`;
            string+=`<tr></tr>`;
            string+=`</div><button style="margin-left:10px;width:588px;" onclick="functionInsert()");">Nouvel utilisateur</button></div>`;
            string+=`</div><button style="margin-left:10px;width:588px;margin-top:5px;" onclick="functionClose()">Fermer</button></div>`;
            
            span.innerHTML=string;

            if (!document.getElementById('mydialogUser').open){
                document.getElementById('mydialogUser').showModal();  
            }
                     
         
    }
    
    function functionClose(){
        document.getElementById("detail__div").remove();
        document.getElementById('mydialogUser').close();
    }

    function functionUpdate(){
        document.getElementById("detail__div").remove();
        fonctionAJAX();
    }


//////////////////////////
// EFFACE UN UTILISATEUR /
//////////////////////////

function functionDelete(mail,type){

    var xhr = new XMLHttpRequest;
  
    var str_json = "compte=" + JSON.stringify([mail,type]);

    xhr.open("GET", `https://vincent-deramaux.hd.free.fr/site/restaurant-bar-a-soupe/API/utilisateur/supp_utilisateur.php?`+str_json, true);
    //Envoie les informations du header adaptées avec la requête
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            callBackSupp(xhr.response);
            
            }
        }
    }

function callBackSupp(data){

    var dataAJAX = JSON.parse(data);
    
    if (parseInt(dataAJAX["errorInfo"][0])== 1) {
        alert("Vous devez garder au moins un compte de ce type.");
        return 0;
    }else{
        //  document.getElementById("detail__div").remove();
        functionUpdate();
         //document.getElementById("debug").innerHTML=data;
    }

}

//////////////////////////
//AJOUTE UN UTILISATEUR //
//////////////////////////

function functionInsert(){

    mail = document.getElementsByClassName("IptCompte")[0];
    actif = document.getElementsByClassName("IptCompte")[1];
    type = document.getElementsByClassName("IptCompte")[2];
    password = document.getElementsByClassName("IptCompte")[3];
    password2 = document.getElementsByClassName("IptCompte")[4];

    if ((mail.value == "") || (password.value == "")) {

        alert("Champ(s) nouvel utilisateur incorrect !")
        return 0;
    }
 
    var str = password.value;
    var strMail = mail.value;

    let validRegex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(! strMail.match(validRegex)){
        alert("Adresse mail mal écrit");
    }else if (password.value!=password2.value){
        alert("Mot de passe mal confirmé");
    }else if(! str.match('[a-zA-Z0-9]{9,}')){
        alert('mot de passe  invalide (au moins 9 caractéres)');
    }else{
        var xhr = new XMLHttpRequest;
      
       var str_json = "compte=" + JSON.stringify([mail.value,actif.checked,type.value,password.value]);
    
        xhr.open("GET", `https://vincent-deramaux.hd.free.fr/site/restaurant-bar-a-soupe/API/utilisateur/insert_utilisateur.php?`+str_json, true);
        //Envoie les informations du header adaptées avec la requête
        xhr.send();
    
        xhr.onreadystatechange = function () {
            if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {
    
                callBackInsert(xhr.response);
                
            }
        }
    }
}
    
function callBackInsert(data){
    
    var dataAJAX = JSON.parse(data);
    if (dataAJAX["errorInfo"][0] == 23000) {
        alert("Compte mail déjà exisant");
        return 0;
    }else {
        //   document.getElementById("detail__div").remove();
        functionUpdate();
        //document.getElementById("debug").innerHTML=data;
    }
    
}

//////////////////////////////
//(DE)ACTIVE UN UTILISATEUR //
//////////////////////////////

function checkActive(id,mail,type){

    actif = document.getElementById("actif"+id);

    var xhr = new XMLHttpRequest;
      
    var str_json = "compte=" + JSON.stringify([mail,actif.checked,type]);
    
        xhr.open("GET", `https://vincent-deramaux.hd.free.fr/site/restaurant-bar-a-soupe/API/utilisateur/active_utilisateur.php?`+str_json, true);
        //Envoie les informations du header adaptées avec la requête
        xhr.send();
    
        xhr.onreadystatechange = function () {
            if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {
                //document.getElementById("debug").innerHTML=xhr.response;
                callBackActive(xhr.response);
                
            }
        } 

}

function callBackActive(data){
    
    var dataAJAX = JSON.parse(data);

    if (parseInt(dataAJAX["errorInfo"][0])== 1) {
        alert("Vous devez garder au moins un compte de ce type actif.");
        functionUpdate();
        return 0;
    }else{
        functionUpdate();
        //document.getElementById("debug").innerHTML=data;
    }
    
}

