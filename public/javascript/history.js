async function getWorkouts(sortBy) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID + "/workouts/history?order=" + sortBy;
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': loginKey
        },
    });
    const responseBody = await response.json();
    console.log(responseBody);
    if (responseBody["statusCode"]) {
        setCookie("errorMessage", encodeURIComponent(responseBody["description"]));
        window.location.href = "/project/public/errorMessage";
    }
    return responseBody["description"];
}

function addWorkoutsToPage(workouts) {
    var workoutList = document.getElementById("workoutList");
    workoutList.innerHTML = '';
    for (var workout of workouts) {
        var newElement = `
        <li id="listWorkout` + workout["workoutID"] + `"> 
            <p class="list-area__paragraph list-area__paragraph--left">` + workout["workoutName"] +`</p>
            <p class="list-area__paragraph">` + workout["dateCompleted"] + `</p> 
            <form class="list-area__form">
                <button id="workoutStartButton" value="` + workout["workoutID"] + `" class="list-area__button list-area__button--start" type="button">Start</button>
                <button id="workoutViewButton" value="` + workout["workoutID"] + `" class="list-area__button list-area__button--view" type="button">View</button>
            </form>
        </li>`;
        
        
        workoutList.innerHTML += newElement;
    }
    setListBackgroundColour("list-area__list", "");
}

async function switchSort(sortBy) {
    var workouts = await getWorkouts(sortBy);
    console.log(workouts);
    addWorkoutsToPage(workouts);
}

function initializePage() {
    switchSort("desc");
}

initializePage();

document.getElementById("workoutList").addEventListener("click", function(event) {
    if (event.target.id == "workoutStartButton") {
        window.location.href = "/project/public/workouts/run/" + event.target.value;
    }
    else if (event.target.id == "workoutViewButton") {
        window.location.href = "/project/public/workouts/edit/" + event.target.value;
    }
})


comboBox.addEventListener("change", function() {
    switchSort(comboBox.value);
})

