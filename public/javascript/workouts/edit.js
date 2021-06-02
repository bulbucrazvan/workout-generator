
async function getWorkout(userID, workoutID) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID + "/workouts/" + workoutID;
    var response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    var responseBody = await response.json();
    return responseBody["description"];
}

async function putWorkout(workout, workoutID) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID + "/workouts/" + workoutID;
    const response = await fetch(uri, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(workout)
    });
    const responseBody = await response;
    return responseBody["description"];
}

async function deleteWorkout(workoutID) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID + "/workouts/" + workoutID;
    const response = await fetch(uri, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
    });
    const responseBody = await response;
    return responseBody["description"];
}

async function initializePage() {
    var workout = await getWorkout(userID, workoutID);
    document.getElementById("workoutNameLabel").innerHTML = workout["name"];
    for (exercise of workout["exercises"]) {
        addExerciseToWorkout(exercise["id"], exercise["name"]);
    }
}

initializePage();

document.getElementById("putBtn").addEventListener('click', async function(event) {
    event.preventDefault();
    var workout = getWorkoutFromPage();
    await putWorkout(workout, workoutID);
    window.location.href = '/project/public/workouts';
});

document.getElementById("deleteBtn").addEventListener('click', async function(event) {
    event.preventDefault();
    await deleteWorkout(workoutID);
    window.location.href = '/project/public/workouts';
});