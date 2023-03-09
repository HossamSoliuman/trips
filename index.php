<!doctype html>
<html lang="en">
  <head>
  	<title>Login </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="style.css">

	</head>
	<body>
		<?php session_start();
		if(isset($_COOKIE['user_name']))
		{
			$username=$_COOKIE['user_name'];
			$password=$_COOKIE['password'];
		}
		?>
		
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"></h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(roat.jpg);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
			      	</div>
					
					<!-- starting the form -->
							<form method="post" class="signin-form">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Username</label>
			      			<input name="user_name" type="text" class="form-control" placeholder="Username" required value="<?php
							if(isset($_COOKIE['user_name']))
							{ echo  $username; }
							 ?>">
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
		              <input name="password" type="password" class="form-control" placeholder="Password" required value="<?php 
					  if(isset($_COOKIE['user_name']))
					  {echo  $password;} ?>">
					  
		            </div>
		            <div class="form-group">
		            	<button name="submit" type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
		            </div>
					
					<div class="form-group">
					<?php
					
					if(isset($_POST['submit']))
					{
						include "connection.php";
						$checks="select * from bus.users where user_name=:user_name and password=:password;";
						$check=$database->prepare($checks);
						$check->bindParam("user_name",$_POST['user_name']);
						$check->bindParam("password",$_POST['password']);
						$check->execute();

						if($check->rowCount()==1)
						{
							$check=$check->fetchObject();
							$_SESSION['user']=$check;
							if($check->role=="admin")
							{
								header("location:admin.php");
							}
							else if($check->role=="trip_admin")
							{
								header("location:trip_admin.php");
							}
							else 
							{
								header("location:user.php");
							}
							if(isset($_POST['remember']))
							{
								
								if(!isset($_COOKIE['user_name'])){

									$time=strtotime("1 year");
									setcookie('user_name',$_POST['user_name'],$time);
									setcookie('password',$_POST['password'],$time);
								}
							}
								
							
						}
						
						else
						{
							
							echo '
							<div
							style="background:#DC143C;"
							class="form-control  btn  rounded submit px-3 alert-danger">Try again email or password is wrong</div>
							
							';

						}
					}
					?>
					 </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	
										
										<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input name="remember" type="checkbox" >
									  
									  <span class="checkmark"></span>
										</label> 
										
									</div>
									</form>
									<div class="w-50 text-md-right">
										<form action="reset.php" method="post">
											<button class="btn btn-info" name="reset" type="submit">Forgot Password</button>
										</form>
										
									</div>
									
		            </div>
		          
		          <p class="text-center">Not a member? <a data-toggle="tab" href="signup.php">Sign Up</a></p>
		        </div>
		      </div>
				</div>
			</div>
			
		</div>
	</section>

	


	</body>
</html>

