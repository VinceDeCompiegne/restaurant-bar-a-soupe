let mail  = document.getElementById("mail1");
let mail2  = document.getElementById("mail2");

let bouton = document.getElementById("validInscription");
let btnValidConnection = document.getElementById("validConnection");

let btnCloseModal1 = document.getElementById("btnCloseModal1");
let btnCloseModal2 = document.getElementById("btnCloseModal2");

let btnFermer1  = document.getElementById("btnFermer1");
let btnFermer2  = document.getElementById("btnFermer2");

let speudo  = document.getElementById("speudo");


let password  = document.getElementById("password");
let newPassword  = document.getElementById("newPassword");
let currentPassword  = document.getElementById("currentPassword");

let speudoForm  = document.getElementById("speudoForm");
let mailForm1  = document.getElementById("mailForm1");
let mailForm  = document.getElementById("mailForm2");
let passwordForm  = document.getElementById("passwordForm");
let newPasswordForm  = document.getElementById("newPasswordForm");
let currentPasswordForm  = document.getElementById("currentPasswordForm");

let defaut = false;
let  httpRequest = new XMLHttpRequest();

btnValidConnection.addEventListener("click",function(evt) {

  evt.preventDefault();

  defaut = false;

  if  (mail.value == ""){
    mailForm1.textContent = "Champ Vide.";
    defaut = true;
  } 
  if  (currentPassword.value  == ""){
    currentPasswordForm.textContent = "Champ Vide.";
    defaut = true;
  }

  if (defaut == false){
    httpRequest.onreadystatechange = alertLogin;
    httpRequest.open('POST', '/site/restaurant-bar-a-soupe/login.php');
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('mail=' + encodeURIComponent(mail.value) + '&current-password=' + encodeURIComponent(currentPassword.value));
  }

});

function alertLogin() {
  if (httpRequest.readyState === XMLHttpRequest.DONE) {
    if (httpRequest.status === 200) {
      var response = httpRequest.responseText;

      if (response == "nok") {
          mailForm1.textContent = "Mauvais couple mail/mot de passe.";
          currentPasswordForm.textContent = "Mauvais couple mail/mot de passe.";
          defaut = true;
      }
       else
  
      // /****************************** Appel du formulaire **************************************/
  
       {
           var form = document.getElementById("connexion-form");
           form.submit();
       }
       //**************************************************************************/

    } else {
      alert('Un problème est survenu avec la requête.');
    }
  }
}

btnFermer1.addEventListener("click",function(evt) {

  mail.value = "";
  currentPassword.value = "";

  mailForm1.textContent = "";
  currentPasswordForm.textContent = "";

});

btnCloseModal1.addEventListener("click",function(evt) {

  mail.value = "";
  currentPassword.value = "";

  mailForm1.textContent = "";
  currentPasswordForm.textContent = "";

});


 


btnFermer2.addEventListener("click",function(evt) {

  speudo.value = "";
  mail2.value = "";
  password.value = "";
  newPassword.value = "";

  speudoForm.textContent = "";
  mailForm.textContent = "";
  passwordForm.textContent = "";
  newPasswordForm.textContent = "";

  defaut = false;

});


btnCloseModal2.addEventListener("click",function(evt) {

  speudo.value = "";
  mail2.value = "";
  password.value = "";
  newPassword.value = "";

  speudoForm.textContent = "";
  mailForm.textContent = "";
  passwordForm.textContent = "";
  newPasswordForm.textContent = "";

  defaut = false;

});



bouton.addEventListener("click",function(evt) {

    evt.preventDefault();

    defaut = false;

    if (speudo.value == ""){
      speudoForm.textContent = "Champ Vide.";
      defaut = true;
    }else{
      speudoForm.textContent = "";
    }

    if (mail2.value == ""){
      mailForm.textContent = "Champ Vide.";
      defaut = true;
    }else{
      mailForm.textContent = "";
    }
    let strnNewPassword = newPassword.value;
    if (strnNewPassword.length == 0){
      newPasswordForm.textContent = "Champ Vide.";
      defaut = true;
    }else{
      newPasswordForm.textContent = "";
    }
    strPassword = password.value;
    if (strPassword.length == 0){
      passwordForm.textContent = "Champ Vide.";
      defaut = true;
    }else{
      passwordForm.textContent = "";
    }
    
    if ((password.value != newPassword.value)&&(strnNewPassword.length != 0)&&(strPassword.length != 0)){
      newPasswordForm.textContent = "Mot de passe mal confirmé.";
      defaut = true;
    }


    if (defaut == false){
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('POST', '/site/restaurant-bar-a-soupe/API/check_username.php');
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('mail=' + encodeURIComponent(mail2.value));
    }

});

  function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        let response = httpRequest.responseText;


        if (response == "nok") {
            mailForm.textContent = "L'utilisateur est déjà enregistré.";
            
        }else
    
        /****************************** Appel du formulaire **************************************/
    
        {
            var form = document.getElementById("contact-form");
            form.submit();
        }
        /**************************************************************************/

      } else {
        alert('Un problème est survenu avec la requête.');
      }
    }
}
