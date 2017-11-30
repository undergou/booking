var pages = document.querySelectorAll('.page');
var curUrl = document.location.href;

for (var i = 0; i< pages.length; i++){
    if(curUrl.slice(-1) =='p'){
        pages[0].setAttribute('class', 'page alert alert-button-active');
    } else if(pages[i].innerHTML == curUrl.slice(-1)){
        pages[i].setAttribute('class', 'page alert alert-button-active');
    }
}