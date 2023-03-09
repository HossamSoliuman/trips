<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Homet</title>
</head>
<body>
<div class="container">
    <?php
    session_start();
    include "connection.php";
    echo '
              
    <table class="table">
      <thead>
          <tr>
          <th scope="col">#</th>         
          <th scope="col">Trip id</th>
          <th scope="col">Reminder places</th>          
          <th scope="col">Details</th>
          <th scope="col">Take place</th>
          </tr>
      </thead>
      <tbody>';
      $show=$database->prepare("select * from bus.trips where number_of_books < max_number ");
      $show->execute();
      //var_dump($show->errorInfo());
      $i=0;
      foreach($show as $data)
      {
         $r= $data['max_number']-$data['number_of_books'];
         
          $i++;
          echo '
          <tr>
          <th scope="row">'. $i .'</th>    
          <td>'.$data['id'].'</td>
          <td>'.$r.'</td>
          <td>'.$data['details'].'</td>
          <td>';
          $checkbook=$database->prepare("select*from bus.books where trip_id=:trip_id and user_id=:user_id; ");
          $checkbook->bindParam("user_id",$_SESSION['user']->id);        
          $checkbook->bindParam("trip_id",$data['id']);
          $checkbook->execute();
          if($checkbook->rowCount()==0)
          {
            echo '
            <form method="post">
              <button type="submit" name="book" value="'.$data['id'].'">Book it</button>
           </form>
            
            ';

          }
          else
          {
            echo '
            <button type="submit" name="book" >Booked</button>
            ';
          }
          
          
          echo' </td>
          
          </tr>
          ';
        

      }

          
      echo'</tbody>
    </table>
    
    
    ';
    if(isset($_POST['book']))
    {
        $increment=$database->prepare("update bus.trips set number_of_books= number_of_books+1 where id=:id");
        $increment->bindParam("id",$_POST['book']);
        $increment->execute();
        $book=$database->prepare("insert into bus.books(user_id,trip_id)values(:user_id,:trip_id)");
        $book->bindParam("user_id",$_SESSION['user']->id);
        $book->bindParam("trip_id",$_POST['book']);
        $book->execute();
        header("refresh:2");

        



    }
    
    ?>
</div>
</body>
</html>