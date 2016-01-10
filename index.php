<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO 1</title>
    <!-- Lien vers la bibliothèque Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/flick/jquery-ui.css" />
    
  </head>
  
  <body>

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>TODO 1</h1>
          <a href="https://github.com/nioperas06/todo1">Source</a>
          <hr>
          <form action="index.php" method="post" class="form-inline" name="form_citydetails" id="form_citydetails" enctype="multipart/form-data">  
            <fieldset>
               <div class="form-group">
                <label class="col-sm-4 control-label">Ville de départ</label>
                <div class="col-sm-4">
                  <input id="f_elem_city" name="ville_depart" required class="form-control" placeholder="Commencez à insérer...">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-4">
                  <button class="btn btn-primary" name="cherchez" id="cherchez" type="submit">Cherchez</button>
                </div>
              </div>
            </fieldset>
          </form>
          <br>
          <!--
               Ici se trouve le script PHP qui donne les cinq villes aux alentours , script inspiré de http://geobytes.com/get-nearby-cities-api/
          -->
          <div class="alert alert-success" <?php if(!isset($_POST['ville_depart'])) echo 'hidden="hidden"' ?> id="geobytesnearbycities">
              <h3>Les villes les plus proches de <?php echo($_POST['ville_depart']); ?> :</h3>
              <?php if(isset($_POST['ville_depart'])){
                  $villes=$_POST['ville_depart'];
                  $towns=explode(',',$villes);

                        if(!$tags=json_decode(file_get_contents(
                           "http://getnearbycities.geobytes.com/GetNearbyCities?Radius=1000&units=km&Limit=5&locationcode=".$towns[0]
                           ),
                            true)) throw new Exception("Error Processing Request", 1);
                        if($tags){    
	                        foreach ($tags as $key => $value) {
	                           if(isset($value[1])){
	                           if($value[1]==$towns[0]) continue;	//On exclut la ville entrée
	                           echo($value[1]).'<br>';
	                        	}else{
	                        		$erreur=1;
	                        		break;
	                        	}
	                        }
                        }
                        if (isset($erreur)) {
                        	?>
                        	          <div class="alert alert-danger">Des villes fantaisistes renverront un résultat fantaisiste !</div>
                        	          <?php
                        }
                    
               }
               ?>
          </div>
        </div>
      </div>
    </div>
    
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <!--
      Le script ci-dessous est tiré intégralement de http://geobytes.com/free-ajax-cities-jsonp-api/
     -->
    <script type="text/javascript">
    jQuery(function () 
    {
        jQuery("#f_elem_city").autocomplete({
            source: function (request, response) {
            jQuery.getJSON(
                "http://gd.geobytes.com/AutoCompleteCity?callback=?&Limit=10&q="+request.term,
                function (data) {
                response(data);
                }
            );
            },
            minLength: 3,
            select: function (event, ui) {
            var selectedObj = ui.item;
            jQuery("#f_elem_city").val(selectedObj.value);
            getcitydetails(selectedObj.value);
            return false;
            },
            open: function () {
            jQuery(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
            jQuery(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        jQuery("#f_elem_city").autocomplete("option", "delay", 100);
        
    });
        
    </script>
  </body>
</html>




