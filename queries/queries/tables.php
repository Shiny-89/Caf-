<?php
	require_once('../../includes/db_connect.php');
	
	$query = "SELECT * FROM tables";
	$result = $con->query($query);
	$arr = Array();
	if ($result->num_rows > 0){

		while($table = $result->fetch_assoc()){
			array_push($arr,array('table_id'=>$table['table_id'],'table_number'=>$table['table_num'],'status'=>$table['status']));
			/*echo "[ 'table_number' :".$table['table_num'].",'table_id':".$table['table_id'].",'status' : ".$table['status']."],";*/
		}
		
		echo json_encode(array('tables'=>$arr));

	}
?>