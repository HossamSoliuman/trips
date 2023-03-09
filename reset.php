<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>reset your email</title>
</head>
<body>
<div class="container" class="row justify-content-center">
<?php
if(isset($_POST['reset']))
{
    echo '
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We\'ll never share your email with anyone else.</div>
            </div>
        <div class="mb-3">
            <label class="form-label">Your username</label>
            <input name="user_name" type="text" class="form-control">
        </div>
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>

    </form>
    ';
    


}
if(isset($_POST['submit']))
    {
        echo '
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We\'ll never share your email with anyone else.</div>
                </div>
            <div class="mb-3">
                <label class="form-label">Your username</label>
                <input name="user_name" type="text" class="form-control">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    
        </form>
        ';
        include "connection.php";
        $checks="select * from bus.users where user_name=:user_name and email=:email;";
        $check=$database->prepare($checks);
        $check->bindParam("user_name",$_POST['user_name']);
        $check->bindParam("email",$_POST['email']);
        $check->execute();
       
        if($check->rowCount()==0)
        {

            echo '
                         
							<div
							style="background:#DC143C;"
							class="form-control  btn  rounded submit px-3 alert-danger">Try again email or username is wrong</div>
						
							';
        }
        else{
            include "connection.php";
            $update=$database->prepare("update bus.users set secret_code=:secret_code where user_name=:user_name");
           $secret_code=rand(1000,9999);
           $update->bindParam("secret_code",$secret_code);
           $update->bindParam("user_name",$_POST['user_name']); 
           $update->execute();           
            $to=$_POST['email'];         
            $body='
            Thanks for using our website'."\r\n"."its the secret code ".$secret_code."\r\n".' to reset your password click her
            <a href="http://localhost/busmanagement/code.php?user_name='.$_POST['user_name'].'">http://localhost/busmanagement/reset.php </a>';
            $subject="Reset your password";
           include "sendemail.php";
            echo "check your email ";
           
        }
        


    }

?>

</div>
    
</body>
</html>

