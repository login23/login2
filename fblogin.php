<?php
require_once "config.php";

$username = $password =  "";
$username_srr = $password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //check username is empty
    if(empty(trim($_POST['username']))){
        $username_err = "username Cannot be blank";

    }
    else{
        $sql = "SELECT id FROM entry1 WHERE username = ?";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s",$param_username);
        
            //set the value of param_username
            $param_username = trim($_POST['username']);
        
            //try to execute this statement.
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This Username is already taken";
                    
                }
                else{
                    $username=trim($_POST['username']);
                }
            }
            else{
                echo "something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);

//check for password
if(empty(trim($_POST['password']))){
    $password_err= "password cannot be blank";

}
else{
    $password = trim($_POST['password']);
}
//if there are no error, go ahead into database

if(empty($username_err) && empty($password_err)){
    $sql = " INSERT INTO entry1 (username, password) values(?,?)";
    $stmt = mysqli_prepare($conn,$sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt,"ss",$param_username, $param_password);

        //set these parameters
        $param_username =$username;
        $param_password = $password;
    
        //try to execute query

        if(mysqli_stmt_execute($stmt)){
            echo "Login Successfully ";
           
        }
        else{
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt);

}
mysqli_close($conn);

}
?>





