function fonctionAJAX(requete,nom) {
    var xhr = new XMLHttpRequest;

    xhr.open("GET", `/site/restaurant-bar-a-soupe/API/detail_reservation.php?id_reservation=`+requete, true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if ((xhr.readyState == 4) && ((xhr.status == 200) || (xhr.status == 0))) {

            callBack(xhr.response,nom);
            
            }
        }
    }


function callBack(data,nom){
    
    let div = document.getElementById("detail");
    //a.innerHTML="";
    console.log(data);
    var dataAJAX = JSON.parse(data);
    
    let span = document.createElement("div");
        span.id= "detail__div";
        div.appendChild(span);

        // span.innerHTML="<table><tbody><tr>";
        let result = 0;
        let string = `<div class="detail_h2"><H2">${nom}</H2></div>`;
        string += "<table class='srv__detail_tbl'><tbody>";
        string +="<tr><th>plat</th><th>nombre</th><th>Prix unitaire(€)</th><th>Prix(€)</th></tr>";
        
    for (item in dataAJAX) {
        
        string +=`<tr><td>${dataAJAX[item][2]}</td>
        <td>${dataAJAX[item][3]}</td>
        <td>${dataAJAX[item][4]}</td>
        <td>${dataAJAX[item][5].toFixed(2)}</td></tr>`;
        result = result + parseFloat(dataAJAX[item][5].toFixed(2));
        //a.innerHTML+=dataAJAX[item][2] + " " + dataAJAX[item][3]  + "</br>";
    }
        string+=`<td></td><td></td><td></td><td></td><td></td></tr>`;
        string+=`<td></td><td></td><td><B>TOTAL:</B></td><td>${result}€</td></tr>`;
        string+="</tbody></table>";
        span.innerHTML=string;
        document.getElementById('mydialog').showModal();

}

function functionClose(){
    document.getElementById("detail__div").remove();
    document.getElementById('mydialog').close()
}