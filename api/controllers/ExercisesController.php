<?php
    require_once(__DIR__."/../models/Exercise.php");
    require_once(__DIR__."/../models/DTO/ExerciseDTO.php");

    class ExercisesController extends Controller {
        
        //GET: /exercises -- gets names of all exercises
        public function getExercises() {
            $queryStatement = $this->databaseConnection->prepare("SELECT name, wasDeleted FROM exercises");
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            $exercises = array();

            while ($row = $result->fetch_assoc()) {
            
                array_push($exercises, new ExerciseDTO($row["name"], $row["wasDeleted"]));
            }

            http_response_code(200);
            echo json_encode($exercises);
        }

        //POST: /exercises -- adds exercise
        public function addExercise($params, $queryParams, $requestBody) {
            if (!is_array($requestBody->locations) || !is_array($requestBody->muscles)) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad request body"));
                die();
            }

            $locationIDs= $this->getLocationIDs($requestBody->locations);
            if ($locationIDs === false || !count($locationIDs)){
                http_response_code(400);
                echo json_encode(new Response(1, "Bad location names"));
                die();
            }

            $muscleIDs= $this->getMuscleIDs($requestBody->muscles);
            if ($muscleIDs === false || !count($muscleIDs)){
                http_response_code(400);
                echo json_encode(new Response(1, "Bad muscle names"));
                die();
            }

            $addExerciseStatement = "INSERT INTO exercises VALUES (NULL, ?, ?, ?, ?, 0)";
            $queryStatement = $this->databaseConnection->prepare($addExerciseStatement);
            $queryStatement->bind_param('sssi', $requestBody->name, $requestBody->instructions, $requestBody->videoURL, $requestBody->duration);
            $queryStatement->execute();

            $exerciseId = $this->getExerciseId($requestBody->name);
            $this->addExerciseAssociations($locationIDs, $muscleIDs, $exerciseId);

            http_response_code(201);
            echo json_encode(new Response(0, $exerciseId));
        }

        //GET: /exercises/{exerciseName} - gets all details about an exercise
        public function getExercise($params, $queryParams, $requestBody) {
            $exerciseName = urldecode($params["exerciseName"]);
            $queryStatement = $this->databaseConnection->prepare("SELECT * FROM exercises WHERE name = ?");
            $queryStatement->bind_param('s', $exerciseName);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                echo $queryStatement->error;
                $exercise = new Exercise();
                foreach ($row as $key => $value) {
                    $exercise->setInfo($key, $value);
                }
                $exercise->setInfo("locations", $this->getExerciseLocations($row["id"]));
                $exercise->setInfo("muscles", $this->getExerciseMuscles($row["id"]));
                http_response_code(200);
                echo json_encode($exercise);
            }
            else {
                http_response_code(404);
                echo json_encode(new Response(1, "Not found"));
            }
        }

        //PUT: /exercises/{exerciseName} - update an exercise
        public function updateExercise($params, $queryParams, $requestBody) {
            if (!is_array($requestBody->locations) || !is_array($requestBody->muscles)) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad request body"));
                die();
            }

            $locationIDs= $this->getLocationIDs($requestBody->locations);
            if ($locationIDs === false || !count($locationIDs)) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad location names"));
                die();
            }

            $muscleIDs= $this->getMuscleIDs($requestBody->muscles);
            if ($muscleIDs === false || !count($muscleIDs)) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad muscle names"));
                die();
            }

            $exerciseId = $this->getExerciseId(urldecode($params["exerciseName"]));
            if ($exerciseId) {
                $updateExerciseStatement = "
                UPDATE exercises 
                SET
                    name = ?,
                    instructions = ?,
                    videoURL = ?,
                    duration = ?
                WHERE id = ?;";
                $queryStatement = $this->databaseConnection->prepare($updateExerciseStatement);
                $queryStatement->bind_param("sssii", $requestBody->name, $requestBody->instructions, $requestBody->videoURL, $requestBody->duration, $exerciseId);
                $queryStatement->execute();
                $this->updateExerciseAssociations($exerciseId, $locationIDs, $muscleIDs);
                http_response_code(200);
                echo json_encode(new Response(0, "Exercise modified."));
            }
            else {
                http_response_code(400);
                echo json_encode(new Response(1, "Exercise doesn't exist."));
            }
        }

        //DELETE: /exercises/{exerciseName} -- delete an exercise
        public function deleteExercise($params, $queryParams, $requestBody) {
            $exerciseName = urldecode($params["exerciseName"]);
            $deleteExerciseStatement = "UPDATE exercises SET wasDeleted = 1 WHERE name = ?";
            $queryStatement = $this->databaseConnection->prepare($deleteExerciseStatement);
            $queryStatement->bind_param('s', $exerciseName);
            if ($queryStatement->execute()) {
                http_response_code(200);
                echo json_encode(new Response(0, "Exercise marked as deleted."));
            }
            else {
                http_response_code(404);
                echo json_encode(new Response(0, "Exercise doesn't exist"));
            }
        }

        //GET: /exercises/locationTypes -- gets locations where exercises can be performed
        public function getLocationTypes($params, $queryParams, $requestBody) {
            $queryStatement = $this->databaseConnection->prepare('SELECT location FROM locations');
            $queryStatement->execute();
            $result = $queryStatement->get_result();

            $locations = array();
            while ($row = $result->fetch_assoc()) {
                array_push($locations, $row["location"]);
            }

            http_response_code(200);
            echo json_encode($locations);
        }

        //GET: /exercises/muscleTypes -- gets muscle groups that exercises can work
        public function getMuscleTypes($params, $queryParams, $requestBody) {
            $queryStatement = $this->databaseConnection->prepare('SELECT muscleGroup FROM muscle_groups');
            $queryStatement->execute();
            $result = $queryStatement->get_result();

            $muscleGroups = array();
            while ($row = $result->fetch_assoc()) {
                array_push($muscleGroups, $row["muscleGroup"]);
            }

            http_response_code(200);
            echo json_encode($muscleGroups);
        }

        private function getLocationIDs($locations) {
            $locationIDs = array();
            $getLocationStatement = "SELECT id FROM locations WHERE location = ?";
            $queryStatement = $this->databaseConnection->prepare($getLocationStatement);

            foreach ($locations as $location) {
                $queryStatement->bind_param('s', $location);
                $queryStatement->execute();
                $result = $queryStatement->get_result();
                if ($result->num_rows) {
                    $row = $result->fetch_assoc();
                    array_push($locationIDs, $row["id"]);
                }
                else {
                    return false;
                }
            }
            return $locationIDs;
        }

        private function getMuscleIDs($muscles) {
            $muscleIDs = array();
            $getMuscleStatement = "SELECT id FROM muscle_groups WHERE muscleGroup = ?";
            $queryStatement = $this->databaseConnection->prepare($getMuscleStatement);

            foreach ($muscles as $muscle) {
                $queryStatement->bind_param('s', $muscle);
                $queryStatement->execute();
                $result = $queryStatement->get_result();
                if ($result->num_rows) {
                    $row = $result->fetch_assoc();
                    array_push($muscleIDs, $row["id"]);
                }
                else {
                    return false;
                }
            }
            return $muscleIDs;
        }

        private function addExerciseAssociations($locationIDs, $muscleIDs, $exerciseId) {
            $addLocationAssociationStatement = "INSERT INTO exercise_locations VALUES (?, ?)";
            $addMuscleAssociationStatement = "INSERT INTO exercise_worked_muscles VALUES (?, ?)";

            $queryStatement = $this->databaseConnection->prepare($addLocationAssociationStatement);
            foreach ($locationIDs as $locationID) {
                $queryStatement->bind_param('ii', $exerciseId, $locationID);
                $queryStatement->execute();
            }
            $queryStatement->close();

            $queryStatement = $this->databaseConnection->prepare($addMuscleAssociationStatement);
            foreach ($muscleIDs as $muscleID) {
                $queryStatement->bind_param('ii', $exerciseId, $muscleID);
                $queryStatement->execute();
            }
            $queryStatement->close();
        }

        private function updateExerciseAssociations($exerciseId, $locationIDs, $muscleIDs) {
            if (count($locationIDs)) {
                $this->deleteLocationAssociations($exerciseId);
            }
            if (count($muscleIDs)) {
                $this->deleteMuscleAssociations($exerciseId);
            }
            $this->addExerciseAssociations($locationIDs, $muscleIDs, $exerciseId);
        }

        private function getExerciseId($exerciseName) {
            $getExerciseIdStatement = "SELECT id FROM exercises WHERE name = ?";
            $queryStatement = $this->databaseConnection->prepare($getExerciseIdStatement);
            $queryStatement->bind_param('s', $exerciseName);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                return $row["id"];
            }
            return null;
        }

        private function deleteMuscleAssociations($exerciseId) {
            $deleteMuscleAssociationStatement = "DELETE FROM exercise_worked_muscles WHERE exerciseID = ?";
            $queryStatement = $this->databaseConnection->prepare($deleteMuscleAssociationStatement);
            $queryStatement->bind_param('i', $exerciseId);
            $queryStatement->execute();
        }

        private function deleteLocationAssociations($exerciseId) {
            $deleteLocationAssociationStatement = "DELETE FROM exercise_locations WHERE exerciseID = ?";
            $queryStatement = $this->databaseConnection->prepare($deleteLocationAssociationStatement);
            $queryStatement->bind_param('i', $exerciseId);
            $queryStatement->execute();
        }

        private function getExerciseLocations($exerciseId) {
            $exerciseLocations = array();
            $getExerciseLocationStatement = "SELECT location FROM locations l JOIN exercise_locations a ON l.id=a.locationID JOIN exercises e ON a.exerciseID=e.id WHERE e.id = ?";
            $queryStatement = $this->databaseConnection->prepare($getExerciseLocationStatement);
            $queryStatement->bind_param('i', $exerciseId);
            $queryStatement->execute();
            $result = $queryStatement->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($exerciseLocations, $row["location"]);
            }
            return $exerciseLocations;
        }

        private function getExerciseMuscles($exerciseId) {
            $exerciseMuscles = array();
            $getExerciseMuscleStatement = "SELECT muscleGroup FROM muscle_groups m JOIN exercise_worked_muscles a ON m.id=a.workedMuscleID JOIN exercises e ON a.exerciseID=e.id WHERE e.id = ?";
            $queryStatement = $this->databaseConnection->prepare($getExerciseMuscleStatement);
            $queryStatement->bind_param('i', $exerciseId);
            $queryStatement->execute();
            $result = $queryStatement->get_result();

            while ($row = $result->fetch_assoc()) {
                array_push($exerciseMuscles, $row["muscleGroup"]);
            }
            return $exerciseMuscles;
        }

    }

?>