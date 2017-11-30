var deletes = document.querySelectorAll('.deletes');
for (var i = 0; i<deletes.length; i++){
    deletes[i].addEventListener('click', functionConfirm);
}
function functionConfirm(){
    confirm('Are you sure you want to delete this item?');
}