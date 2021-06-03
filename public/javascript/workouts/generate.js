async function sendParameters(parameters) {
    var uri = 'http://92.115.143.213:3000/project/api/users/"' + userID + '"/workouts/generate';
    const response = await fetch(uri, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': loginKey
        },
        body: JSON.stringify(parameters)
    })
    const responseBody = await response.json();
    return responseBody;
}

function getMuscleCheckboxes() {
    var checkedMuscles = [];
    var muscleCheckboxes = document.getElementsByName('muscle');
    for (var i = 0; i < muscleCheckboxes.length; i++) {
        if (muscleCheckboxes[i].checked) {
            checkedMuscles.push(muscleCheckboxes[i].value);
        }
    }
    return checkedMuscles;
}

function getParametersFromPage() {
    var parameters = {};
    
    parameters['muscleGroups'] = getMuscleCheckboxes();
    if (!parameters['muscleGroups'].length) {
        window.alert('At least one group of muscles must be checked');
        return null;
    }
    
    var locationRadios = document.getElementsByName('location');
    for (var i = 0; i < locationRadios.length; i++) {
        if (locationRadios[i].checked) {
            parameters['location'] = locationRadios[i].value;
            break;
        }
    }
    if (!('location' in parameters)) {
        window.alert('One location must be checked.');
        return null;
    }

    var durationRadios = document.getElementsByName('time');
    for (var i = 0; i < durationRadios.length; i++) {
        if (durationRadios[i].checked) {
            parameters['durationRange'] = durationRadios[i].value;
            break;
        }
    }
    if (!('durationRange' in parameters)) {
        window.alert('One duration range must be checked.');
        return null;
    }

    return parameters;
}

async function generateWorkout() {
    var parameters = getParametersFromPage();
    if (!parameters) {
        return;
    }
    else {
        response = await sendParameters(parameters);
        if (response['statusCode']) {
            window.alert(response['description']);
        }
        else {
            window.location.href = '/project/public/workouts/generatedWorkout/' + JSON.stringify(response['description']);
        }
    }
    
}

document.getElementById('generateBtn').addEventListener('click', generateWorkout);