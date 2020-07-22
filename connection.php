<?php

	if (isset($_GET['userid']) && isset($_GET['fname']))  //Request coming from dashboard to insert values in invitation 
	{
		//echo "<script>alert('".$_GET['userid']." ".$_GET['fname']."')</script>";
		$connection = mysqli_connect("btsaydncrw6xehglqk6u-mysql.services.clever-cloud.com", "uqpatj9ytkbkfa7e", "x11j8zt3kiS1UaX70zrS", "btsaydncrw6xehglqk6u","3306") or die("Unable to connect");


		$query = "SELECT user_id FROM login WHERE email='".$_GET['fname']."'";
		$result = mysqli_fetch_array(mysqli_query($connection, $query));
		if ($result) 
		{
			$query = "SELECT sender_id FROM invitation WHERE user_id='".$_GET['userid']."'";
			$test = mysqli_fetch_array(mysqli_query($connection, $query));
			//echo $result[0]."  ".$test[0];

			if($result[0] != $test[0])
			{
				$query2 = "INSERT INTO invitation VALUES('".$result[0]."','".$_GET['userid']."','0')"; //friends id---your id--status 0 default
				$result2 = mysqli_query($connection, $query2);
				mysqli_close($connection);
				//echo "<script>alert('Hii')</script>";
				# code...
				header("Location:dash.php?data1=".$_GET['userid']."&data2=".$_GET['name']);
			}
			else
			{
				echo "<h2 align='center' style='color:#7080c3; font-family:sans-serif;'>You have already send the request.<br>Please go to previous page..</h2>";
			}

		}
		else
		{
			echo "<h2 align='center' style='color:#7080c3; font-family:sans-serif;'>User is not found..<br>Please go to previous page</h2>";
		}

		# code...
	}

	if (isset($_GET['query']))  //Request coming from dashboard to insert values in invitation 
	{
		//echo "<script>alert('".$_GET['userid']." ".$_GET['fname']."')</script>";
		$connection = mysqli_connect("btsaydncrw6xehglqk6u-mysql.services.clever-cloud.com", "uqpatj9ytkbkfa7e", "x11j8zt3kiS1UaX70zrS", "btsaydncrw6xehglqk6u","3306") or die("Unable to connect");

		
		$query = $_GET['query'];
		$result = mysqli_query($connection, $query);
		
			mysqli_close($connection);
			//echo "<script>alert('Hii')</script>";
			# code...
		
		header("Location:dash.php?data1=".$_GET['userid']."&data2=".$_GET['name']);

		# code...
	}
?>