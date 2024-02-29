var vagas = document.querySelectorAll(".vaga");
var lista = [...vagas];



 for(var i =0; i < lista.length+1;i++){
     var number = document.createElement('h6');
     number.innerHTML = i+1;
     number.style.position = 'fixed';
     number.style.top ='0';
     number.style.left ='0';
     lista[i].addEventListener("mouseenter", function(event){
        document.getElementById("detalhes").style.display = "block";
     });
     lista[i].addEventListener("mouseleave",function(event){
        document.getElementById("detalhes").style.display = "none";
     });
     lista[i].append(number);
 }

