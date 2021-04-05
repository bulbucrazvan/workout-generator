let menuBtn = document.getElementById("menuBtn");
let dropDown = document.getElementById("dropDwn");
let dropIcon = document.getElementById("dropDwnIcon");

document.body.addEventListener('click', onBodyClick);

wasClicked = false;

function onBodyClick(e){
    if (menuBtn.contains(e.target)){
        if (wasClicked){
            menuBtn.classList.remove('dropBtn-clicked');
            dropDown.classList.remove('dropdown-content-shown');
            dropIcon.classList.remove('dropDwnIcon-pressed');
        }
        else {
            menuBtn.classList.add('dropBtn-clicked');
            dropDown.classList.add('dropdown-content-shown');
            dropIcon.classList.add('dropDwnIcon-pressed');
        }
        wasClicked = !wasClicked;
    }
    else {
        menuBtn.classList.remove('dropBtn-clicked');
        dropDown.classList.remove('dropdown-content-shown');
        dropIcon.classList.remove('dropDwnIcon-pressed');
    }
}