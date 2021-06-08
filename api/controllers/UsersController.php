<?php
    class UsersController extends Controller {
        // GET: /users - returns all users
        public function getUsers($params, $queryParams, $requestBody) {
            $queryStatement = $this->databaseConnection->prepare("SELECT * FROM users");
            $queryStatement->execute();
            $result = $queryStatement->get_result();

            require_once("../models/User.php");
            $receivedUsers = array();
            while ($receivedUser = $result->fetch_assoc()) {
                $userObject = new User();
                foreach ($receivedUser as $key => $value) {
                    $userObject->setInfo($key, $value);
                }
                array_push($receivedUsers, $userObject);
            }

            http_response_code(200);
            echo json_encode(new Response(0, $receivedUsers));
        }

        // POST: /users - add a user to the database, requires a UserRegisterModel object as requestBody
        public function addUser($params, $queryParams, $requestBody) {
            
            $checkCredentials = array("username", "email");
            $userStatus = 0;

            foreach ($checkCredentials as $credential) {
                $checkUserStatement = "SELECT EXISTS(SELECT * FROM users WHERE $credential = ?)";
                $queryStatement = $this->databaseConnection->prepare($checkUserStatement);
                $queryStatement->bind_param('s', $requestBody->$credential);
                $queryStatement->execute();
                $queryResult = $queryStatement->get_result()->fetch_row();
                $userStatus += $queryResult[0];
                if ($credential == "email" && $queryResult[0]) {
                    $userStatus += 1;
                } 
            }
            
            if ($userStatus) {
                http_response_code(400);
                echo json_encode(new Response($userStatus, "Username or email already in use."));
                die();
            }

            $addUserStatement = "INSERT INTO users VALUES (NULL, ?, ?, ?, NULL, NULL, NULL, '0', '0', '0', '0', '0', NULL)";
            $queryStatement = $this->databaseConnection->prepare($addUserStatement);
            $queryStatement->bind_param('sss', $requestBody->email, $requestBody->username, $requestBody->password);
            $queryStatement->execute();

            // http_response_code(201);
            // echo json_encode(new Response($userStatus, "Successfully created user."));
            $queryParams["username"] = $requestBody->username;
            $queryParams["password"] = $requestBody->password;
            $this->login('', $queryParams, '');
            
        }

         //GET: /users/ranking?rankBy=[currentStreak/longestStreak/completedWorkouts]
         public function getUserRankings($params, $queryParams, $requestBody) {
            $rankBy = $queryParams["rankBy"];
            $getUserRankingStatement = "SELECT username, $rankBy FROM users ORDER BY $rankBy DESC";
            if ($queryStatement = $this->databaseConnection->prepare($getUserRankingStatement)) {
                $queryStatement->execute();
                $result = $queryStatement->get_result();
                $receivedRanking = array();
                while ($row = $result->fetch_assoc()) {
                    $user["username"] = $row["username"];
                    $user[$rankBy] = $row[$rankBy];
                    array_push($receivedRanking, $user); 
                }
                http_response_code(200);
                echo json_encode(new Response(0, $receivedRanking));
            }   
            else {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad ranking parameter."));
            }
        }

        //GET: /users/{userID} -- gets the details of user
        public function getUser($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            $queryStatement = $this->databaseConnection->prepare("SELECT username, email, gender, dateOfBirth, height, weight, currentStreak, longestStreak, workoutsCompleted, canCreate FROM users WHERE id = ?");
            $queryStatement->bind_param('i', $params["userID"]);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
             
            require_once("../models/User.php");
            $row = $result->fetch_assoc();
            $user = new User();
            foreach ($row as $key => $value) {
                $user->setInfo($key, $value);
            }
            if ($row["gender"]) {
                $user->setInfo("gender", "Male");
            }
            else {
                $user->setInfo("gender", "Female");
            }
        
            http_response_code(200);
            echo json_encode(new Response(0, $user));
        }

        //PUT: /users/{userID} -- updates user
        public function updateUser($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);
            if (!$requestBody->type) {
                if (!strtotime($requestBody->dateOfBirth)) {
                    http_response_code(400);
                    echo json_encode(new Response(2, "Bad DOB"));
                    die();
                }
                if (!$this->inRange($requestBody->height, 50, 300) || !$this->inRange($requestBody->weight, 30, 250)) {
                    http_response_code(400);
                    echo json_encode(new Response(3, "Bad weight or height"));
                    die();
                }
                $date = new DateTime($requestBody->dateOfBirth);
                $mySQLDate = $date->format('Y-m-d');
                $queryStatement = $this->databaseConnection->prepare("UPDATE users
                                                                      SET gender = ?, dateOfBirth = ?, height = ?, weight = ?
                                                                      WHERE id = ?
                                                                      ");
                $queryStatement->bind_param('isiii', $requestBody->gender, $mySQLDate, $requestBody->height, $requestBody->weight, $params["userID"]);
                $queryStatement->execute();
                http_response_code(200);
                echo json_encode(new Response(0, "Successfully updated"));
            }
            else {
                $responseString = "";
                if ($requestBody->type == 1 || $requestBody->type == 3) {
                    if (!$this->checkUserPassword($params["userID"], $requestBody->oldPassword)) {
                        http_response_code(403);
                        echo json_encode(new Response(1, "Wrong password."));
                        die();
                    }
                    $queryStatement = $this->databaseConnection->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $queryStatement->bind_param('si', $requestBody->newPassword, $params["userID"]);
                    $queryStatement->execute();
                    $responseString .= "Password updated. ";
                }
                if ($requestBody->type == 2 || $requestBody->type == 3) {
                    $queryStatement = $this->databaseConnection->prepare("UPDATE users SET email = ? WHERE id = ?");
                    $queryStatement->bind_param('si', $requestBody->email, $params["userID"]);
                    $queryStatement->execute();
                    $responseString .= "Email updated.";
                }
                http_response_code(200);
                echo json_encode(new Response(0, $responseString));
            }
        }

        //GET: /users/{userID}/workouts -- gets user workouts(name and id)
        public function getWorkouts($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            $queryStatement = $this->databaseConnection->prepare("SELECT workoutID, name FROM workouts WHERE userID = ? AND wasDeleted = 0");
            $queryStatement->bind_param('i', $params["userID"]);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            $workouts = array();
            require_once("../models/DTO/WorkoutDTO.php");
            while ($row = $result->fetch_assoc()) {
                $workout = new WorkoutDTO($row["name"], $row["workoutID"]);
                array_push($workouts, $workout);
            }
            http_response_code(200);
            echo json_encode(new Response(0, $workouts));
        }

        //POST: /users/{userID}/workouts -- post new workout
        public function addWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!count($requestBody->exercises)) {
                http_response_code(400);
                echo json_encode(new Response(1, "Workout needs to have at least 1 exercise."));
            }

            $exercises = $requestBody->exercises;
            $duration = $this->getExercisesDuration($exercises);
            $workoutName = $this->constructWorkoutName($requestBody->workoutName, $params["userID"]);
            $addWorkoutStatement = "INSERT INTO workouts VALUES (NULL, ?, ?, $duration, 0)";
            $queryStatement = $this->databaseConnection->prepare($addWorkoutStatement);
            $queryStatement->bind_param('is', $params["userID"], $workoutName);
            if (!$queryStatement->execute()) {
                echo json_encode(new Response(2, "Workout with this name already exists"));
                die();
            }

            $workoutID = $this->getWorkoutID($workoutName);
            $this->addWorkoutExercisesAssociations($workoutID, $exercises);

            http_response_code(201);
            echo json_encode(new Response(0, $workoutID));
        }

        //GET: /users/{userID}/workouts/{workoutID} -- get workout
        public function getWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!is_numeric($params["workoutID"])) {
                http_response_code(400);
                echo json_encode(new Response(2, "Bad workoutID"));
                die();
            }
            $userID = $params["userID"];
            $workoutID = $params["workoutID"];
            $queryStatement = $this->databaseConnection->prepare("SELECT name, duration, wasDeleted 
                                                                  FROM workouts 
                                                                  WHERE workoutID = $workoutID
                                                                  AND userID = $userID");
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                require_once("../models/Workout.php");
                $workout = new Workout();
                foreach ($row as $key => $value) {
                    $workout->setInfo($key, $value); 
                }
                $workout->setInfo("id", $workoutID);
                $workout->setInfo("exercises", $this->getWorkoutExercises($workoutID));
                http_response_code(200);
                echo json_encode(new Response(0, $workout));
            }
            else {
                http_response_code(404);
                echo json_encode(new Response(1, "Workout not found"));
            }
        }

        //PUT: /users/{userID}/workouts/{workoutID} -- updates workout
        public function updateWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!is_numeric($params["workoutID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad workoutID"));
                die();
            }
            if (!count($requestBody->exercises)) {
                http_response_code(400);
                echo json_encode(new Response(2, "Workout needs to have at least 1 exercise."));
                die();
            }

            $workoutID = $params["workoutID"];
            $userID = $params["userID"];
            if (!$this->checkWorkoutBelongsToUser($userID, $workoutID)) {
                http_response_code(403);
                echo json_encode(new Response(3, "Workout doesn't belong to user"));
                die();
            }

            $duration = $this->getExercisesDuration($requestBody->exercises);
            if ($requestBody->workoutName) {
                $queryStatement = $this->databaseConnection->prepare("UPDATE workouts
                                                                      SET name = ?, duration = $duration
                                                                      WHERE workoutID = $workoutID");
                $queryStatement->bind_param('s', $requestBody->workoutName);
                $queryStatement->execute();
            }
            else {
                $this->databaseConnection->prepare("UPDATE workouts
                                                    SET duration = $duration
                                                    WHERE workoutID = $workoutID");
            }

            $this->updateWorkoutExercises($workoutID, $requestBody->exercises);
            http_response_code(200);
            echo json_encode(new Response(0, "Successfuly updated"));
        }

        //DELETE: /users/{userID}/workouts/{workoutID}
        public function deleteWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!is_numeric($params["workoutID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad workoutID"));
                die();
            }
            $userID = $params["userID"];
            $workoutID = $params["workoutID"];
            $queryStatement = $this->databaseConnection->prepare("UPDATE workouts
                                                                  SET wasDeleted = 1
                                                                  WHERE workoutID = $workoutID
                                                                  AND userID = $userID");
            $queryStatement->execute();
            if ($this->databaseConnection->affected_rows) {
                http_response_code(200);
                echo json_encode(new Response(0, "Marked as deleted."));
            }
            else {
                http_response_code(404);
                echo json_encode(new Response(2, "Workout doesn't exist or doesn't belong to userID"));
            }
        }

        //GET: /users/{userID}/workouts/history?order=[asc/desc]$limit=[]
        public function getWorkoutHistory($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!is_numeric($queryParams["limit"]) || $queryParams["limit"] < 0) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad limit"));
                die();
            }

            $order = $queryParams["order"];
            $limit = $queryParams["limit"];
            $getWorkoutHistoryStatement = "SELECT w.workoutID, w.name, h.dateCompleted FROM workouts w 
                                           JOIN workout_history h ON w.workoutID=h.workoutID AND w.userID = h.userID
                                           WHERE h.userID = ?  
                                           ORDER BY h.dateCompleted $order";
            if ($limit) {
                $getWorkoutHistoryStatement .= " LIMIT $limit";
            }
            if ($queryStatement = $this->databaseConnection->prepare($getWorkoutHistoryStatement)) {
                $queryStatement->bind_param('i', $params["userID"]);
                $queryStatement->execute();
                $result = $queryStatement->get_result();
                $receivedWorkouts = array();
                require_once("../models/DTO/WorkoutHistoryDTO.php");
                while ($row = $result->fetch_assoc()) {
                    $dateCompleted = new DateTime($row["dateCompleted"]);
                    $workout = new WorkoutDTO($row["name"], $row["workoutID"], $dateCompleted->format('Y-m-d'));
                    array_push($receivedWorkouts, $workout);
                }
                http_response_code(200);
                echo json_encode(new Response(0, $receivedWorkouts));
            }
            else {
                http_response_code(400);
                echo json_encode(new Response(2, "Bad order"));
            }
            
        }

        //GET: /users/login - checks user credentials on login, returns loginkey
        public function login($params, $queryParams, $requestBody) {
            $getUserStatement = 'SELECT id, username, password FROM users WHERE username = ?';
            $queryStatement = $this->databaseConnection->prepare($getUserStatement);
            $queryStatement->bind_param('s', $queryParams["username"]);
            $queryStatement->execute();
            
            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $user = $result->fetch_assoc();
                if ($user["password"] == $queryParams["password"]) {
                    http_response_code(200);
                    $loginKey = $this->generateLoginKey($user["id"]);
                    echo json_encode(new Response(0, $loginKey));
                    die();
                }
            }
            
            http_response_code(400);
            echo json_encode(new Response(1, "Wrong credentials."));

        }

        //GET: /users/login/loginKeyUser - returns userID corresponding with the loginkey
        public function loginKeyUser($params, $queryParams, $requestBody) {
            $getUserStatement = 'SELECT userID FROM user_login_keys WHERE loginKey = ?';
            $queryStatement = $this->databaseConnection->prepare($getUserStatement);
            $queryStatement->bind_param('s', $queryParams["loginKey"]);
            $queryStatement->execute();

            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                $userID = $row["userID"];
                $result = $this->databaseConnection->query("SELECT role FROM users WHERE id = $userID");
                $row = $result->fetch_assoc();
                http_response_code(200);
                $response = ["userID" => $userID, "userRole" => (int)$row["role"]];
                echo json_encode(new Response(0, $response));
                die();
            }

            http_response_code(400);
            echo json_encode(new Response(1, "Invalid login key."));
        }

        //POST: /users/{userID}/workouts/{workoutID}/completed
        public function completeWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            if (!$this->checkWorkoutBelongsToUser($params["userID"], $params["workoutID"])) {
                http_response_code(403);
                echo json_encode(new Response(1, "Workout doesn't belong to user"));
            }
            $currentDate = new DateTime();
            $mySQLDate = $currentDate->format('Y-m-d H:i:s');
            $queryStatement = $this->databaseConnection->prepare("INSERT INTO workout_history VALUES (?, ?, ?)");
            $queryStatement->bind_param('iis', $params["userID"], $params["workoutID"], $mySQLDate);
            $queryStatement->execute();
            $this->updateWorkoutCount($params["userID"]);
            http_response_code(201);
            echo json_encode(new Response(0, "Successfully inserted"));  
        }


        //POST: /users/{userID}/workouts/generate
        public function generateWorkout($params, $queryParams, $requestBody) {
            $this->checkAuthorized($params["userID"], false);

            $range = $this->getDurationRange($requestBody->durationRange);
            $maxRange = $range['max'];
            $currentDuration = 0;
            $exercises = array(0);
            $chosenExercises = array();
            require_once(__DIR__ . "/../models/DTO/ExerciseDTO.php");
            while (!$this->inRange($currentDuration, $range['min'], $range['max'])) {
                $notInString = implode(",", $exercises);
                $result = $this->databaseConnection->query("SELECT id, duration, name, wasDeleted
                                                            FROM exercises
                                                            WHERE id NOT IN($notInString)
                                                            AND ($currentDuration + duration < $maxRange)");
                if ($result->num_rows) {
                    $pickedExercise = rand(1, $result->num_rows);
                    $row;
                    for ($i = 0; $i < $pickedExercise; $i++) {
                        $row = $result->fetch_assoc();
                    }
                    array_push($exercises, $row["id"]);
                    if ($this->exerciseFitsLocationAndMuscles($row["id"], $requestBody->location, $requestBody->muscleGroups)) {
                        array_push($chosenExercises, new ExerciseDTO($row["id"], $row["name"], $row["wasDeleted"]));
                        $currentDuration += $row["duration"];
                    }    
                }
                else {
                    http_response_code(500);
                    echo json_encode(new Response(1, "Could not generate workout within given range."));
                    die();
                }
            }
            http_response_code(200);
            echo json_encode(new Response(0, $chosenExercises));
        }

        private function generateLoginKey($userID) {
            $loginKey = uniqid();
            $currentTime = new DateTime();
            $mySqlTime = $currentTime->format('Y-m-d H:i:s');
            $insertKeyStatement = "INSERT INTO user_login_keys VALUES(?, ?, ?)";

            $queryStatement = $this->databaseConnection->prepare($insertKeyStatement);
            $queryStatement->bind_param('iss', $userID, $loginKey, $mySqlTime);
            $queryStatement->execute();

            return $loginKey;
        }

        private function getWorkoutID($workoutName) {
            $queryStatement = $this->databaseConnection->prepare("SELECT workoutID FROM workouts WHERE name = ?");
            $queryStatement->bind_param('s', $workoutName);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                return $row["workoutID"];
            }
            return null;
        }

        private function getExercisesDuration($exercises) {
            $totalDuration = 0;
            foreach ($exercises as $exercise) {
                $result = $this->databaseConnection->query("SELECT duration FROM exercises WHERE id = $exercise");
                $row = $result->fetch_assoc();
                $totalDuration += $row["duration"];
            }
            return $totalDuration;
        }

        private function constructWorkoutName($workoutName, $userID) {
            if ($workoutName) {
                return $workoutName;
            }
            $result = $this->databaseConnection->query("SELECT COUNT(*) FROM workouts WHERE userID = $userID");
            $row = $result->fetch_row();
            return "Workout" . $row[0];
        }

        private function getWorkoutExercises($workoutID) {
            $result = $this->databaseConnection->query("SELECT e.id, e.name, e.wasDeleted
                                                        FROM exercises e
                                                        JOIN workout_exercises a ON e.id=a.exerciseID AND e.wasDeleted = 0
                                                        JOIN workouts w ON a.workoutID=w.workoutID AND w.workoutID = $workoutID");
            $exercises = array();
            require_once("../models/DTO/ExerciseDTO.php");
            while ($row = $result->fetch_assoc()) {
                $exercise = new ExerciseDTO($row["id"], $row["name"], $row["wasDeleted"]);
                array_push($exercises, $exercise);
                
            }
            return $exercises;
        }

        private function checkWorkoutBelongsToUser($userID, $workoutID) {
            if (!is_numeric($workoutID)) {
                http_response_code(400);
                echo json_encode(new Response(10, "Bad workoutID"));
                die();
            }
            $result = $this->databaseConnection->query("SELECT EXISTS(SELECT * FROM workouts WHERE userID = $userID AND workoutID = $workoutID)");
            echo $this->databaseConnection->error;
            $row = $result->fetch_row();
            return $row[0]; 
        }

        private function addWorkoutExercisesAssociations($workoutID, $exercises) {
            $addWorkoutAssociationStatement = 'INSERT INTO workout_exercises VALUES ';
            for ($i = 0; $i < count($exercises); $i++) {
                $exercise = $exercises[$i];
                $association = "($workoutID, $exercise),";
                $addWorkoutAssociationStatement .= $association;
            };
            $addWorkoutAssociationStatement = rtrim($addWorkoutAssociationStatement, ',');
            $queryStatement = $this->databaseConnection->prepare($addWorkoutAssociationStatement);
            $queryStatement->execute();
        
        }

        private function updateWorkoutExercises($workoutID, $exercises) {
            $this->databaseConnection->query("DELETE FROM workout_exercises WHERE workoutID = $workoutID");
            $this->addWorkoutExercisesAssociations($workoutID, $exercises);
        }

        private function checkUserPassword($userID, $password) {
            $queryStatement = $this->databaseConnection->prepare("SELECT EXISTS(SELECT * FROM users WHERE id = ? AND password = ?)");
            $queryStatement->bind_param('is', $userID, $password);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            $row = $result->fetch_row();
            return $row[0];
        }

        private function inRange($value, $min, $max) {
            return ($min <= $value) && ($value <= $max);
        }

        private function updateWorkoutCount($userID) {
            $this->databaseConnection->query("UPDATE users SET
                                              currentStreak = currentStreak + 1,
                                              workoutsCompleted = workoutsCompleted + 1
                                              WHERE id = $userID 
                                              ");
            $this->databaseConnection->query("UPDATE users SET
                                              longestStreak = longestStreak + 1
                                              WHERE id = $userID AND currentStreak >= longestStreak");
        }

        private function getDurationRange($rangeID) {
            $range['min'] = 0;
            $range['max'] = 0;
            switch ($rangeID) {
                case 1:
                    $range['min'] = 10;
                    $range['max'] = 29;
                    break;
                case 2:
                    $range['min'] = 30;
                    $range['max'] = 59;
                    break;
                case 3:
                    $range['min'] = 60;
                    $range['max'] = 90;
            }
            return $range;
        }

        private function exerciseFitsLocationAndMuscles($exerciseID, $locationID, $muscles) {
            $result = $this->databaseConnection->query("SELECT EXISTS(SELECT * FROM exercise_locations
                                                                      WHERE exerciseID = $exerciseID AND locationID = $locationID)");
            echo $this->databaseConnection->error;
            $row = $result->fetch_row();
            if (!$row[0]) {
                return false;
            }
            $muscleInString = implode(",", $muscles);
            $result = $this->databaseConnection->query("SELECT EXISTS(SELECT * FROM exercise_worked_muscles
                                                                      WHERE exerciseID = $exerciseID
                                                                      AND workedMuscleID IN ($muscleInString))");
            $row = $result->fetch_row();
            return $row[0];
        }


    }

?>