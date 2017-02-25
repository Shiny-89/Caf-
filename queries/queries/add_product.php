<?php


require_once('packages/db_connect.php');

// this function checks if a given parent or child category $poc exits already using itsname $c
// this function returns the category id and its parent id if available as an associative array
$category_id;
function cat_exist($c, $poc, $pi){
	if ($poc == "parent"){
		$tmp_query = "SELECT category_id FROM categories WHERE parent_id=0 category_name=".$c;
		$tmp_result = $con->query($tmp_query);

		if ($tmp_result->num_rows > 0){
				$row = $tmp_result->fetch_array;
				$category_id = $row['category_id'];
			  /* $cat_id = $row['category_id']; */
				return true;
			}
			return false;
		}

		elseif ($poc == "child") {
			$tmp_query = "SELECT category_id FROM categories WHERE parent_id=".$pi." category_name=".$c;
			$tmp_result = $con->query($tmp_query);

			if ($tmp_result->num_rows > 0){
					$row = $tmp_result->fetch_array;
					$category_id = $row['category_id'];
				  /* $cat_id = $row['category_id']; */
					return true;
				}
				return false;
		}
}

// retrieve the given category id
function get_category_id($c, $poc, $pi){
	if($poc == 'parent'){
		$tmp_query = "SELECT category_id FROM categories WHERE parent_id=0 category_name=".$c;
		if ($tmp_result->num_rows > 0){
				$row = $tmp_result->fetch_array;
				$category_id = $row['category_id'];
				return $category_id;
			}
			else return 'undefined';
	}

	if($poc == 'child'){
		$tmp_query = "SELECT category_id FROM categories WHERE parent_id=".$pi." category_name=".$c;
		if ($tmp_result->num_rows > 0){
				$row = $tmp_result->fetch_array;
				$category_id = $row['category_id'];
				return $category_id;
			}
			else return 'undefined';
	}
}

$err = Array();
$success = "";

$prod_name = $_POST['prod_name'];
$cat = $_POST['cat'];
$newcat = $_POST['new_cat'];
$sub = $_POST['sub'];
$newsub = $_POST['new_sub'];
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
		 				 $err[]='La taille doit avoir un maximum de 2 MB';
					}

					if(empty($err)==true) {
	         	 move_uploaded_file($file_tmp,"uploads/".$file_name);
	      	}
			}

			//checking catgories entred by the user
			//defining parent category name
			if ($newcat != ''){
				$pcat = $newcat;
			}
			else $pcat = $cat;

			//defining sub-cetegory name
			if ($newsub != ''){
				$scat = $newsub;
			}
			else $scat = $sub;

			//checking if the parent category already exists
			if (cat_exist($pcat,'parent')){
				$cat_id = $category_id;
			}
			// if the parent category doesn't exist we add a new category record to the categories table
			else{
				$cat_query = $con->prepare("INSERT INTO categories (category_name,parent_id,add_date) VALUES(?, ?, ?)");

				$cat_query->bind_param("iss", $name, $parent_id, $date);
				$name = (string)$pcat;
				$parent_id = 0;
				$date = (string)date(Y,m,d H:i:s);

				if ($cat_query->execute()){
					$cat_inserted = TRUE;
					$cat_id = get_category_id($pcat, "parent");
				}
			}

			//checking if the sub category already exists
			if(cat_exist($scat, 'child', $cat_id)){
				$sub_id = $category_id;
			}
			//if the sub-category doesn't exist we add a new record of this category to our under the previously selected parent id
			else {
				$cat_query = $con->prepare("INSERT INTO categories (category_name,parent_id,add_date) VALUES(?, ?, ?)");

				$cat_query->bind_param("iss", $name, $parent_id, $date);
				$name = (string)$scat;
				$parent_id = $cat_id;
				$date = (string)date(Y,m,d H:i:s);

				if ($cat_query->execute()){
					$sub_cat_inserted = TRUE;
					$sub_id = get_category_id($scat, "child", $cat_id);
				}
			}


		// inserting all gathered records to the products table
		$main_query = $con->prepare("INSERT INTO products (product_name,category_id,sub_category,type,quantity,unit,thumbnail,editer_id,buying_price,selling_price,last_edit) VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");
		$main_query->bind_param("siiiissiiis",$prod_name,$cat_id,$sub_id,$type,0,$unit,$file_name,$_SESSION['id'],$price,$selling_price,date(Y,m,d H:i:s));

		if($main_query->execute()){
			$success = "Le produit a été bien ajouter";
			echo "product has been successfully added";
		}

		else{
			$err[] = "une erreur est survenue lors d'enregistrement du produit";
		}
}

else{
	$err[] = "Vous devez remplir tous les informations concernant le produit";
}


?>
