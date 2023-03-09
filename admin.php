<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    

      
        <?php
        session_start();
        
        echo ' <div class="container">';
        if(isset($_SESSION['user']) && $_SESSION['user']->role=="admin")
        {
                include "connection.php";
                echo '
                                <form method="post" >
                            <select name="sel" class="form-select" aria-label="select an operation">
                            <option selected>select the operation</option>
                            <option value="1">Add a trip-admin</option>
                            <option value="2">Show all trips-admins</option>
                            <option value="3">remove a trip-admin</option>
                            </select>
                            <button name="sub" type="submit" class="btn btn-outline-warning"  >Go</button>
                            </form>
                                
                    
                    ';
                if(isset($_POST['sub']))
                {
                    
                    
                    if( $_POST['sel']==1)
                    {
                        echo '
                        <form  method="post">
                        <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input  name="trip_admin"  type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                        <button class="btn btn-outline-warning" type="submit" name="add">ADD</button>
                        </form>
                        ';
                    
                    

                    }
                    else if($_POST['sel']==2)
                    {
                    $show=$database->prepare("select * from bus.users where role=\"trip_admin\"");
                    $show->execute();
                    foreach($show as $data)
                    {
                    echo $data['user_name']."  ". $data['email'];
                    echo '
                    <form style="disply:inline-block;" method="post"> 
                        <button  class="btn btn-outline-danger" type="submit" name="show" value="'. $data['user_name'].'">Remove</button>
                        </form>
                    ';
                    }


                    }
                    else if($_POST['sel']==3)
                    {
                        echo '
                        <form  method="post">
                        <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                        <input name="trip_admin" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                        <button class="btn btn-outline-danger" type="submit" name="remove">Remove</button>
                        </form>
                        ';


                    }

                    
                }
                if(isset($_POST['show']))
                {
                    
                    $remove=$database->prepare("update bus.users set role=\"user\" where user_name=:user_name;");
                    $remove->bindParam("user_name",$_POST['show']);
                    $remove->execute();
                    echo '<div class="alert alert-danger" role="alert">
                    '.$_POST['show'].' Not still a trip-admin!
                </div>';
                    header(":2 refesh");
                    
        

                }
                
                if(isset($_POST['add']))
                        {     
                        
                            $check=$database->prepare("select * from bus.users where user_name=:user_name");
                            $check->bindParam("user_name" , $_POST['trip_admin']);
                            $check->execute();
                            
                            if($check->rowCount()==0)
                            {
                                echo 
                                '<div class="alert alert-danger" role="alert">
                                username does not exist!
                                </div>'
                                ;
                            }
                            else if($check->rowCount()>0)
                            {
                                $add=$database->prepare("update bus.users set role=\"trip_admin\" where user_name=:user_name;");
                                $add->bindParam("user_name",$_POST['trip_admin']);
                                $add->execute();
                                echo 
                                '
                                <div class="alert alert-success" role="alert">
                                Success!!<br>
                                '. $_POST["trip_admin"].' became a trip-admin!
                                </div>
                                
                                ';
                                
                            }
                            



                        }
                

                        if(isset($_POST['remove']))
                        {     
                        
                            $check=$database->prepare("select * from bus.users where user_name=:user_name");
                            $check->bindParam("user_name" , $_POST['trip_admin']);
                            $check->execute();
                            
                            if($check->rowCount()==0)
                            {
                                echo "username does not exist !!";
                            }
                            else if($check->rowCount()>0)
                            {
                                $remove=$database->prepare("update bus.users set role=\"user\" where user_name=:user_name;");
                                $remove->bindParam("user_name",$_POST['trip_admin']);
                                $remove->execute();
                                echo 
                                '<div class="alert alert-danger" role="alert">
                                '.$_POST['trip_admin'].' will not be a trip-admin
                                </div>'
                                ;
                            }
                            



                        }
            }
            else
            {
                header("location:login.php");
            }
        ?>
</div>
</body>
</html>
