/*FonctionAJAX();
function FonctionAJAX(){



    const data = null;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === this.DONE) {
            callback(this.responseText);
        }
    });
    
    xhr.open("GET", "https://nutri-score.p.rapidapi.com/v1/nutri-score/cheese/100?protein_g=10");
    xhr.setRequestHeader("x-rapidapi-key", "21fcfa8bf0msh30752621eafe5c0p1c508bjsna45eacb3e48a");
    xhr.setRequestHeader("x-rapidapi-host", "nutri-score.p.rapidapi.com");
    
    xhr.send(data);
    
}

function callback(msg){
    console.log(msg);
}*/

import { nutriScore } from "nutri-score";

const result = nutriScore.calculateClass({
  energy: 0,
  fibers: 4,
  fruit_percentage: 60,
  proteins: 2,
  saturated_fats: 2,
  sodium: 500,
  sugar: 10
});
