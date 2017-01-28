<?php
session_start();
if(isset($_SESSION["id"])){//checking the existence of a session otherwise push back to login page
	include('includes/head.php');
?>


<!--nav menu -->
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
<!--nav menu end-->


<!-- main body container -->
<div class="container" id="container">
	<div class="row">
		<div class="col-md-12 store-manage" id="store_manage">

				<ul>
						<li>Filtres :</li>

						<li>
							<label>Catégorie</label>
							<select name='catgeory'>
								<option value="boisson">Boisson</option>
								<option value="pattisserie">Pattisserie</option>
								<option value="café">Café</option>
						  </select>
					  </li>

						<li>
							<label>Sous-Catégorie</label>
							<select name='catgeory'>
								<option value="boisson">jus</option>
								<option value="pattisserie">Gaz</option>
								<option value="café">Thé</option>
							</select>
						</li>

						<li><button class="btn btn-default" type="button">Filtrer</button></li>

						<li class="right"><a href='#' class='adding'>Ajouter un nouveau</a></li>
				</ul>
		</div>
	</div>
</div>
<!-- main container end -->





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
