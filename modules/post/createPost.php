<?php

/**
 * 1. method: post
 * 2. api-url: http://localhost/posts_apis/modules/post/createPost.php
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$body = $data['body'];

$response = array();

if (isset($title) && isset($body)) {


    require_once __DIR__ . '/../../config/dbClass.php';
    require_once __DIR__ . '/../../model/post.php';

    $db = new DBClass();
    $connection = $db->getConnection();

    $post = new Post($connection);

    //setting value
    $post->title = $title;
    $post->body = $body;

    //call createPost method
    $result = $post->createPost();

    if ($result) {

        $response['success'] = 1;
        $response['message'] = 'Post Created Successfully';

        echo json_encode($response);
    } else {

        $response['success'] = 0;
        $response['message'] = 'Failed to create post';

        echo json_encode($response);
    }
} else {
    $response['success'] = 0;
    $response['message'] = 'Required Fields are empty';

    echo json_encode($response);
}
