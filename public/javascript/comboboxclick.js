let comboBox = document.getElementById('comboBox');
document.body.addEventListener('click', comboBoxClick);
wasClicked = false;

function comboBoxClick(e){
    if (comboBox.contains(e.target)){
        if (wasClicked){
            comboBox.classList.remove('combo-box--clicked');
        }
        else {
            comboBox.classList.add('combo-box--clicked');
        }
        wasClicked = !wasClicked;
    }
    else {
        comboBox.classList.remove('combo-box--clicked');
        wasClicked = false;
    }
}