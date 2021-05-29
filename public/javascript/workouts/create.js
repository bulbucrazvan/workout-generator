

function redirectToExerciseView(exerciseID) {
    console.log(exerciseID);
    window.location.href = "http://92.115.143.213:3000/project/public/exercises/" + exerciseID;
}

// function addExerciseEventHandlers() {
//     let exerciseList = document.getElementById("workoutExercisesList");
//     for (var i = 0; i < exerciseList.children; i++) {

//     }
// }

function addExerciseToWorkout(exerciseID, exerciseName) {
    if (!document.getElementById("listExercise" + exerciseID)) {
        let exerciseList = document.getElementById("workoutExercisesList");
        var newExerciseElement = `
            <li id="listExercise` + exerciseID + `"> 
                <p class="list-area__paragraph list-area__paragraph--left">` + exerciseName + `</p> 
                <form class="list-area__form">
                    <button id="listViewExercise` + exerciseID + `" class="list-area__button list-area__button--view" type="button">View</button>
                    <button id="listDeleteExercise` + exerciseID +`" class="list-area__button list-area__button--delete" type="submit">Delete</button>
                </form>
            </li>`;
        exerciseList.innerHTML += newExerciseElement;
    }
    (function() {
        var id = exerciseID;
        var exerciseElement = document.getElementById("listViewExercise" + id);
        if (exerciseElement) {
            exerciseElement.addEventListener('click', function() {
                redirectToExerciseView(id);
            });
        };
    }());
}

async function initializeExercises() {
    var exercises = await getExercises();
    let exerciseList = document.getElementById("allExercisesList");
    for (var i = 0; i < exercises.length; i++) {
        (function () {
            var exercise = exercises[i];
            var newElement = `
            <li class="exercise-list__item">
                <p class=exercise-list__exercise>` + exercise["name"] + `</p>
                <form class="exercise-list__form">
                    <button id="viewExercise` + exercise["id"] + `" class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                    <button id="addExercise` + exercise["id"] + `" class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                </form>
            </li>`;
            exerciseList.innerHTML += newElement;
        }());
    }
    for (var i = 0; i < exercises.length; i++) {
        (function () {
            var exercise = exercises[i];
            document.getElementById("viewExercise" + exercise["id"]).addEventListener('click', function(event) { 
                event.preventDefault();
                redirectToExerciseView(exercise["id"]);
            }, false);
            document.getElementById("addExercise" + exercise["id"]).addEventListener('click', function(event) {
                event.preventDefault();
                addExerciseToWorkout(exercise["id"], exercise["name"]);
            }, false);
        }());
    }
    // for (var i = 0; i < exercises.length; i++) {
    //     (function() {
    //         var exercise = exercises[i];
    //         console.log(exercise);
    //         var exerciseElement = document.getElementById("listViewExercise" + exercise["id"]);
    //         if (exerciseElement) {
    //             exerciseElement.addEventListener('click', function() {
    //                 redirectToExerciseView(id);
    //             });
    //         };
    //     }());
    // }
}

async function getExercises() {
    var uri = "http://92.115.143.213:3000/project/api/exercises";
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody;
}

initializeExercises();