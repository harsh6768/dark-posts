<?php

class User
{

    //connection instance
    public $connection;

    //table name
    public $table_name = "users";

    public $username;
    public $email;
    public $password;


    public function __construct($connection)
    {

        $this->connection = $connection;
    }

    function registerUser()
    {

        $sql = "insert into $this->table_name(username,email,password) values('$this->username','$this->email','$this->password')";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
    function loginUser()
    {

        $sql="select * from $this->table_name where email='$this->email' LIMIT 0,1";

        $stmt=$this->connection->prepare($sql);

        $stmt->execute();

        return $stmt;
    }
}
