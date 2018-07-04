<?php
	$conn = mysqli_connect("localhost", 'root', '');
	if($conn){
		mysqli_select_db($conn, 'ldkvote') or die("DB Error: ".mysqli_error($conn));
	}else{
		// slog('email', "failes to connect");
	}
?>