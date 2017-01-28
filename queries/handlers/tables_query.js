function el(tar){// creating a custom element selector for the getElementByID method since its used a lot in this example .
     return document.getElementById(tar);
    }
create = function(obj,op){// this is also a custom elements and text nodes creator to simplify our code.
     switch (op){
	      case 'ele' : return document.createElement(obj);break;
	      case 'txt' : return document.createTextNode(obj);break;
	    }
	}


// tables array to hold table ids, numbers along  with their status
var tables= [];

function get_tables(){
	// Create our XMLHttpRequest object
	var request = new XMLHttpRequest();
	// Create some variables we need to send to our PHP file
	var url = "https://moncafe.000webhostapp.com/queries/queries/tables.php";
	var token = "tables";
	var vars = "query="+token;
	request.open("POST", url, true);
	// Set content type header information for sending url encoded variables in the request
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// Access the onreadystatechange event for the XMLHttpRequest object
	request.onreadystatechange = function() {
		if(request.readyState == 4 && request.status == 200) {
			var tables_array = request.responseText;
			tables = JSON.parse(tables_array);
			create_cafe_tables();
		}
	}
	// Send the data to PHP now... and wait for response to update the status div
	request.send(vars); // Actually execute the request
}

var tables_meta = [];
var tables_meta_clone = [];
var table_container = el("tables_container");

var table_class = "col-md-2 table_container";// the table class for styling;
var table_title_class = "col-md-12 table_title";// the table title class for styling;
var table_status_class = "col-md-12 table_status";// the table title class for styling;
var table_title_prefix = "Table N° :";// table title prefix;

table_obj =function (tb_num,tb_id,tb_status){
	this.num = tb_num;
	this.id = tb_id;
	this.status = tb_status;

	/*this.show_protocole = function(v){
		show_table_state(Number(v));
	}*/
	tables_meta.push(this);
}

var show = function(arg){
	show_table_state(arg);
}

function create_cafe_tables(){
	for (var i=0;i < tables['tables'].length;i++){
		// loading tables data from tables array populated from tables.php;
		var table_number = tables['tables'][i]['table_number'];
		var table_id = tables['tables'][i]['table_id'];
		var table_status = tables['tables'][i]['status'];
		var obj = new table_obj(table_number,table_id,table_status);

		//creaing the custom valid id for table assets;
		var custom_table_id = "table_"+table_id;
		// creating tables;
		var table = create('div','ele');
		table_container.appendChild(table);
		table.setAttribute('class',table_class);
		table.setAttribute('id',custom_table_id);
		// binding the click event to each table to perform the show_table_state funcion;
		table.onclick = show.bind(this, table_id);
		//creating table content;
		/* table title */
		var title_ele = create('div','ele');
		title_ele.setAttribute('class',table_title_class);
		/* _________________*/
		/* table status */
		var status_ele = create('div','ele');
		status_ele.setAttribute('class',table_status_class);
		/* _________________*/

		// appending created elements;
		el(custom_table_id).appendChild(title_ele);
		el(custom_table_id).appendChild(status_ele);

		// creating the text nodes and appending them to their respective holders;
		var title_txt = create(table_title_prefix+" "+table_number,'txt');
		if(table_status == 0){
			var status_text = "Table vide";
		}
		else {
			var status_text = "Table occupé";
		}
		var status = create(status_text,'txt');
		title_ele.appendChild(title_txt);
		status_ele.appendChild(status);
	}
}

function show_table_state(tar){

}
