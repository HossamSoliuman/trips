<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>trip-admin</title>
</head>
<body>
<?php session_start();?>

<div class="container">
      <form method="post" >
        <select name="sel" class="form-select" aria-label="select an operation">
         <option selected>select the operation</option>
        <option value="1">Add a trip</option>
        <option value="2">Show all trips</option>
        
        </select>
        <button name="sub" type="submit" class="btn btn-outline-warning"  >Go</button>
        </form>
        <?php
        include "connection.php";
        if(isset($_POST['sub']))
        {
            
            if( $_POST['sel']==1)
            {
                echo '
                <form method="post">
  
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Max number of trip members</label>
                  <input name="max_number" type="number" class="form-control" >
                </div>
              
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Details</label>
                  <input name="details" type="text" class="form-control" id="exampleInputPassword1">
                </div>
                
                <button name="add" type="submit" class="btn btn-primary">ADD </button>
              </form>
               ';

            }
            else if($_POST['sel']==2)
            {
              echo '
              
              <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Trip id</th>
                    <th scope="col">current members </th>
                    <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>';
                $show=$database->prepare("select * from bus.trips where trip_admin_id=:trip_admin_id ");
                $show->bindParam("trip_admin_id",$_SESSION['user']->id);
                $show->execute();
                $i=0;
                foreach($show as $data)
                {
                    $i++;
                    echo '
                    <tr>
                    <th scope="row">'.$i.'</th>
                    <td>'.$data['id'].'</td>
                    <td>'.$data['number_of_books'].'</td>
                    <td>'.$data['details'].'</td>                   
                    </tr>
                    ';


                }

                    
                echo'</tbody>
              </table>
              
              
              ';


            }
            


        }
        if(isset($_POST['add']))
        {
            $add=$database->prepare("insert into bus.trips(max_number , details,trip_admin_id) values (:max_number , :details, :trip_admin_id) ");
            $add->bindParam("max_number",$_POST['max_number']);
            $add->bindParam("details",$_POST['details']);
            $add->bindParam("trip_admin_id", $_SESSION['user']->id);
            $add->execute();
            echo '
            
            <div class="alert alert-success" role="alert">
            trip added!
            </div>
            
            ';


        }
      
        ?>






</body>
</html>