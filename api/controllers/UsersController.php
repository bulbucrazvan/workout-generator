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
            echo json_encode($receivedUsers);
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

            http_response_code(201);
            echo json_encode(new Response($userStatus, "Successfully created user."));
            
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
                echo json_encode($receivedRanking);
            }   
            else {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad ranking parameter."));
            }
        }

        //GET: /users/{userID} -- gets the details of user
        public function getUser($params, $queryParams, $requestBody) {
            if (!is_numeric($params["userID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad userID"));
                die();
            }

            $queryStatement = $this->databaseConnection->prepare("SELECT username, email, gender, dateOfBirth, height, weight, currentStreak, longestStreak, workoutsCompleted, canCreate FROM users WHERE id = ?");
            $queryStatement->bind_param('i', $params["userID"]);
            $queryStatement->execute();
            $result = $queryStatement->get_result();
            
            if (!$result->num_rows) {
                http_response_code(404);
                echo json_encode(new Response(2, "User not found."));
                die();
            }
            
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
            echo json_encode($user);
        }

        //PUT: /users/{userID} -- updates user
        public function updateUser($params, $queryParams, $requestBody) {
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
            if (!is_numeric($params["userID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad userID"));
                die();
            }

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
            echo json_encode($workouts);
        }

        //POST: /users/{userID}/workouts -- post new workout
        public function addWorkout($params, $queryParams, $requestBody) {
            if (!is_numeric($params["userID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad userID"));
                die();
            }
            if (!count($requestBody->exercises)) {
                http_response_code(400);
                echo json_encode(new Response(2, "Workout needs to have at least 1 exercise."));
            }

            $exercises = $requestBody->exercises;
            $duration = $this->getExercisesDuration($exercises);
            $workoutName = $this->constructWorkoutName($requestBody->workoutName, $params["userID"]);
            $addWorkoutStatement = "INSERT INTO workouts VALUES (NULL, ?, ?, $duration, 0)";
            $queryStatement = $this->databaseConnection->prepare($addWorkoutStatement);
            $queryStatement->bind_param('is', $params["userID"], $workoutName);
            $queryStatement->execute();

            $workoutID = $this->getWorkoutID($requestBody->workoutName);
            $this->addWorkoutExercisesAssociations($workoutID, $exercises);

            http_response_code(201);
            echo json_encode(new Response(0, $workoutID));
        }

        //GET: /users/{userID}/workouts/{workoutID} -- get workout
        public function getWorkout($params, $queryParams, $requestBody) {
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
                echo json_encode($workout);
            }
            else {
                http_response_code(404);
                echo json_encode(new Response(1, "Workout not found"));
            }
        }

        //PUT: /users/{userID}/workouts/{workoutID} -- updates workout
        public function updateWorkout($params, $queryParams, $requestBody) {
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
                echo json_encode(new Response(2, "Workout doesn't belong to user"));
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
            if (!is_numeric($params["userID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad userID"));
                die();
            }
            if (!is_numeric($params["workoutID"])) {
                http_response_code(400);
                echo json_encode(new Response(2, "Bad workoutID"));
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
                echo json_encode(new Response(3, "Workout doesn't exist or doesn't belong to userID"));
            }
        }

        //GET: /users/{userID}/workouts/history?order=[asc/desc]$limit=[]
        public function getWorkoutHistory($params, $queryParams, $requestBody) {
            if (!is_numeric($params["userID"])) {
                http_response_code(400);
                echo json_encode(new Response(1, "Bad userID"));
                die();
            }

            if (!is_numeric($queryParams["limit"]) || $queryParams["limit"] < 0) {
                http_response_code(400);
                echo json_encode(new Response(2, "Bad limit"));
            }
            $order = $queryParams["order"];
            $limit = $queryParams["limit"];
            $getWorkoutHistoryStatement = "SELECT w.workoutID, w.name FROM workouts w 
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
                require_once("../models/DTO/WorkoutDTO.php");
                while ($row = $result->fetch_assoc()) {
                    $workout = new WorkoutDTO($row["w.name"], $row["w.workoutID"]);
                    array_push($receivedWorkouts, $workout);
                }
                http_response_code(200);
                echo json_encode($receivedWorkouts);
            }
            else {
                http_response_code(400);
                echo json_encode(new Response(3, "Bad order"));
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
                http_response_code(200);
                echo json_encode(new Response(0, $row["userID"]));
                die();
            }

            http_response_code(400);
            echo json_encode(new Response(1, "Invalid login key."));
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
            $result = $this->databaseConnection->query("SELECT EXISTS(SELECT * FROM workouts WHERE userID = $userID AND workoutID = $workoutID)");
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

    }

?>