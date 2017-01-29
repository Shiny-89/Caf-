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
    wind += "<div>";
    wind += "<p> Ajouter un nouveau product</p>";
    wind += "<div class='form-group'><label for='name'>Nom : </label><input type='text' class='form-control' id='name'></div>";
    wind += "<label class='radio control-label'>Type</label><div class='radio radio-inline'><label><input type='radio' name='type'>Consomable</label></div>";
    wind += "<div class='radio radio-inline'><label><input type='radio' name='type'>Gros</label></div>";
    wind += "<label>Ajoutez une image du produit</label><label class='btn btn-default btn-file'>Image <input type='file' name='thumb' hidden></label>";
    wind += "<div class='form-group'><label for='price'>Prix d'achat : </label><input type='text' class='form-control' id='price'></div>";
    wind += "<div class='form-group'><label for='sell'>Prix de vente : </label><input type='text' class='form-control' id='sell'></div>";
    wind += "<div class='form-group'><label for='category'>Category : </label><select id='catefories'><option value='categorie'>Categorie</option><select><input type='text' class='form-control' id='category' placeholder='Ou ajoutez une nouvelle catégorie'></div>";
    wind += "<div class='form-group'><label for='sub-category'>Sous-Category : </label><select id='sub_catefories'><option value='ex-categorie'>Ex-Categorie</option><select><input type='text' class='form-control' id='category' placeholder='Ou ajoutez une nouvelle sous-catégorie'></div>";
    wind += "<button class='btn btn-default btn-danger' type='button' onclick='cancel_add();'>Annuler</button>";
    wind += "<button class='btn btn-default green btn-success' type='button' onclick='add_product();'>Ajouter</button>";
    wind += "</div></div>";

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
    el('wind').style.display ='block';
  }
}

function cancel_add(){
  el('layer').style.display ='none';
  el('new_prod').style.display ='none';
}
