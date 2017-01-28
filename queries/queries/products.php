<?php

if ($_POST['query'] == "products"){
	require_once('packages/db_connect.php');
	
	$query = "SELECT product_name AS p_name AND quantity AS qty AND category AS cat AND sub_category AS sub_cat FROM products WHERE type='selling_product'";
	$result = $con->query($query);
	$prducts = Array();
	if ($result->num_rows > 0){
		while($product = $result->fetch_array){
			$products[] = $product;
		}
		print json_encode($products[]);
	}
}

?>