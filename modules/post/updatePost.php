<?php 

/**
 * 1. method: put
 * 2. api-url: http://localhost/posts_apis/modules/post/updatePost.php
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response=array();


$data = json_decode(file_get_contents("php://input"), true);

$postId=$data['postId'];
$postTitle=$data['title'];
$postBody=$data['body'];


if(isset($postId) && isset($postTitle) && isset($postBody)){


    require_once __DIR__.'/../../config/dbClass.php';
    require_once __DIR__.'/../../model/post.php';

    $db=new DBClass();
    $connection=$db->getConnection();

    $post=new Post($connection);
    $result=$post->updatePost($postId,$postTitle,$postBody);

    if($result){

        $response['success']=1;
        $response['message']='Post updated successfully';

        echo json_encode($response);

    }else{


        $response['success']=0;
        $response['message']='Failed to update the post';

        echo json_encode($response);

    }

}else{


    $response['success']=0;
    $response['message']='Required inputs are missing';

    echo json_encode($response);


}


?>