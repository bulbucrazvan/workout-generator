let menuBtn = document.getElementById("menuBtn");
let dropDown = document.getElementById("dropDwn");
let dropIcon = document.getElementById("dropDwnIcon");

menuBtn.addEventListener('click', onClick);
document.body.addEventListener('click', onBodyClick);

function onClick(){
    menuBtn.classList.add('dropBtn-clicked');
    dropDown.classList.add('dropdown-content-shown');
    dropIcon.classList.add('dropDwnIcon-pressed');
}

function onBodyClick(e){
    if (menuBtn.contains(e.target)){
        return;
    }
    menuBtn.classList.remove('dropBtn-clicked');
    dropDown.classList.remove('dropdown-content-shown');
    dropIcon.classList.remove('dropDwnIcon-pressed');
}