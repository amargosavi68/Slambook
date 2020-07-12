<?php

	/*Store data into database.*/
		
	if(isset($_POST['submit'])) 
	{
		$friends_id = $_GET['f_id'];
		$u_id = $_GET['id'];
		$moments = $_POST['moments'];
		$past = $_POST['past'];
		$marooned = $_POST['marooned'];
		$holiday = $_POST['holiday'];
		$dreamcity = $_POST['dreamcity'];
		$craziest = $_POST['craziest'];
		$life = $_POST['life'];
		$bestthing = $_POST['bestthing'];
		$fantasy = $_POST['fantasy'];
		$bestfriends = $_POST['bestfriends'];
		$thoughts = $_POST['thoughts'];
		$date = $_POST['date'];

		// Create connection
		$conn = new mysqli("localhost","root","","amar","3307") or die("Error in connection");
			
			$query ="INSERT INTO slam_info VALUES('$friends_id','$u_id','$moments','$past','$marooned','$holiday','$dreamcity','$craziest','$life','$bestthing','$fantasy','$bestfriends','$thoughts','$date')"; 

			$result = mysqli_query($conn, $query);

			 if($result)
			 {
			 	/*Updating status in invitation when one is filled his/her slambook..*/
			 	$query2 = "UPDATE invitation SET status=1 WHERE sender_id='".$u_id."' and user_id='".$friends_id."'";
			 	$result2 = mysqli_query($conn, $query2); 
			 	
			 }
			 else
			 {
			 	echo "<h2 align='center' style='color:#7080c3; font-family:sans-serif;margin-top:100px;'>Data not inserted. Please try again..<br>Please go to previous page and fill it again.</h2>";
			 }
		
		$conn -> close();
		
	}


	/*Retrieving data to render in the slambook.. Request coming from dash.php to view the slambook..*/

	if (isset($_GET['userid']) && isset($_GET['name']) && isset($_GET['friend_id'])) 
	{

		$uid = $_GET['userid'];     // store user_id 
		$fid = $_GET['friend_id'];	// store friend's id 

		$conn = mysqli_connect("localhost","root","","amar","3307") or die("Unable to connect");

		$query = "SELECT * FROM slam_info WHERE user_id='$fid' and sender_user_id='$uid'";
		$result = mysqli_query($conn, $query);
		if ($result) 
		{
			$slambook = array(); 	// store the all content of that row.
			
			while ($w = mysqli_fetch_array($result)) 
			{
				$i=0;
				while($i!=14)
				{
					array_push($slambook, $w[$i]);
					$i++;
				}
			}	
			mysqli_close($conn);
			$slambook_enc = json_encode($slambook);
		}
		 else
		 {
		 	echo "<h2 align='center' style='color:#7080c3; font-family:sans-serif; margin-top:100px;'>Sorry, Slambook is not available.</h2>";
		 }
		# code...
	}
?>







<!DOCTYPE html>
<html lang="en">
<head>
	<title>Slambook</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="CSS\slambook.css">
	<script type="text/javascript">
		function Insert()
		{

			window.location.href = "slambook.php?id="+'<?php echo $_GET['id'] ?>' +"&f_id="+'<?php echo $_GET['f_id'] ?>';

		}
	</script>
</head>

<body>

	<div>

		<form onsubmit="Insert()" method="POST">
				<label style="text-align: center;"><strong>Note:</strong> Please, DO NOT Resubmit the Form when you go back.</label>
				<h1>Slambook</h1>
				<hr>
				
					<table>

						<tr>
							<td>Most exciting moments we had together :</td>
							<td><input type="text" name="moments" id="s1" placeholder="moments"></td>
						</tr>

						<tr>
							<td>One thing like to erase from past :</td>
							<td><input type="text" name="past" id="s2" placeholder="past"></td>
						</tr>

						<tr>
							<td>On a lonely Island I want to marooned with :</td>
							<td><input type="text" name="marooned" id="s3" placeholder="Name !!"></td>
						</tr>

						<tr>
							<td>Favourite Holiday Spot, We enjoyed together :</td>
							<td><input type="text" name="holiday" id="s4" placeholder="Spot !!"></td>
						</tr>

						<tr>
							<td>Dream City, wish to go :</td>
							<td><input type="text" name="dreamcity" id="s5" placeholder="City !!"></td>
						</tr>

						<tr>
							<td>The Craziest thing ever done :</td>
							<td><input type="text" name="craziest" id="s6" placeholder="......"></td>
						</tr>

						<tr>
							<td>Describe Life in One Word :</td>
							<td><input type="text" name="life" id="s7" placeholder="One Word"></td>
						</tr>

						<tr>
							<td>The best thing about U and me is :</td>
							<td><input type="text" name="bestthing" id="s8" placeholder="...!!..."></td>
						</tr>

						<tr>
							<td>Wildest fantasy :</td>
							<td><input type="text" name="fantasy" id="s9" placeholder="........"></td>
						</tr>

						<tr>
							<td>Best Friends list :</td>
							<td><input type="text" name="bestfriends" id="s10" placeholder="Friends"></td>
						</tr>

						<tr>
							<td>Few Groovy thoughts about me :</td>
							<td><input type="text" name="thoughts" id="s11" placeholder="...!!..."></td>
						</tr>

						<tr>
							<td>Today's Date :</td>
							<td><input type="date" name="date" id="s12" placeholder=""></td>
						</tr>

						<tr>
							<td colspan="2"><input type="submit" id="s13" name="submit" value="Submit"></td>
						</tr>
						
					</table>
				
		</form>
	</div>

	<script type="text/javascript">

		if(('<?php echo $_GET['userid'] ?>') && ('<?php echo $_GET['friend_id'] ?>'))
		{

			var user_id = '<?php echo $_GET['userid'] ?>';
			var friend_id = '<?php echo $_GET['friend_id'] ?>';
			var slam_info = JSON.parse('<?= $slambook_enc; ?>');

			document.getElementById('s1').value = slam_info[2];
			document.getElementById('s1').disabled = "disabled";
			document.getElementById('s2').value = slam_info[3];
			document.getElementById('s2').disabled = "disabled";
			document.getElementById('s3').value = slam_info[4];
			document.getElementById('s3').disabled = "disabled";
			document.getElementById('s4').value = slam_info[5];
			document.getElementById('s4').disabled = "disabled";
			document.getElementById('s5').value = slam_info[6];
			document.getElementById('s5').disabled = "disabled";
			document.getElementById('s6').value = slam_info[7];
			document.getElementById('s6').disabled = "disabled";
			document.getElementById('s7').value = slam_info[8];
			document.getElementById('s7').disabled = "disabled";
			document.getElementById('s8').value = slam_info[9];
			document.getElementById('s8').disabled = "disabled";
			document.getElementById('s9').value = slam_info[10];
			document.getElementById('s9').disabled = "disabled";
			document.getElementById('s10').value = slam_info[11];
			document.getElementById('s10').disabled = "disabled";
			document.getElementById('s11').value = slam_info[12];
			document.getElementById('s11').disabled = "disabled";
			document.getElementById('s12').value = slam_info[13];
			document.getElementById('s12').disabled = "disabled";

			document.getElementById('s13').disabled = "disabled";
			document.getElementById('s13').style.cursor = "not-allowed";
		
		}

	</script>
</body>
</html>