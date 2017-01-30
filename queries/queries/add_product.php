<?php

if ($_POST['query'] == "add"){
	require_once('packages/db_connect.php');

	$err = Array();
	$success = "";

	$prod_name = $_POST['prod_name'];
	$cat = $_POST['cat'];
	$sub = $_POST['sub'];
	$type = $_POST['type'];
	$price = $_POST['price'];
	$selling_price = $_POST['selling_price'];
	$unit = $_POST['unit'];

	if ($prod_name && $cat && $sub && $type && $price && $selling_price && $unit){
		//checking the uploaded image
			if (isset($_FILES['image'])){
						$file_name = $_FILES['image']['name'];
		        $file_size = $_FILES['image']['size'];
		        $file_tmp = $_FILES['image']['tmp_name'];
		        $file_type = $_FILES['image']['type'];
		        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

		        $expensions= array("jpeg","jpg","png");

						if(in_array($file_ext,$expensions)=== false){
			         $err[]="extension non autorisé, S'il vous plait choisir l'extension JPEG ou PNG.";
			      }

						if($file_size > 2097152) {
			 				 $err[]='La taille doit avoit un maximum de 2 MB';
						}

						if(empty($err)==true) {
		         	 move_uploaded_file($file_tmp,"uploads/".$file_name);
		      	}
				}

				//checking if the category already exists
				$tmp_query = "SELECT category_id FROM categories WHERE category_name=".$cat;
				$tmp_result = $con->query($tmp_query);

				if ($tmp_result->num_rows > 0){
					$row = $tmp_result->fetch_array;
					$cat_id = $row['category_id'];

					//in here we have an existing category so next we're gonna check if the sub category exists within the selected category
					$tmp_query = "SELECT parent_id FROM categories WHERE category_name=".$sub;
					$tmp_result = $con->query($tmp_query);

					if($tmp_result->num_rows > 0){
						$row = $tmp_result->fetch_array;
						$sub_id = $row['category_id'];
					}
					// if the sub category doesn't exist within our existed category we will implement the new added sub category
					else{
						$sub_query = $con->prepare("INSERT INTO categories (category_name,parent_id,add_date) VALUES(?, ?, ?)");

						$sub_query->bind_param("iss", $name, $parent_id, $date);
						$name = (string)$sub;
						$parent_id = (int)$cat_id;
						$date = (string)date(Y,m,d H:i:s);

						/*checking if the sub category is inserted otherwise a note will be dislpayed after everything is finished
						to tell the user to manually add the sub category and assign it to the newly added product*/
						if ($sub_query->execute()){
							$sub_inserted = TRUE;
							$tmp_query = "SELECT category_id FROM categories WHERE category_name=".$sub;
							$tmp_result = $con->query($tmp_query);

							if($tmp_result->num_rows > 0){
								$row = $tmp_result->fetch_array;
								$sub_id = $row['category_id'];
							}
						}

						else{
							$sub_inserted = FALSE;
						}
					}
				}
				// so the category entred by the user doesn't exist
				// we will add the new category to the database categories table along with the sub category
				else {
					$cat_query = $con->prepare("INSERT INTO categories (category_name,parent_id,add_date) VALUES(?, ?, ?)");

					$cat_query->bind_param("iss", $name, $parent_id, $date);
					$name = (string)$cat;
					$parent_id = 0;
					$date = (string)date(Y,m,d H:i:s);

					if ($cat_query->execute()){
						$cat_inserted = TRUE;
						$tmp_query = "SELECT category_id FROM categories WHERE category_name=".$cat;
						$tmp_result = $con->query($tmp_query);

						if($tmp_result->num_rows > 0){
							$row = $tmp_result->fetch_array;
							$cat_id = $row['category_id'];

							$sub_query = $con->prepare("INSERT INTO categories (category_name,parent_id,add_date) VALUES(?, ?, ?)");

							$sub_query->bind_param("iss", $name, $parent_id, $date);
							$name = (string)$cat;
							$parent_id = $cat_id;
							$date = (string)date(Y,m,d H:i:s);

							if ($cat_query->execute()){
								$sub_inserted = TRUE;
								$tmp_query = "SELECT category_id FROM categories WHERE category_name=".$cat;
								$tmp_result = $con->query($tmp_query);

								if($tmp_result->num_rows > 0){
									$row = $tmp_result->fetch_array;
									$sub_id = $row['category_id'];
								}
							}

							else{
								$sub_inserted = FALSE;
							}

						}
					}

					else{
						$cat_inserted = FALSE;
					}

				}

				$main_query = $con->prepare("INSERT INTO products (product_name,category_id,sub_category,type,quantity,unit,thumbnail,editer_id,buying_price,selling_price,last_edit) VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");
				$main_query->bind_param("siiiissiiis",$prod_name,$cat_id,$sub_id,$type,0,$unit,$file_name,$_SESSION['id'],$price,$selling_price,date(Y,m,d H:i:s));

				if($main_query->execute()){
					$success = "Le produit a été bien ajouter";
				}

				else{
					$err[] = "une erreur est survenue lors d'enregistrement du produit";
				}
	}

	else{
		$err[] = "Vous devez remplir tous les informations concernant le produit";
	}
}

?>
