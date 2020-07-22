
<?php
	if (isset($_GET['data1'])) 
	{
	
 		$connection = mysqli_connect("btsaydncrw6xehglqk6u-mysql.services.clever-cloud.com", "uqpatj9ytkbkfa7e", "x11j8zt3kiS1UaX70zrS", "btsaydncrw6xehglqk6u","3306") or die("Unable to connect");

		$query = "SELECT sender_id FROM invitation WHERE status=1 and user_id=".$_GET['data1'];
		$result = mysqli_query($connection, $query);

		if($result)
		{

			$query3 = "SELECT * FROM login WHERE user_id=".$_GET['data1'];
			$result3 = mysqli_query($connection, $query3);

			if($result3)		// This section is useful to dispay profile on profile panel.
			{
				$user_info = array();
				while($x = mysqli_fetch_array($result3))
				{
					array_push($user_info, $x[0]);
					array_push($user_info, $x[1]);
					array_push($user_info, $x[2]);
					array_push($user_info, $x[3]);
					array_push($user_info, $x[4]);

				}

				$user_info_enc = json_encode($user_info);
			}


	 		$name = array(); // store the full name of the user which fill current user's slambook
	 		$senderid = array(); // stores friends userid
			$filled_count = 0;
			while($w = mysqli_fetch_array($result))
			{
				array_push($senderid, $w[0]);		// friend's user id push into array
				//echo $w[0]."<br>";
				$query2 = "SELECT first_name, last_name FROM login WHERE user_id = ".$w[0]; // this query retrieve name of that friend who filled the slambook. This is required to display on dashboard
				$result2 = mysqli_fetch_array(mysqli_query($connection, $query2));

				$full_name = $result2[0]." ".$result2[1]; // concatnation of string to form a Full Name of friend
				array_push($name, $full_name);
				//echo $full_name."<br>";
				$filled_count = $filled_count + 1; // this required for the 'for loop' of script in Dashboard function to display how many friends have filled his slambook
			}


			mysqli_free_result($result);
			mysqli_close($connection);
			$name_enc = json_encode($name);
			$senderid_enc = json_encode($senderid); //encoding in JSON format and send back to the webpage

		}
	}

	if (isset($_GET['data1'])) //for Notification panel
	{
	
 		$connection = mysqli_connect("btsaydncrw6xehglqk6u-mysql.services.clever-cloud.com", "uqpatj9ytkbkfa7e", "x11j8zt3kiS1UaX70zrS", "btsaydncrw6xehglqk6u","3306") or die("Unable to connect");
 		
		$query = "SELECT user_id FROM invitation WHERE status=0 and sender_id=".$_GET['data1'];
		$result = mysqli_query($connection, $query);
		if($result)
		{
	 		$notify_name = array(); // store the full name of the user which fill current user's slambook
	 		$notify_senderid = array(); // stores friends userid
			$unfilled_count = 0;
			while($w = mysqli_fetch_array($result))
			{
				array_push($notify_senderid, $w[0]);		// friend's user id push into array
				//echo $w[0]."<br>";
				$query2 = "SELECT first_name, last_name FROM login WHERE user_id = ".$w[0]; // this query retrieve name of that friend who not filled the slambook. This is required to display in notification
				$result2 = mysqli_fetch_array(mysqli_query($connection, $query2));

				$full_name = $result2[0]." ".$result2[1]; // concatnation of string to form a Full Name of friend
				array_push($notify_name, $full_name);
				//echo $full_name."<br>";
				$unfilled_count = $unfilled_count + 1; // this required for the 'for loop' of script in notification function to display request of filling the slambook.
			}


			mysqli_free_result($result);
			mysqli_close($connection);
			$notify_name_enc = json_encode($notify_name);
			$notify_senderid_enc = json_encode($notify_senderid); //encoding in JSON format and send back to the webpage

		}
	}

 ?>





<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Slambook</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS\dashboard.css">
	<script type="text/javascript">
		/*$(document).ready(function(){
			$(".list").click(function(){
				$("#menu").hide();
			})
		});*/
		/*
		$(document).ready(function(){
			$(".logo").click(function(){
				$("#menu").show();
			})
		});*/
	</script>
	
</head>
<body onload="Dashboard()">

	<header>
			<label>Welcome,</label><label id="user"></label>
		<div class="logout">
			<a href="login.php"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fcdn.iconscout.com%2Ficon%2Fpremium%2Fpng-256-thumb%2Flogout-1-110657.png&f=1&nofb=1" height="30px" width="30px" alt="Logout Button"></a>
		</div>
	</header>


	<nav class="hamburger"> 
			<label class="logo" for="toggle">&#9776;</label> 
			<input type="checkbox" id="toggle">
		<div id="menu" class="menu">
			<label class="list" onclick="Dashboard()" id="1">Dashboard</label>
			<label class="list" onclick="Send_Invitation()" id="2">Send Invitation</label>
			<label class="list" onclick="Notification()" id="3">Notification <span id="count"></span></label>
			<label class="list" onclick="Profile()" id="4">Profile</label>
		</div>
	</nav>

	<section>
		<p id="container"></p>
	</section>





	<script type="text/javascript">
		var counter = 0;
		//var data1 = window.location.search.split('&')[0];
		//var data2 = window.location.search.split('&')[1];
		//var userid = data1.split('=')[1];
		//var name = data2.split('=')[1];
		//name = name.replace("%20", " ");
		//console.log(userid+" "+name);
		var userid = '<?php echo $_GET['data1'] ?>';
		var name = '<?php echo $_GET['data2'] ?>';
		var Slambook_filled_Names = JSON.parse('<?= $name_enc; ?>');
		var Slambook_filled_Name = ""; // required in the dashboard 'for loop'
		var Friends_id = JSON.parse('<?= $senderid_enc; ?>');
		var Friends_id_var = 0; // required in the dashboard 'for loop'
		var filled_count = "<?php echo $filled_count ?>";


		document.getElementById('user').innerHTML = name;
		var Slambook_unfilled_Names = JSON.parse('<?= $notify_name_enc; ?>');
		var Slambook_unfilled_Name = ""; // required in the dashboard 'for loop'
		var Friends_send_id = JSON.parse('<?= $notify_senderid_enc; ?>');
		var Friends_send_id_var = 0; // required in the dashboard 'for loop'
		var unfilled_count = "<?php echo $unfilled_count ?>";


		document.getElementById('count').style.background = "white";
		document.getElementById('count').innerHTML = unfilled_count;

		function Dashboard()
		{
			
			counter++;
			if(counter == 1)
			{
				/*var name = JSON.parse('<?= $name_enc; ?>');*/
				if(document.getElementById('container')) 
				{
					var element = document.getElementById('container');
					element.parentNode.removeChild(element);
				}
				
				
				var p = document.createElement('P'); //creating para inside div 
				p.setAttribute('id', 'container');
				document.body.appendChild(p);

				var h = document.createElement('H2'); //heading as a 'Dashboard'
				h.appendChild(document.createTextNode('Dashboard'));
				container.appendChild(h);
				if(filled_count>0)
				{
					for(var i=0; i<filled_count; i++)	// This for loop creates dynamic div which shows filled slambooks
					{

						var info = document.createElement('p');
						info.innerHTML = "<b>"+Slambook_filled_Names[i]+"</b> has filled your slambook.";
						container.appendChild(info);

						var view_btn = document.createElement('button');
						view_btn.appendChild(document.createTextNode('View Here'));
						Slambook_filled_Name = Slambook_filled_Names[i];
						Friends_id_var = Friends_id[i];
						view_btn.setAttribute('onclick','view_slam(userid,Slambook_filled_Name,Friends_id_var)');
						container.appendChild(view_btn);

						var hr = document.createElement('hr');
						container.appendChild(hr);
					}
				}
				else
				{
					var info = document.createElement('p');
					info.innerHTML = "No one has filled your slambook yet. Send your request to your friend.";
					container.appendChild(info);

					var hr = document.createElement('hr');
					container.appendChild(hr);
				}
			}
			counter=0;
		}





		function view_slam(userid, Name,friends_id)  //made changes here
		{
			window.location.href = "slambook.php?userid="+userid+"&name=" + Name +"&friend_id="+friends_id;
		}





		function Send_Invitation() 
		{
		
			counter++;
			if(counter == 1)
			{
				if(document.getElementById('container')) 
				{
					var element = document.getElementById('container');
					element.parentNode.removeChild(element);
				}
				
				
				var p = document.createElement('P'); //creating para inside div 
				p.setAttribute('id', 'container');
				document.body.appendChild(p);

				var h = document.createElement('H2'); //heading as a 'Dashboard'
				h.appendChild(document.createTextNode('Send Invitation'));
				container.appendChild(h);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode("Friend's username: "));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','text');
				text_field.setAttribute('id','friend_username');
				text_field.setAttribute('placeholder',"Your friend's username");
				text_field.setAttribute('required','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var view_btn = document.createElement('button');
				view_btn.appendChild(document.createTextNode('Send'));
				view_btn.setAttribute('onclick','Send(userid)');
				container.appendChild(view_btn);

			}
			counter=0;
			
		}




		function Send(userid) {
			var friend_username = document.getElementById('friend_username').value;
			
			if (friend_username==="") 
			{
				document.getElementById('friend_username').style.border = "1px solid red";
				document.getElementById('friend_username').value = "";
				return false;
			}
			else
			{
				document.getElementById('friend_username').style.border = "1px solid black";
				document.getElementById('friend_username').value = "";
				window.location.href = "connection.php?userid=" + userid + "&fname=" + friend_username+"&name="+name;
			}
		}




		function Notification() 
		{
			
			counter++;
			if(counter == 1)
			{

				if(document.getElementById('container')) 
				{
					var element = document.getElementById('container');
					element.parentNode.removeChild(element);
				}
				
				
				var p = document.createElement('P'); //creating para inside div 
				p.setAttribute('id', 'container');
				document.body.appendChild(p);

				var h = document.createElement('H2'); //heading as a 'Dashboard'
				h.appendChild(document.createTextNode('Notification'));
				container.appendChild(h);
				if(unfilled_count>0)
				{
					for(var i=0; i<unfilled_count; i++)	// This for loop creates dynamic div which shows filled slambooks
					{

						var info = document.createElement('p');
						info.innerHTML = "<b>"+ Slambook_unfilled_Names[i]+"</b> has requested you to fill the slambook.";
						container.appendChild(info);

						var view_btn = document.createElement('button')
						view_btn.appendChild(document.createTextNode('Fill Here'));
						view_btn.setAttribute('onclick','fill_slambook(userid,"'+Friends_send_id[i]+'")');
						container.appendChild(view_btn);
					}
				}
				else
				{
					var info = document.createElement('p');
					info.innerHTML = "No notification available.";
					container.appendChild(info);

					var hr = document.createElement('hr');
					container.appendChild(hr);
				}
			}
			counter=0;
		}


		function fill_slambook(userid, f_id) 
		{
			alert(name);

			window.location.href = "slambook.php?id="+userid+"&f_id="+f_id;

		}



		function Profile()
		{
			
			var user_info = JSON.parse('<?= $user_info_enc; ?>');
			counter++;
			if(counter == 1)
			{
				/*var name = JSON.parse('<?= $name_enc; ?>');*/
				var name = "Amar";
				if(document.getElementById('container')) {
					var element = document.getElementById('container');
					element.parentNode.removeChild(element);
				}
				
				
				var p = document.createElement('P'); //creating para inside div 
				p.setAttribute('id', 'container');
				document.body.appendChild(p);

				var h = document.createElement('H2'); //heading as a 'Dashboard'
				h.appendChild(document.createTextNode('Profile'));
				container.appendChild(h);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode('Your ID'));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','text');
				text_field.setAttribute('id','uid');
				text_field.setAttribute('value',userid);
				text_field.setAttribute('readonly','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode('First Name'));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','text');
				text_field.setAttribute('id','fname');
				text_field.setAttribute('value',user_info[1]);
				text_field.setAttribute('required','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode('Last Name'));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','text');
				text_field.setAttribute('id','lname');
				text_field.setAttribute('value',user_info[2]);
				text_field.setAttribute('required','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode('Email Address'));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','text');
				text_field.setAttribute('id','email');
				text_field.setAttribute('value',user_info[3]);
				text_field.setAttribute('readonly','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var lbl = document.createElement('label');
				lbl.appendChild(document.createTextNode('Password (This is encrypted)*'));
				container.appendChild(lbl);

				var br = document.createElement('br');
				container.appendChild(br);

				var text_field = document.createElement('input');
				text_field.setAttribute('type','password');
				text_field.setAttribute('id','pwd');
				text_field.setAttribute('value',user_info[4]);
				text_field.setAttribute('required','true');
				container.appendChild(text_field);

				var br = document.createElement('br');
				container.appendChild(br);

				var view_btn = document.createElement('button');
				view_btn.appendChild(document.createTextNode('Update'));
				view_btn.setAttribute('onclick','Update()');
				container.appendChild(view_btn);
			}
			counter=0;
		}




		function Update() 
		{
			var fname = document.getElementById('fname').value;
			var lname = document.getElementById('lname').value;
			var new_name = fname+" "+lname;
	
			var password = document.getElementById('pwd').value;

			if (fname!="" && lname!="" && password!="") 
			{
				var query = "UPDATE login SET first_name='"+fname+"',last_name='"+lname+"',password='"+password+"' WHERE user_id= '"+userid+"'";
				//alert(query);

				window.location.href = "connection.php?query="+query+"&userid="+userid+"&name="+new_name;
			}
			else
			{
				alert("Please fill all the fields..");
			}
		}





	</script>




</body>
</html>
