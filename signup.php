<?php
	session_start();
	require "koneksi.php";

	$errors = array();
	
	if(isset($_POST["signup"])){
		$username = mysqli_real_escape_string($koneksi, $_POST['username']);
		$fullname = mysqli_real_escape_string($koneksi, $_POST['fullname']);
		$email = mysqli_real_escape_string($koneksi, $_POST['email']);
		$password = mysqli_real_escape_string($koneksi, $_POST['password']);
		$cpassword = mysqli_real_escape_string($koneksi, $_POST['cpassword']);
		if($password !== $cpassword){
		   $errors['password'] = "Confirm password not matched!";
		}
		$user_check = "SELECT * FROM users WHERE username = '$username'";
		$res = mysqli_query($koneksi, $user_check);
		if(mysqli_num_rows($res) > 0){
		  $errors['username'] = "Username that you have entered is already exist!";
		}
		if(count($errors) === 0){
			$insert_data = "INSERT INTO users (username, fullname, email, password) values('$username', '$fullname', '$email', '$password')";
			$data_check = mysqli_query($koneksi, $insert_data);
			if($data_check){
				$_SESSION['username'] = $username;
				$_SESSION['login'] = true;
				$_SESSION['info'] = "Berhasil Signup, silahkan login";
				header('location: login.php');
				exit();
			}else{
				$errors['db-error'] = "Failed while inserting data into database!";
			}
		}
	}
?>	

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SAVE IN</title>
	<link href="assets/img/logo.png" rel="icon">
  	<link href="assets/img/logo.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
	          background: url(img/grey.jpg) no-repeat fixed;
	          -webkit-background-size: 100% 100%;
	          -moz-background-size: 100% 100%;
	          -o-background-size: 100% 100%;
	          background-size: 100% 100%;
	        }
		.row {
			margin:100px auto;
			width:300px;
			text-align:center;
		}
		.login {
			background-color:#FFFFFF;
			padding:20px;
			margin-top:20px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="center">
				<div class="login">	
					<form role="form" action="" method="post">
					<h3> SIGN UP</h3><br>
					<?php
               		if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>	
						<div class="form-group">
							<input type="text" name="username"  class="form-control" placeholder="Username" required autofocus />
						</div>
						<div class="form-group">
							<input type="text" name="fullname"  class="form-control" placeholder="Fullname" required autofocus />
						</div>
						<div class="form-group">
							<input type="text" name="email"  class="form-control" placeholder="Email Address" required autofocus />
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password" required autofocus />
						</div>
						<div class="form-group">
							<input type="password" name="cpassword" class="form-control" placeholder="Confirm Password" required autofocus />
						</div>
						<div class="form-group">
							<input type="submit" name="signup" class="btn btn-primary btn-block" value="SIGNUP" />	
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>