<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>code</title>
</head>
<body>
<form method="post">
            
                <div class="mb-3">
                     <label for="exampleInputEmail1" class="form-label"> Enter code</label>
                    <input name="code" type="number" class="form-control" id="exampleInputEmail1" >
                </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    
        </form>
        <?php
        if(isset($_POST['submit']))
        {
            include "connection.php";
            $checks="select * from bus.users where user_name=:user_name and secret_code=:code;";
            $check=$database->prepare($checks);
            $check->bindParam("user_name",$_GET['user_name']);
            $check->bindParam("code",$_POST['code']);
            $check->execute();
            if($check->rowCount()==1)
            {
                echo '
                <form method="post">
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">new password</label>
                <input name="password" type="number" class="form-control" id="exampleInputEmail1" >
                <button name="pass" type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
                ';


            }
            else{
                echo "code is wrong";
            }

           


        }
        if(isset($_POST['pass']))
        {
            include "connection.php";
         $update=$database->prepare("update bus.users set password=:password where user_name=:user_name");
       
        $update->bindParam("password",$_POST['password']);
        $update->bindParam("user_name",$_GET['user_name']); 
        $update->execute(); 
        echo "done";


        }

        ?>
</body>
</html>