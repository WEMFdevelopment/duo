var slideIndex = 1;
var plano = document.getElementsByClassName("plano-big");
var plano01 = document.getElementsByClassName("plano-01");
var planoMini = document.getElementsByClassName("plano-phone");


currentDiv(1);

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {

	var ancho =$(window).width();
    // hideDepamini(n);
    hideDepaBig(n);

    if(ancho < 767){
        planoMini[n-1].style.display = "block";
    }
   		else{
        	plano[n-1].style.display = "block";
        	plano01[n-1].style.display = "block";
   		}

}

function hideDepaBig(){

    for (var i = 0; i < plano.length; i++) {
        plano[i].style.display = "none";
        // plano01[i].style.display = "none";
    }
}

function hideDepamini(){
    for (var i = 0; i < plano.length; i++) {
        planoMini[i].style.display = "none";
    }
}