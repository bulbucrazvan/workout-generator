let exercisesBtn = document.getElementById("exercisesBtn");
let editorBtn = document.getElementById("editorBtn");
let viewerArea = document.getElementById("viewerArea");
let editorArea = document.getElementById("editorArea");
let exerciseListElement = document.getElementById("exerciseListElement");
let saveBtn = document.getElementById("saveBtn");
var exercisesList;
var currentPage = 0, currentState;
var editedExerciseID;
const NEW_EXERCISE = 0, EDIT_EXERCISE = 1, VIEWER_PAGE = 0, EDITOR_PAGE = 1 ;


async function switchToViewerArea(){
    viewerArea.classList.remove('settings-area--hidden');
    editorArea.classList.add('settings-area--hidden');
    exercisesBtn.classList.add('tab-area__button--selected');
    editorBtn.classList.remove("tab-area__button--selected");
}

async function switchToEditorArea() {
    viewerArea.classList.add('settings-area--hidden');
    editorArea.classList.remove('settings-area--hidden');
    exercisesBtn.classList.remove('tab-area__button--selected');
    editorBtn.classList.add("tab-area__button--selected");
}

async function newExercise() {
    if (currentPage == VIEWER_PAGE) {
        currentState = NEW_EXERCISE;
        currentPage = EDITOR_PAGE;
        switchToEditorArea();
        await setExerciseDetails(null);
    }
}

async function discardChanges() {
    if (currentPage == EDITOR_PAGE) {
        currentPage = VIEWER_PAGE;
        switchToViewerArea();
    }
}

async function editExercise(exerciseID) {
    currentPage = EDITOR_PAGE;
    currentState = EDIT_EXERCISE;
    editedExerciseID = exerciseID;
    switchToEditorArea();
    exercise = await getExerciseDetails(exerciseID);
    await setExerciseDetails(exercise);
}

async function setExerciseDetails(exercise) {
    document.getElementById("nameInput").value = exercise ? exercise["name"] : '';
    document.getElementById("linkInput").value = exercise ? exercise["videoURL"] : '';
    document.getElementById("durationInput").value = exercise ? exercise["duration"] : '';
    document.getElementById("instructionsInput").value = exercise ? exercise["instructions"] : '';
    await resetCheckboxes();
    if (exercise) {
        await setCheckboxes(exercise["locations"], exercise["muscles"]);
    }
}

async function setCheckboxes(locations, muscles) {
    for (currentLocation of locations) {
        document.getElementById("location" + currentLocation).checked = true;
    }

    for (muscle of muscles) {
        document.getElementById("muscle" + muscle).checked = true;
    }
}

async function resetCheckboxes() {
    for (checkbox of document.getElementById("muscleCheckboxes").children) {
        checkbox.checked = false;
    }

    for (checkbox of document.getElementById("locationCheckboxes").children) {
        checkbox.checked = false;
    }
}

const getExerciseDetails = async (exerciseID) => {
    var uri = "http://92.115.143.213:3000/project/api/exercises/" + exerciseID;
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

const getExercises = async () => {
    var uri = "http://92.115.143.213:3000/project/api/exercises";
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

const postExercise = async (exercise) => {
    var requestBody = JSON.stringify(exercise);
    console.log(requestBody);
    var uri = "http://92.115.143.213:3000/project/api/exercises";
    const response = await fetch(uri, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: requestBody
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

const putExercise = async (exerciseID, exercise) => {
    var requestBody = JSON.stringify(exercise);
    var uri = "http://92.115.143.213:3000/project/api/exercises/" + exerciseID;
    const response = await fetch(uri, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: requestBody
    });
    const responseBody = await response.json();
    return responseBody["description"];
};

const deleteExercise = async (exerciseID) => {
    var uri = "http://92.115.143.213:3000/project/api/exercises/" + exerciseID;
    const response = await fetch(uri, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

const restoreExercise = async (exerciseID) => {
    var uri = "http://92.115.143.213:3000/project/api/exercises/" + exerciseID;
    const response = await fetch(uri, {
        method: 'PATCH',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

async function saveExercise() {
    exercise = getExerciseFromPage();
    var response;
    if (currentState == NEW_EXERCISE) {
        response = await postExercise(exercise);
        await appendExerciseToPage(response["description"], exercise["name"], false);
        setListBackgroundColour("list-area__list", "");
    }
    else {
        response = await putExercise(editedExerciseID, exercise);
        document.getElementById("paragraph" + editedExerciseID).innerHTML = exercise["name"];
    }
    currentPage = VIEWER_PAGE;
    switchToViewerArea();
}

async function deleteExerciseHandler(buttonElement) {
    exerciseID = buttonElement.id.replace('exerciseChange', '');
    response = await deleteExercise(exerciseID);
    buttonElement.value = 'restore';
    buttonElement.innerHTML = 'Restore';
}

async function restoreExerciseHandler(buttonElement) {
    exerciseID = buttonElement.id.replace('exerciseChange', '');
    response = await restoreExercise(exerciseID);
    buttonElement.value = 'delete';
    buttonElement.innerHTML = 'Delete';
}


function getExerciseFromPage() {
    var exercise = {};
    exercise["name"] = document.getElementById("nameInput").value;
    exercise["videoURL"] = document.getElementById("linkInput").value;
    exercise["duration"] = document.getElementById("durationInput").value;
    exercise["instructions"] = document.getElementById("instructionsInput").value;
    var locations = [], muscles = [];
    
    for (locationCheckbox of document.getElementById("locationCheckboxes").children) {
        if (locationCheckbox.checked) {
            locations.push(locationCheckbox.id.replace(/location/g, ""));
        }
    }

    for (muscleCheckbox of document.getElementById("muscleCheckboxes").children) {
        if (muscleCheckbox.checked) {
            muscles.push(muscleCheckbox.id.replace(/muscle/g, ""));
        }
    }
    exercise["locations"] = locations;
    exercise["muscles"] = muscles;
    return exercise;
}

async function appendExerciseToPage(exerciseID, exerciseName, wasDeleted) {
    var exerciseElement = 
        `<li id=listItem"` + exerciseID + `"> 
        <p id="paragraph` + exerciseID + `" class="list-area__paragraph list-area__paragraph--left">` + exerciseName + `</p> 
        <form class="list-area__form">
            <button id="exerciseEdit` + exerciseID +`" class="list-area__button list-area__button--view" type="button">Edit</button>
            ` + await getExerciseButton(exerciseID, wasDeleted) + `
        </form>
        </li>`;
    exerciseListElement.innerHTML += exerciseElement;
}

async function initialize() {
    var exercisesList = await getExercises();
    for (var exercise of exercisesList) {
        await (async function () {
            await appendExerciseToPage(exercise["id"], exercise["name"], exercise["wasDeleted"]);
        }()); 
    }
    setListBackgroundColour("list-area__list", "");
}

async function getExerciseButton(exerciseID, wasDeleted) {
    if (wasDeleted) {
        return `<button id="exerciseChange` + exerciseID + `" class="list-area__button list-area__button--delete" value="restore" type="button">Restore</button>`;
    }
    else {
        return `<button id="exerciseChange` + exerciseID + `" class="list-area__button list-area__button--delete" value="delete" type="button">Delete</button>`;
    }
}


initialize();
editorBtn.addEventListener('click', newExercise);
exercisesBtn.addEventListener('click', discardChanges);
saveBtn.addEventListener('click', saveExercise);
exerciseListElement.addEventListener('click', function(event) {
    event.preventDefault();
    if (event.target.id.includes('exerciseChange')) {
        if (event.target.value == 'restore') {
            restoreExerciseHandler(event.target);
        }
        else {
            deleteExerciseHandler(event.target);
        }
    }
    else if (event.target.id.includes('exerciseEdit')) {
        editExercise(event.target.id.replace('exerciseEdit', ''));
    }
})