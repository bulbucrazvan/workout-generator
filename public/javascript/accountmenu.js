let accountBtn = document.getElementById("accountBtn");
let accountDropDown = document.getElementById("accountDropDown");
let accountBlur = document.getElementById("accountBlur");
document.body.addEventListener('click', onBodyClick);

wasClicked = false;

function onBodyClick(e){
    if (accountBtn.contains(e.target)){
        if (wasClicked){
            accountBtn.classList.remove('navbar__button--clicked');
            accountDropDown.classList.remove('navbar__dropdown-content--visible');
            accountBlur.classList.add('navbar__dropdown-blur--invisible');
        }
        else {
            accountBtn.classList.add('navbar__button--clicked');
            accountDropDown.classList.add('navbar__dropdown-content--visible');
            accountBlur.classList.remove('navbar__dropdown-blur--invisible');
        }
        wasClicked = !wasClicked;
    }
    else {
        accountBtn.classList.remove('navbar__button--clicked');
        accountDropDown.classList.remove('navbar__dropdown-content--visible');
        accountBlur.classList.add('navbar__dropdown-blur--invisible');
    }
}