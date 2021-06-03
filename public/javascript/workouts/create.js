
function redirectToExerciseView(exerciseID) {
    console.log(exerciseID);
    window.location.href = "http://92.115.143.213:3000/project/public/exercises/" + exerciseID;
}

function addExerciseToWorkout(exerciseID, exerciseName) {
    if (!document.getElementById("listExercise" + exerciseID)) {
        let exerciseList = document.getElementById("workoutExercisesList");
        var newExerciseElement = `
            <li id="listExercise` + exerciseID +`" value="` + exerciseID + `"> 
                <p class="list-area__paragraph list-area__paragraph--left">` + exerciseName + `</p> 
                <form class="list-area__form">
                    <button id="listViewExercise" value="` + exerciseID + `" class="list-area__button list-area__button--view" type="button">View</button>
                    <button id="listDeleteExercise" value="` + exerciseID +`" class="list-area__button list-area__button--delete" type="submit">Delete</button>
                </form>
            </li>`;
        exerciseList.innerHTML += newExerciseElement;
        setListBackgroundColour("list-area__list", "");
    }
}

function removeExerciseFromWorkout(exerciseID) {
    document.getElementById('listExercise' + exerciseID).remove();
}

function getWorkoutFromPage() {
    var workout = {};
    workout["workoutName"] = document.getElementById('workoutName').value;
    var exercises = [];
    for (var exerciseElement of document.getElementById("workoutExercisesList").children) {
        exercises.push(exerciseElement.value);
    }
    workout["exercises"] = exercises;
    return workout;
}


async function initializeExercises() {
    var exercises = await getExercises();
    let exerciseList = document.getElementById("allExercisesList");
    
    for (var exercise of exercises) {
        var newElement = `
            <li class="exercise-list__item">
                <p id="exerciseParagraph` + exercise["id"]+ `" class=exercise-list__exercise>` + exercise["name"] + `</p>
                <form class="exercise-list__form">
                    <button id="viewExercise" value="` + exercise["id"] + `" class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                    <button id="addExercise" value="` + exercise["id"] + `" class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                </form>
            </li>`;
            exerciseList.innerHTML += newElement;
    }
}

async function postWorkout(workout) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID + "/workouts";
    const response = await fetch(uri, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': loginKey
        },
        body: JSON.stringify(workout)
    });
    const responseBody = await response;
    if (responseBody["statusCode"]) {
        document.cookie = "errorMessage=" + responseBody["description"] + "";
        window.location.href = "/project/public/errorMessage";
    }
    return responseBody["description"];
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
    if (responseBody["statusCode"]) {
        document.cookie = "errorMessage=" + responseBody["description"] + "";
        window.location.href = "/project/public/errorMessage";
    }
    return responseBody["description"];
}

function initializeExerciseHandlers() {
    document.getElementById("allExercisesList").addEventListener('click', function(event) {
        event.preventDefault();
        if (event.target.id == "viewExercise") {
            redirectToExerciseView(event.target.value);
        }
        else if (event.target.id == 'addExercise') {
            var exerciseID = event.target.value;
            var exerciseName = document.getElementById('exerciseParagraph' + exerciseID).innerHTML;
            addExerciseToWorkout(exerciseID, exerciseName);
        }
    })
    
    document.getElementById("workoutExercisesList").addEventListener('click', function(event) {
        event.preventDefault();
        if (event.target.id == "listViewExercise") {
            redirectToExerciseView(event.target.value);
        }
        else if (event.target.id == 'listDeleteExercise') {
            removeExerciseFromWorkout(event.target.value);
        }
    });
}


initializeExercises();

document.getElementById("allExercisesList").addEventListener('click', function(event) {
    event.preventDefault();
    if (event.target.id == "viewExercise") {
        redirectToExerciseView(event.target.value);
    }
    else if (event.target.id == 'addExercise') {
        var exerciseID = event.target.value;
        var exerciseName = document.getElementById('exerciseParagraph' + exerciseID).innerHTML;
        addExerciseToWorkout(exerciseID, exerciseName);
    }
})

document.getElementById("workoutExercisesList").addEventListener('click', function(event) {
    event.preventDefault();
    if (event.target.id == "listViewExercise") {
        redirectToExerciseView(event.target.value);
    }
    else if (event.target.id == 'listDeleteExercise') {
        removeExerciseFromWorkout(event.target.value);
    }
});

let postBtn = document.getElementById("postBtn");
if (postBtn) {
    postBtn.addEventListener('click', async function(event) {
        event.preventDefault();
        var workout = getWorkoutFromPage();
        await postWorkout(workout);
        window.location.href = '/project/public/workouts';
    })
}