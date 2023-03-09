<!doctype html>
<html lang="en">
  <head>
  	<title>index </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="style.css">

	</head>
	<body>
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
						<div class="index-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-120">
			      			<h3 class="mb-4">Sign UP</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
			      	</div>
							<form  class="signin-form" method="post">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">fullname</label>
                                    <input name="full_name" type="text" class="form-control" placeholder="Fullname" required>
                                </div>

                        
                        
                                <div class="form-group mb-3">
			      			<label class="label" for="name">Username</label>
			      			<input name="user_name" type="text" class="form-control" placeholder="Username" required>
			      		</div>
                          <div class="form-group mb-3">
                            <label class="label" for="name">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>



                        <div class="form-group mb-3">
                            <label class="label" for="name">password</label>
                            <input name="password" type="password" class="form-control" placeholder="password" required>
                        </div>
		            <div class="form-group">
		            	<button name="submit" type="submit" class="form-control btn btn-primary rounded submit px-3">Sign UP</button>
		            </div>
					<div class="form-group">
					<?php
					if(isset($_POST['submit']))
					{
						include "connection.php";
						$checkuser=$database->prepare("
						select * from bus.users where user_name=:user_name
						");
						$checkuser->bindParam("user_name",$_POST['user_name']);
						$checkuser->execute();
						if($checkuser->rowCount() > 0)
						{
							echo '
							<div
							style="background:#DC143C;"
							class="form-control  btn  rounded submit px-3 alert-danger">Sorry username is exist </div>
							
							';

						}
						else
						{

						$adds="insert into bus.users (full_name,user_name,password,email) values
						(:full_name, :user_name, :password, :email)";
						$add=$database->prepare($adds);
						$add->bindparam("full_name",$_POST['full_name']);
						$add->bindparam("user_name",$_POST['user_name']);
						$add->bindparam("password",$_POST['password']);
						$add->bindparam("email",$_POST['email']);
						
						$add->execute();
						
						header("location:index.php");

						}

					 }
					
					 ?>
					</div>
					</div>
				 
		            <!-- <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
		            </div> -->
		          </form>
		          <p class="text-center">Have an acount? <a data-toggle="tab" href="index.php">Log in</a></p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
        
	</section>
	
			</body>
</html>


