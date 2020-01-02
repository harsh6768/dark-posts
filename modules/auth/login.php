<?php

//to use jwt we need to add below 2 lines. It is like requiring the dependency in php file
require '../../vendor/autoload.php';

use \Firebase\JWT\JWT;


/**
 * 1. method: post
 * 2. api-url: http://localhost/posts_apis/modules/user/login.php
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response = array();

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];

if ($email && $password) {

    require_once __DIR__ . '/../../config/dbClass.php';
    require_once __DIR__ . '/../../model/user.php';

    $db = new DBClass();
    $connection = $db->getConnection();

    $user = new User($connection);

    //setting values 
    $user->email = $email;
    $user->password = $password;

    //calling login method
    $stmt = $user->loginUser();

    $count = $stmt->rowCount();


    if ($count > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $id=$row['id'];
        $userEmail=$row['email'];        
        $hashPassword = $row['password'];
        //to verify the hashed password
        $isPasswordMatched = password_verify($password, $hashPassword);

        if ($isPasswordMatched) {

            $secret_key = "harshchaurasiya6768@gmail.com";
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 60; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $id,
                    "email" => $userEmail,
                    "password"=>$hashPassword
                )
            );

            //encode token using jwt
            $jwt = JWT::encode($token, $secret_key);

            $response['token']=$jwt;
            $response['success'] = 1;
            $response['message'] = 'Successfully Logged In!';

            echo json_encode($response);
        } else {

            $response['success'] = 0;
            $response['message'] = 'Password is incorrect!';

            echo json_encode($response);
        }
    } else {

        $response['success'] = 0;
        $response['message'] = 'User does not exist with provided email!';

        echo json_encode($response);
    }
} else {

    $response['success'] = 0;
    $response['message'] = 'Required Fields are missing';

    echo json_encode($response);
}
