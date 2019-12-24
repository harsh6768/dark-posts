<?php

/**
 * 1. method: get
 * 2. api-url: http://localhost/posts_apis/modules/post/getPosts.php
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response=array();

require_once __DIR__.'/../../config/dbClass.php';
require_once __DIR__.'/../../model/post.php';

$db=new DBClass();
$connection=$db->getConnection();

$post=new Post($connection);
$stmt=$post->getPosts();

//to get row count
$count=$stmt->rowCount();

if($count>0){

    $response['body']=array();
    $response['count']=$count;
    $response['success']=1;


    //fetching all rows and storing into the reponse
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){


        extract($row);
        
        $post=array(
            "id"=>$id,
            "title"=>$title,
            "body"=>$body
        );

        array_push($response['body'],$post);

    }
    echo json_encode($response);

}else{

    $response['success']=0;
    $response['message']='Failed to fetch posts';

    echo json_encode($response);

}

?>