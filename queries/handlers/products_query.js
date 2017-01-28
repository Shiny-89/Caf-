function get_products(){
	// Create our XMLHttpRequest object
	var request = new XMLHttpRequest();
	// Create some variables we need to send to our PHP file
	var url = "products.php";
	var token = "products";
	var vars = "query="+token;
	request.open("POST", url, true);
	// Set content type header information for sending url encoded variables in the request
	request.setRequestHeader("Content-type", "application/json", true);
	// Access the onreadystatechange event for the XMLHttpRequest object
	request.onreadystatechange = function() {
		if(request.readyState == 4 && request.status == 200) {
			var products_array = json.parse(request.responseText);
			return products_array;
		}
	}
	// Send the data to PHP now... and wait for response to update the status div
	request.send(vars); // Actually execute the request
}