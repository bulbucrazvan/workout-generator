let menuBtn = document.getElementById("menuBtn");
let dropDown = document.getElementById("dropDown");
let dropIcon = document.getElementById("dropDownIcon");

document.body.addEventListener('click', onBodyClick);

wasClicked = false;

function onBodyClick(e){
    if (menuBtn.contains(e.target)){
        if (wasClicked){
            menuBtn.classList.remove('navbar__button--clicked');
            dropDown.classList.remove('navbar__dropdown-content--visible');
            dropIcon.classList.remove('navbar__dropdown-icon--pressed');
        }
        else {
            menuBtn.classList.add('navbar__button--clicked');
            dropDown.classList.add('navbar__dropdown-content--visible');
            dropIcon.classList.add('navbar__dropdown-icon--pressed');
        }
        wasClicked = !wasClicked;
    }
    else {
        menuBtn.classList.remove('navbar__button--clicked');
        dropDown.classList.remove('navbar__dropdown-content--visible');
        dropIcon.classList.remove('navbar__dropdown-icon--pressed');
    }
}