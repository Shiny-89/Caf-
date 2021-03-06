el = function(tar){// creating a custom element selector for the getElementByID method since its used a lot in this example .
     return document.getElementById(tar);
    };
create = function(obj,op){// this is also a custom elements and text nodes creator to simplify our code.
     switch (op){
	      case 'ele' : return document.createElement(obj);break;
	      case 'txt' : return document.createTextNode(obj);break;
	    }
	}

var wind; // this variable will hold the Adding product window
var layer; // this variable will hold the tansparent layer behind the Adding product window

function adding_window(){
  var wind = el('new_prod');//selecting the adding product window
  var layer = el('layer');//selecting the layer

  if (!wind){// checking if the window exist already in the markup
    //creating our window for adding a new product
    wind = "<div id='new_prod'>";
    wind += "<div><form id='prod_add_form' enctype='multipart/form-data'>";
    wind += "<p> Ajouter un nouveau produit</p>";
    wind += "<div class='form-group'><label for='name'>Nom : </label><input type='text' class='form-control' id='name' name='prod_name'></div>";
    wind += "<label class='radio control-label'>Type : </label><div class='radio radio-inline'><label><input type='radio' name='type' value='1'>Consomable</label></div><div class='radio radio-inline'><label><input type='radio' name='type' value='2'>Gros</label></div>";
    wind += "<div class='form-group'><label class='select control-label'>Unité</label><select name='unit' id='unit'><option value='kg'>KG</option><option value='lt'>Litre</option><option value='piece'>piece</option></select><input type='text' class='form-control' id='category' placeholder='Ou ajoutez une nouvelle catégorie'></div>";
    wind += "<label>Ajoutez une image du produit</label><label class='btn btn-default btn-file'>Image <input type='file' name='image' id='prod_thumb' hidden></label>";
    wind += "<div class='form-group'><label for='price'>Prix d'achat : </label><input type='text' class='form-control' id='price' name='price'></div>";
    wind += "<div class='form-group'><label for='sell'>Prix de vente : </label><input type='text' class='form-control' id='sell' name='selling_price'></div>";
    wind += "<div class='form-group'><label for='category'>Category : </label><select id='categories' name='cat'><option value='categorie'>Categorie</option></select><input type='text' class='form-control' id='category' name='new_cat' placeholder='Ou ajoutez une nouvelle catégorie'></div>";
    wind += "<div class='form-group'><label for='sub-category'>Sous-Category : </label><select id='sub_categories' name='sub'><option value='ex-categorie'>Ex-Categorie</option></select><input type='text' class='form-control' id='sub_category' name='new_sub' placeholder='Ou ajoutez une nouvelle sous-catégorie'></div>";
    wind += "<button class='btn btn-default btn-danger' type='button' onclick='cancel_add();'>Annuler</button>";
    wind += "<button class='btn btn-default green btn-success' id='sub_button' type='button'>Ajouter</button>";
    wind += "</form></div></div>";

    if (!layer){// checking if the layer exist already in the markup
      // creating the layer which will serve as an assiette for our window
      layer = "<div class='trans-layer' id='layer'></div>";

        document.getElementsByTagName('body')[0].innerHTML += layer;
        el('layer').style.display ='block';
    }

      document.getElementsByTagName('body')[0].innerHTML += wind;
      el('new_prod').style.display = 'block';
  }
  else {
    el('layer').style.display ='block';
    el('new_prod').style.display ='block';
  }
}

function cancel_add(){
  el('layer').style.display ='none';
  el('new_prod').style.display ='none';
}
