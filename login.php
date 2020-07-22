<!DOCTYPE html>
<html>
<head>
	<title>Login | Slambook</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS\login.css">
	<link href='https://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet'>
	

</head>
<body>

	<section>
		<span class="container">

			<span class="login-image">
				<img src="images\avatar.png" name="Login image"><br>
			</span>

			<span class="head">Please Login Here</span>

			<span id="msg"></span>

				<form action="login.php" method="post">
					
					<label>Email ID or Username</label><br>
					<input type="text" id="uname" name="username" placeholder="Enter username"><br>
					<label>Password</label><br>
					<input type="password" id="pwd" name="password" placeholder="Enter password"><br>
					<label></label><br>
					<input type="submit" name="submit" value="Login"><br>

				</form>
			
		</span>
	</section>

</body>
</html>



<?php
	$conn = mysqli_connect("localhost", "root", "", "amar","3307") or die("Unable to connect");
	session_start();
	
	if(isset($_POST['username']) && isset($_POST['password'])) 
	{
		$query = "SELECT * FROM login WHERE email='".$_POST['username']."'";

		$result = mysqli_query($conn, $query);
		$data = mysqli_fetch_array($result);
	
		if(isset($data)) {
			
			if(md5($_POST['password']) == $data[4]) {
				
				header("Location: dash.php?data1=".$data[0]."&data2=".$data[1]." ".$data[2]);
			}
			else {
				echo '<script language="javascript">';
				echo "alert('Wrong Password')";
				echo '</script>';
			}
		}
		else
		{
			echo '<script language="javascript">';
			echo "alert('Wrong Credentials.. Please check your username and password.')";
			echo '</script>';
		}
		mysqli_free_result($result);
	}
	mysqli_close($conn);
?>