let exercisesBtn = document.getElementById("exercisesBtn");
let editorBtn = document.getElementById("editorBtn");
let viewerArea = document.getElementById("viewerArea");
let editorArea = document.getElementById("editorArea");
let exerciseListElement = document.getElementById("exerciseListElement");
let saveBtn = document.getElementById("saveBtn");
var exercisesList;
var currentPage = 0, currentState;

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
    if (!currentPage) {
        currentState = 0;
        currentPage = 1;
        switchToEditorArea();
        await setExerciseDetails(null);
    }
}

async function discardChanges() {
    if (currentPage) {
        currentPage = 0;
        switchToViewerArea();
    }
}

async function editExercise(exerciseName) {
    currentPage = 1;
    currentState = 1;
    switchToEditorArea();
    exercise = await getExerciseDetails(exerciseName);
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

const getExerciseDetails = async (exerciseName) => {
    var uri = "http://92.115.143.213:3000/project/api/exercises/" + exerciseName.replace(/ /g, "%20");
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody;
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
    return responseBody;
}

async function saveExercise() {
    exercise = getExerciseFromPage();
    console.log(exercise);
}

function getExerciseFromPage() {
    var exercise = [];
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

async function initialize() {
    exercisesList = await getExercises();
    for (exercise of exercisesList) {
        var exerciseElement = 
        `<li> 
        <p class="list-area__paragraph list-area__paragraph--left">` + exercise["name"] + `</p> 
        <form class="list-area__form">
            <button id="` + exercise["name"] +`" class="list-area__button list-area__button--view" type="button">Edit</button>
            ` + await getExerciseButton(exercise) + `
        </form>
        </li>`;
        exerciseListElement.innerHTML += exerciseElement;
        document.getElementById(exercise["name"]).addEventListener('click', function(){ editExercise(exercise["name"])});
    }
    await setListBackgroundColour();
}

async function getExerciseButton(exercise) {
    if (exercise["wasDeleted"]) {
        return `<button id="` + exercise["name"] + `" class="list-area__button list-area__button--delete" type="submit">Restore</button>`;
    }
    else {
        return `<button id="` + exercise["name"] + `" class="list-area__button list-area__button--delete" type="submit">Delete</button>`;
    }
}

async function setListBackgroundColour() {
    let listItems = document.getElementsByClassName("list-area__form");

    if (listItems.length % 2 == 0){
        sheet.insertRule(".list-area__list li:nth-child(even){ background-color: rgba(0, 0, 0, 0.5); }", sheet.cssRules.length);
    }
    else {
        sheet.insertRule(".list-area__list li:nth-child(odd){ background-color: rgba(0, 0, 0, 0.5); }", sheet.cssRules.length);
    }
}

initialize();
editorBtn.addEventListener('click', newExercise);
exercisesBtn.addEventListener('click', discardChanges);
saveBtn.addEventListener('click', saveExercise);