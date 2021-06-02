var workoutExercises = workout['exercises'];
var currentExercise = 0;
var canRun = 0;
var exerciseTimer;

async function getExercise(exerciseID) {
    var uri = 'http://92.115.143.213:3000/project/api/exercises/' + exerciseID;
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

async function completeWorkout() {
    var uri = 'http://92.115.143.213:3000/project/api/users/' + userID + '/workouts/' + workout['id'] + '/complete';
    const response = await fetch(uri, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const responseBody = await response.json();
    return responseBody["description"];
}

var TimerObject = (function(time) {
    
    var myTimer;
    var startingTime = time;
    var remainingTime = time;

    function start() {
        myTimer = setInterval(stopwatch, 1000);

        function stopwatch() {
            document.getElementById('remainingTime').innerHTML = --remainingTime;
            if (remainingTime == 0) {
                clearInterval(myTimer);
                document.getElementById('remainingTime').innerHTML = "Done!";
            }
        }
    }

    function pause() {
        clearInterval(myTimer);
    }

    function stop() {
        clearInterval(myTimer);
        document.getElementById('remainingTime').innerHTML = startingTime;
        remainingTime = startingTime;
    }

    this.start = start;
    this.pause = pause;
    this.stop = stop;
})

function showExercise(exercise) {
    document.getElementById('exerciseName').innerHTML = exercise['name'];
    document.getElementById('exerciseInstructions').innerHTML = exercise['instructions'];
    document.getElementById('remainingTime').innerHTML = exercise['duration'];
    document.getElementById('videoURL').src = exercise['videoURL'];
}

function showButtons(exerciseIndex) {
    document.getElementById('previousExercise').classList.remove('button-area__button--hidden');
    document.getElementById('nextExercise').classList.remove('button-area__button--hidden');
    document.getElementById('finish').classList.add('button-area__button--hidden');
    if (!exerciseIndex) {
        document.getElementById('previousExercise').classList.add('button-area__button--hidden');
    }
    else if (exerciseIndex == (workoutExercises.length - 1)) {
        document.getElementById('nextExercise').classList.add('button-area__button--hidden');
        document.getElementById('finish').classList.remove('button-area__button--hidden');
    }
}

async function switchExercise(exerciseIndex) {
    var exercise = await getExercise(workoutExercises[exerciseIndex]['id']);
    showExercise(exercise);
    showButtons(exerciseIndex);
    if (exerciseTimer) {
        exerciseTimer.stop();
    }
    exerciseTimer = new TimerObject(exercise['duration']);
}

document.getElementById('previousExercise').addEventListener('click', function() {
    currentExercise -= 1;
    switchExercise(currentExercise);
})

document.getElementById('nextExercise').addEventListener('click', function() {
    currentExercise += 1;
    switchExercise(currentExercise);
})

document.getElementById('finish').addEventListener('click', async function() {
    response = await completeWorkout();
    if (!response['statusCode']) {
        window.alert('Workout completed.');
        window.location.href = '/project/public/home';
    }
})

document.getElementById('startBtn').addEventListener('click', function() { exerciseTimer.start(); });
document.getElementById('pauseBtn').addEventListener('click', function() { exerciseTimer.pause(); });
document.getElementById('stopBtn').addEventListener('click', function() { exerciseTimer.stop(); })

async function initializePage() {
    switchExercise(currentExercise);
}

initializePage();