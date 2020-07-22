<!DOCTYPE html>
<html>
<head>
	<title> Sign Up | Slambook</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS\signup.css">

	<script type="text/javascript">
		function validate_fname() 
		{
			var fname = document.getElementById('fname').value;
			var regex = /[a-zA-Z]$/;
			if (regex.test(fname)) 
			{
				document.getElementById('1').innerHTML = "";
				console.log("Validate fname");
			}
			else
			{
				document.getElementById('1').style.color = 'red';
				document.getElementById('1').innerHTML = "Sorry, input is invalid";
				document.getElementById('fname').value = "";
			}
		}

		function validate_lname() 
		{
			var lname = document.getElementById('lname').value;
			var regex = /[a-zA-Z]$/;
			if (regex.test(lname)) 
			{
				document.getElementById('2').innerHTML = "";
				console.log("Validate fname");
			}
			else
			{
				document.getElementById('2').style.color = 'red';
				document.getElementById('2').innerHTML = "Sorry, input is invalid";
				document.getElementById('lname').value = "";
			}
		}
		function validate_password() {
			var pwd = document.getElementById('password').value;
			var regex = /[a-zA-Z0-9*&#@$()]$/
			if (pwd.length>=8) 
			{
				document.getElementById('4').innerHTML = "";
				console.log("Validate fname");
			}
			else
			{
				document.getElementById('4').style.color = 'red';
				document.getElementById('4').innerHTML = "Sorry, password should be 8 character long.";
				document.getElementById('password').value = "";
			}
		}
	</script>
</head>


<body>
	<div class="container">
		<div class="head">
			Sign Up Here
		</div>

		<div class="signup-form">
			<form action="signup.php" method="post">

				<label>First Name</label><br>
				<input type="text" id="fname" name="first_name" placeholder="Enter first name" onblur="validate_fname()" required><br>
				<span id="1"></span><br>

				<label>Last Name</label><br>
				<input type="text" id="lname" name="last_name" placeholder="Enter last name" onblur="validate_lname()" required><br>
				<span id="2"></span><br>

				<label>Email ID</label><br>
				<input type="email" id="email" name="email" placeholder="abc@email.com" required><br>
				<span id="3"></span><br>

				<label>Password</label><br>
				<input type="password" id="password" name="password" placeholder="Set your password" onblur="validate_password()" required><br>
				<span id="4"></span><br>

				<input type="submit" name="register" value="Register"><br>
				
			</form>
		</div>

	</div>


</body>
</html>



<!-- Backend starts from here -->

<?php 

	$conn = mysqli_connect("btsaydncrw6xehglqk6u-mysql.services.clever-cloud.com", "uqpatj9ytkbkfa7e", "x11j8zt3kiS1UaX70zrS", "btsaydncrw6xehglqk6u","3306") or die("Unable to connect");

	if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])) 
	{
		$result = mysqli_query($conn, "SELECT * FROM login WHERE email= '".$_POST['email']."'");
		$data = mysqli_fetch_array($result);
		if(!isset($data))
		{
			$enc_pass = $_POST['password'];
			$query = "INSERT INTO login(first_name,last_name,email,password)VALUES('".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."','$enc_pass')";
			mysqli_query($conn, $query);
			echo '<script>alert("Registered successfully")</script>';
			mysqli_close($conn);
			header("Location:index.html");
		}
		else
		{
			echo '<script>alert("Username is already taken.")</script>';
			return false;
		}
	}
	mysqli_close($conn);
?>
