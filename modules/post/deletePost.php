<?php 

/**
 * 1. method: delete
 * 2. api-url: http://localhost/posts_apis/modules/post/deletePost.php
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response=array();


$data = json_decode(file_get_contents("php://input"), true);

$postId=$data['postId'];

if(isset($postId)){

    require_once __DIR__.'/../../config/dbClass.php';
    require_once __DIR__.'/../../model/post.php';

    $db=new DBClass();
    $connection=$db->getConnection();

    $post=new Post($connection);
    $result=$post->deletePost($postId);

    
    if($result){

        $response['success']=1;
        $response['message']='Post deleted successfully';

        echo json_encode($response);

    }else{


        $response['success']=0;
        $response['message']='Failed to delete the post';

        echo json_encode($response);

    }

}else{


    $response['success']=0;
    $response['message']='Required inputs are missing';

    echo json_encode($response);


}