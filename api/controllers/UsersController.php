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

            $addUserStatement = "INSERT INTO users VALUES (NULL, ?, ?, ?, NULL, NULL, NULL, NULL, 0, 0, 0, 0)";
            $queryStatement = $this->databaseConnection->prepare($addUserStatement);
            $queryStatement->bind_param('sss', $requestBody->username, $requestBody->password, $requestBody->email);
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

            $queryStatement = $this->databaseConnection->prepare("SELECT * FROM users WHERE id = ?");
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
        
            http_response_code(200);
            echo json_encode($user);
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
                $queryStatement->bind_param($params["userID"]);
                $queryStatement->execute();
                $result = $queryStatement->get_result();
                $receivedWorkouts = array();
                while ($row = $result->fetch_assoc()) {
                    $workout["workoutID"] = $row["w.workoutID"];
                    $workout["workoutName"] = $row["w.name"];
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

    }

?>