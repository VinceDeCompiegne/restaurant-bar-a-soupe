

document.querySelector("#iptMail").addEventListener('input', function(){
    let str = document.querySelector("#iptMail").value;
    let validRegex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(! str.match(validRegex)){
        document.querySelector("#iptMail").style.color = "red";
    }else{
        document.querySelector("#iptMail").style.color = "black";
        
    }
    
    document.getElementById("PassValide").style.visibility="hidden";
});
document.querySelector("#iptOldPass").addEventListener('input', function(){
    if (this.value.length<9){
        this.style.color = "red";
    }else{
        this.style.color = "black";
    }
});
document.querySelector("#iptNewPass1").addEventListener('input', function(){
    if (this.value.length<9){
        this.style.color = "red";
    }else{
        this.style.color = "black";
    }
});
document.querySelector("#iptNewPass2").addEventListener('input', function(){
    if (this.value.length<9){
        this.style.color = "red";
    }else{
        this.style.color = "black";
    }
});

function chgPassword(){

    let mail = document.getElementById("iptMail");
    let oldPassword = document.getElementById("iptOldPass");
    let newPassword1 = document.getElementById("iptNewPass1");
    let newPassword2 = document.getElementById("iptNewPass2");

    let str = newPassword1.value;

    if(! str.match('[a-zA-Z0-9]{9,}')){
        alert('mot de passe  invalide (au moins 9 caractéres)');
        return 0;
    }

    if (newPassword1.value != newPassword2.value){
        alert("nouveau mot de passe et sa confirmation inégal");
        return 0;
    }
 
    var xhr = new XMLHttpRequest;
      
    var str_json = "compte=" + JSON.stringify([mail.value,oldPassword.value,newPassword1.value,newPassword2.value]);
    
        xhr.open("GET", `https://vincent-deramaux.hd.free.fr/restaurant-bar-a-soupe/API/utilisateur/chgPwd_utilisateur.php?`+str_json, true);
        //Envoie les informations du header adaptées avec la requête
        xhr.send();
    
        xhr.onreadystatechange = function () {
            if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {
                // document.getElementById("debug").innerHTML=xhr.response;
                callBackChgPwd(xhr.response);
                
            }
        } 

}

function callBackChgPwd(data){
    
    var dataAJAX = JSON.parse(data);
    
    if (dataAJAX["errorInfo"][0] == 23000) {
        alert("Compte mail déjà exisant");
        document.getElementById("PassValide").style.visibility="hidden";
            return 0;
    }else if(dataAJAX["errorInfo"] == "NOK") {
        document.getElementById("PassValide").innerHTML="champ(s) invalide";
        document.getElementById("PassValide").style.color="red";
        document.getElementById("PassValide").style.visibility="visible"; 
         //setTimeout('RedirectionJavascript()', 2000)
    }else if(dataAJAX["errorInfo"]== "0") {
        document.getElementById("PassValide").innerHTML="Mot de passe modifié";
        document.getElementById("PassValide").style.color="green";
        document.getElementById("PassValide").style.visibility="visible"; 
    }else{
        console.log(data);
    }
    
}

function RedirectionJavascript(){
    document.location.href="https://vincent-deramaux.hd.free.fr/Admin.php";
  }