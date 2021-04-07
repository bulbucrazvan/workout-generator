let accountBtn = document.getElementById("accountBtn");
let accountDropDown = document.getElementById("accountDropDown");
let accountBlur = document.getElementById("accountBlur");
let accountButtonBlur = document.getElementById("accountButtonBlur");
document.body.addEventListener('click', onBodyClick);

wasClicked = false;

function onBodyClick(e){
    if (accountBtn.contains(e.target)){
        if (wasClicked){
            accountDropDown.classList.remove('navbar__dropdown-content--visible');
            accountBlur.classList.add('navbar__dropdown-blur--invisible');
            accountButtonBlur.classList.add('navbar__dropdown-blur--invisible');
            accountBtn.classList.remove('navbar__button--desktop-clicked');
        }
        else {
            accountDropDown.classList.add('navbar__dropdown-content--visible');
            accountBlur.classList.remove('navbar__dropdown-blur--invisible');
            accountButtonBlur.classList.remove('navbar__dropdown-blur--invisible');
            accountBtn.classList.add('navbar__button--desktop-clicked');
        }
        wasClicked = !wasClicked;
    }
    else {
        accountDropDown.classList.remove('navbar__dropdown-content--visible');
        accountBlur.classList.add('navbar__dropdown-blur--invisible');
        accountButtonBlur.classList.add('navbar__dropdown-blur--invisible');
        accountBtn.classList.remove('navbar__button--desktop-clicked');
    }
}