document.getElementById('generateAnotherBtn').addEventListener('click', function() {
    window.location.href = '/project/public/workouts/generate';
})

function initializePage() {
    exercises = JSON.parse(workout);
    for (exercise of exercises) {
        addExerciseToWorkout(exercise["id"], exercise["name"]);
    }
}

initializePage();
