/*This script makes a Count animation for the percentage numbers*/
var speed = 10;

/* Call this function with a string containing the ID name to
 * the element containing the number you want to do a count animation on.
 * E.g incEltNbr("element");*/
function incEltNbr(id){
  elt = document.getElementById(id);
  endNbr = Number(document.getElementById(id).innerHTML);
  incNbrRec(0,endNbr,elt);
}

/*A recursive function to increase the number.*/
function incNbrRec(i,endNbr,elt){
  if(i <= endNbr){
    elt.innerHTML = i;
    setTimeout(function() {//Waiting "Speed" number of milliseconds before calling the function again.
      incNbrRec(i+1,endNbr,elt);
    }, speed);
  }
}
