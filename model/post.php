<?php


class Post
{

    //connection instance
    public $connection;

    //table name
    public $table_name = "posts";

    public $id;
    public $title;
    public $body;

    public function __construct($connection)
    {

        $this->connection=$connection;
    }

    public function createPost(){

        $sql="insert into $this->table_name(title,body) values('$this->title','$this->body')";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;

    }

    public function getPosts(){

        $sql="select * from $this->table_name";

        $stmt=$this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;

    }

    public function getPost($postId){

        $sql="select * from $this->table_name where id=$postId";

        $stmt=$this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;

    }

    public function updatePost($postId,$postTitle,$postBody){

        $sql="update posts set title='$postTitle',body='$postBody' where id=$postId";

        $stmt=$this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;
        
    }
    
    public function deletePost($postId){

        $sql="delete from $this->table_name where id=$postId";

        $stmt=$this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;

    }
}
