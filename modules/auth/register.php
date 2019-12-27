<?php 


/**
 * 1. method: post
 * 2. api-url: http://localhost/posts_apis/modules/auth/register.php
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response=array();

$data = json_decode(file_get_contents("php://input"), true);

$username=$data['username'];
$email=$data['email'];
$password=$data['password'];


if($username && $email && $password){

    require_once __DIR__.'/../../config/dbClass.php';
    require_once __DIR__.'/../../model/user.php';

    $db=new DBClass();
    $connection=$db->getConnection();
    
    $user=new User($connection);

    //password_hash is predefined method of php to encode the password
    $password=password_hash($password,PASSWORD_BCRYPT);
  
    $user->username=$username;
    $user->email=$email;
    $user->password=$password;

    $result=$user->registerUser();

    if($result){

        $response['success']=1;
        $response['message']='User registered successfully!';

        echo json_encode($response);

    }else{


        $response['success']=0;
        $response['message']='Faild to register user';

        echo json_encode($response);

    }


}else{

    $response['success']=0;
    $response['message']='Required fileds are missing!';

    echo json_encode($response);

}

?>