<?php
$login_form = "
	<div class='container'>
		<div class='row'>
			<div class='col-md-6'></div>
			<div class='col-md-6'>
				<form action='login.php' method='post'>
						<div class='form-group row'>
							<label for='example-text-input' class='col-md-2 col-form-label'>Nom d'utilisateur :</label>
							<div class='col-md-10'>
								<input class='form-control' type='text' value='' id='un_field' name='username'>
							</div>
						</div>
						<div class='form-group row'>
							<label for='example-text-input' class='col-md-2 col-form-label'>Mot de passe :</label>
							<div class='col-md-10'>
								<input class='form-control' type='password' value='' id='pw_field' name='password'>
							</div>
						</div>
						<div class='form-group row'>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-primary' name='submit'>LOGIN</button>
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
";
if (isset($_POST['submit'])){

	if (isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		require_once('includes/db_connect.php');
		$query = "SELECT * FROM users WHERE username='$username'AND password='$password'";
		$result = $con->query($query);
		echo $query;
		if ($result->num_rows == 1){
			while($info = $result->fetch_array()){
				$id = $info['user_id'];
			}
			//starting user session
			session_start();
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $username;

			// redirect user to index page after successful login
			header("Location: https://moncafe.000webhostapp.com/");
			die();
		}

		else{
			$err = "votre nom d utilisateur ou votre mot de passe est erroné !";
			echo "<div class='err_msg'>".$err."</div>";
		}
	}

	else{
		$err = "S'il vous plais vottre nom d'utilisateur et mot de passe sont nécessaires !";
		echo "<div class='err_msg'>".$err."</div>";
	}
}
else {
	if (!isset($_SESSION['id'])){
		include('includes/head.php');
		echo $login_form;
		include('includes/foot.php');
	}
	else {
		// redirect user to index page if he tries to access login page while he's logged in
		$home = "https://moncafe.000webhostapp.com/";
		header("Location: ".$home);
		die();
	}
}
?>
