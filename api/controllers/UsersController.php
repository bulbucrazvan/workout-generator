<?php
    class UsersController extends Controller {

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

        public function addUser($params, $queryParams, $requestBody) {
            $addUserStatement = "INSERT INTO users VALUES (NULL, ?, ?, ?, NULL, NULL, NULL, NULL, 0, 0, 0, 0)";
            $queryStatement = $this->databaseConnection->prepare($addUserStatement);
            $queryStatement->bind_param('sss', $requestBody->username, $requestBody->password, $requestBody->email);
            $queryStatement->execute();

            if ($queryStatement->errno) {
                http_response_code(400);
                echo json_encode(new Response($queryStatement->errno, $queryStatement->error));
            }
            else {
                http_response_code(201);
                echo json_encode(new Response(201, "Successfully created user."));
            }
        }

        public function getUserByName($params, $queryParams, $requestBody) {
            echo $params["name"];
        }

    }

?>