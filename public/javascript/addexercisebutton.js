let addExerciseButton = document.getElementById("addExerciseButton");
let addExerciseArea = document.getElementById("addExerciseArea");
var addExerciseDropdown = document.getElementsByClassName("add-exercise-area__dropdown");
document.body.addEventListener('click', exerciseAreaClick);
wasExerciseButtonClicked = false;

function exerciseAreaClick(e){
    if (addExerciseButton.contains(e.target)){
        if (wasExerciseButtonClicked){
            addExerciseArea.classList.remove("filter-area__add-exercise-area--darkened");
            addExerciseButton.classList.remove('add-exercise-area__button--clicked');
            for (var i = 0; i < addExerciseDropdown.length; i++){
                addExerciseDropdown[i].classList.remove("add-exercise-area__dropdown--visible");
            }
        }
        else {
            addExerciseArea.classList.add("filter-area__add-exercise-area--darkened");
            addExerciseButton.classList.add('add-exercise-area__button--clicked');
            for (var i = 0; i < addExerciseDropdown.length; i++){
                addExerciseDropdown[i].classList.add("add-exercise-area__dropdown--visible");
            }
        }
        wasExerciseButtonClicked = !wasExerciseButtonClicked;
    }
    else {
        if (wasExerciseButtonClicked){
            addExerciseArea.classList.remove("filter-area__add-exercise-area--darkened");
            addExerciseButton.classList.remove('add-exercise-area__button--clicked');
            for (var i = 0; i < addExerciseDropdown.length; i++){
            addExerciseDropdown[i].classList.remove("add-exercise-area__dropdown--visible");
            }
            wasExerciseButtonClicked = false;
        }
    }
}