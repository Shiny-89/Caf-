<?php
session_start();	
if(isset($_SESSION["id"])){
	include('includes/head.php');
?>

		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">
						<img alt="logo" src="images/logo.png" width="136" height="75" style="margin-top: -26px;">
					</a>
				</div>
				<div class="nav navbar-nav navbar-center">
					<span><?php echo $_SESSION['username']; ?></span>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<!--<li><a href="#">Link</a></li>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Option <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="stock.php">Stock</a></li>
								<li><a href="#">Finances</a></li>
								<li><a href="#">Charts</a></li>
								<li role="separator" class="divider"></li>
								<li><a href=<?php echo "profile.php?id=".$_SESSION['id']." ";?>>Compte</a></li>
						</ul>
					</li>
				</ul>
				
			</div>
		</nav>
		
		<div class="container" id="container">
			<div class="row">
				<div class="col-md-12" id="tables_container">
				</div>
			</div>
		</div>
	
<?php
	include('includes/foot.php');
}

else{
	// redirect user to login page if he is not connected 
	$login_url = "https://moncafe.000webhostapp.com/login.php";
	header("Location: ".$login_url);
	die();
}
?>