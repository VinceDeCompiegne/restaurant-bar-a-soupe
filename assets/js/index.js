let mail  = document.getElementById("mail1");
let username  = document.getElementById("mail2");

let bouton = document.getElementById("validInscription");
let btnValidConnection = document.getElementById("validConnection");

let btnCloseModal1 = document.getElementById("btnCloseModal1");
let btnCloseModal2 = document.getElementById("btnCloseModal2");

let btnFermer1  = document.getElementById("btnFermer1");
let btnFermer2  = document.getElementById("btnFermer2");

let speudo  = document.getElementById("speudo");


let password  = document.getElementById("password");
let newPassword  = document.getElementById("new-password");
let currentPassword  = document.getElementById("current-password");

let speudoForm  = document.getElementById("speudoForm");
let mailForm1  = document.getElementById("mailForm1");
let mailForm  = document.getElementById("mailForm");
let newPasswordForm  = document.getElementById("newPasswordForm");
let currentPasswordForm  = document.getElementById("currentPasswordForm");

let defaut = false;
let  httpRequest = new XMLHttpRequest();

btnValidConnection.addEventListener("click",function(evt) {

  evt.preventDefault();

  defaut = false;

  if  (mail.value == ""){
  //  mailForm1.textContent = "Champ Vide.";
    defaut = true;
  } 
  if  (currentPassword.value  == ""){
   // currentPasswordForm.textContent = "Champ Vide.";
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
  username.value = "";
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
  username.value = "";
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


    if (speudo.value == ""){
      speudoForm.textContent = "Champ Vide.";
      defaut = true;
    }

    if (username.value == ""){
      mailForm.textContent = "Champ Vide.";
      defaut = true;
    }

    if (password.value == ""){
      passwordForm.textContent = "Champ Vide.";
      defaut = true;
    }

    if (newPassword.value == ""){
      newPasswordForm.textContent = "Champ Vide.";
      defaut = true;
    }
    
    if (password.value != newPassword.value){
      newPasswordForm.textContent = "Mot de passe mal confirmé.";
      defaut = true;
    }


    if (defaut == false){
      alert(defaut);
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('POST', '/site/restaurant-bar-a-soupe/API/check_username.php');
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('mail=' + encodeURIComponent(mail.value));
    }

});

  function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        var response = httpRequest.responseText;


        if (response == "nok") {
            mailForm.textContent = "L'utilisateur est déjà enregistré.";
            defaut = true;
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
