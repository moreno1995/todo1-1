<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO 1</title>
    <!-- Lien vers la bibliothèque Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  </head>
  
  <body>

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>TODO 1</h1>
          <a href="https://github.com/nioperas06/todo1">Source</a>
          <hr>
          <form role="form" method="post" id="form" class="form-inline">
            <fieldset>
               <div class="form-group">
                <label class="col-sm-4 control-label">Ville de départ</label>
                <div class="col-sm-4">
                  <input id="ville_depart" name="ville_depart" class="form-control" required placeholder="Commencez à insérer...">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Ville d'arrivée</label>
                <div class="col-sm-4">
                  <input id="ville_arrivee" name="ville_arrivee" class="form-control" required placeholder="Commencez à insérer...">
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
          <div id="resultat" class="well">
         
          </div>
          </div>
        </div>
      
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
if($value[1]==$towns[0]) continue; //On exclut la ville entrée
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
      
  <div class="alert alert-success" <?php if(!isset($_POST['ville_arrivee'])) echo 'hidden1="hidden1"' ?> id="geobytesnearbycities">
<h3>Les villes les plus proches de <?php echo($_POST['ville_arrivee']); ?> :</h3>
<?php if(isset($_POST['ville_arrivee'])){
$villes1=$_POST['ville_arrivee'];
$towns1=explode(',',$villes1);
if(!$tags1=json_decode(file_get_contents(
"http://getnearbycities.geobytes.com/GetNearbyCities?Radius=1000&units=km&Limit=5&locationcode=".$towns1[0]
),
true)) throw new Exception("Error Processing Request", 1);
if($tags1){
foreach ($tags1 as $key1 => $value1) {
if(isset($value1[1])){
if($value1[1]==$towns1[0]) continue; //On exclut la ville entrée
echo($value1[1]).'<br>';
}else{
$erreur1=1;
break;
}
}
}
if (isset($erreur1)) {
?>
<div class="alert alert-danger">Des villes fantaisistes renverront un résultat fantaisiste !</div>
<?php
}
 }
?>
</div>    
  </div>    

    <!-- Inclusion de Google Maps JS API 
      On insère une clé key=AIzaSyCNK00ftWsZDXQhCgx3zn825j_O_N6a-o8
    -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNK00ftWsZDXQhCgx3zn825j_O_N6a-o8&libraries=places"></script>
    
      <script type="text/javascript">
      
      //  On fait appel à l'API pour aujouter l'auto-complétion
      // On donne en paramètres l'id des champs à auto-complèter  
      
      google.maps.event.addDomListener(window, 'load', function() {
        initializeAutocomplete('ville_depart');
        initializeAutocomplete('ville_arrivee');
      });

      function initializeAutocomplete(id) {
        
        var element = document.getElementById(id);
        
        if (element) {
          
          var autocomplete = new google.maps.places.Autocomplete(
            element,
            { types: ['(cities)'] }
            );
          google.maps.event.addListener(
            autocomplete,
            'place_changed',
            onPlaceChanged);
        
        }

      }

      //  La fonction de callback onPlaceChanged()
      var lat_depart="null";
      var lng_depart="null";
      var lat_arrivee="null";
      var lng_arrivee="null";
      function onPlaceChanged() {
      	
      	var geocoder = new google.maps.Geocoder();
      	var ville_depart=document.getElementById("ville_depart").value;
      	var ville_arrivee=document.getElementById("ville_arrivee").value;
      	geocoder.geocode(
      			{ 'address': ville_depart},
      			function (results,status) {
      				// Si l'adresse a pu être géolocalisée
      				if(status==google.maps.GeocoderStatus.OK){
      					lat_depart=results[0].geometry.location.lat();
      					lng_depart=results[0].geometry.location.lng();
      				}
      			}
      		);
      	geocoder.geocode(
      			{ 'address': ville_arrivee},
      			function (results,status) {
      				// Si l'adresse a pu être géolocalisée
      				if(status==google.maps.GeocoderStatus.OK){
      					lat_arrivee=results[0].geometry.location.lat();
      					lng_arrivee=results[0].geometry.location.lng();
      				}
      			}
      		); 

      }

      </script>
     

  </body>
</html>




