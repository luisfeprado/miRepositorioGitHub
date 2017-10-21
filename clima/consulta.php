<?php
function callWebService(){ 
	  if(isset($_POST) && (trim($_POST['ciudad'])=='' || $_POST['ciudad']==null)){
			$ciudad='caracas';
	  }else if (isset($_POST)){
			$ciudad= $_POST['ciudad']; 	
	  }
	try{
	  $url='http://api.openweathermap.org/data/2.5/weather?q='.$ciudad.'&appid=a25e715d4b3542cda9e2db21f9c36c78';

	  $json = file_get_contents($url);
	  $array = json_decode($json,true);
	  }
	 catch (Exception $e) { 
		echo $e->getMessage();
	    echo $e->getCode();
	} 
	  return $array;
}

//########################## MAIN ##############################
$resultado = callWebService();
//##############################################################

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="estilos.css">
</head>
<body>

 <form  class="form-inline" action="index.php">
	<header>		
		<div class="container">
			<section class="row">
				<div class="col-md-12 col-md-2" align="center">
					<img src="imagenes\icono.png" alt=""  height="65" width="65">	
				</div>					
				<div class="col-md-12 col-md-9" align="center">					
						<h3 class="text-propercase"><b>Weather App</b></h3>					
				</div>					
				<div class="col-md-12 col-md-1" align="center">
			
				</div>					

			</section>
		</div>
	</header>
	<br>




	<div class="container-fluid">
	    <div class="row">
	        <div class="col-md-3 col-md-offset-2">
				<img src="imagenes\clima2.jpg" alt=""  width="300" height="300">
	        </div>
	        <div class="col-md-6">
		        <div class="ms_div_des_prod">
		        	<h3 class="text-propercase"><b>Clima en tu ciudad</b></h3>	        	
				</div>
				<br>
		        <div>
				<div class="table-responsive">
				  <table class="table">
				  	<tr>
				  		<td class="active" colspan="4" align="center"><b><?php echo $resultado['name'].','. $resultado['sys']['country'];  ?><b></td>  		
				  	</tr>
				    <tr>
				  		<td class="info" width="25%">Temperatura:</td>
				  		<td width="25%"><?php  echo ((String)($resultado['main']['temp']-273.15)!=null?(String)($resultado['main']['temp']-273.15):null); ?> &#8451;</td>
				  		<td class="info" width="25%">Presión:</td>
				  		<td width="25%"><?php  echo $resultado['main']['pressure'].' hPa'; ?></td>
					</tr>
				    <tr>
				  		<td class="info" width="25%">Temp. mínima:</td>
				  		<td width="25%"><?php  echo (String)($resultado['main']['temp_min']-273.15); ?> &#8451;</td>
				  		<td class="info" width="25%">Temp. máxima:</td>
				  		<td width="25%"><?php  echo (String)($resultado['main']['temp_max']-273.15); ?> &#8451;</td>
					</tr>
				    <tr>
				  		<td class="info" width="25%">Humedad:</td>
				  		<td width="25%"><?php  echo $resultado['main']['humidity'].' %'; ?></td>
				  		<td class="info" width="25%">Rapidez del Viento:</td>
				  		<td width="25%"><?php  echo $resultado['wind']['speed'].' m/seg'; ?></td>
					</tr>	
				    <tr>
				  		<td class="info" width="25%">Direcc.del Viento:</td>
				  		<td width="25%"><?php  
				  			if(isset($resultado['wind']['deg'])){
								echo $resultado['wind']['deg'];
								echo "&deg";
				  				} 
				  		 ?></td>				    	
				  		<td class="info" width="25%">Coord:</td>
				  		<td width="25%"><?php  echo 'lon: '.$resultado['coord']['lon'].' ,lat: '.$resultado['coord']['lat']; ?></td>
					</tr>
				    <tr>
				  		<td class="info" width="25%">Clima:</td>
				  		<td width="25%"><?php  echo $resultado['weather'][0]['main']; ?></td>
				  		<td class="info" width="25%">Desc.Clima:</td>
				  		<td width="25%"><?php  echo $resultado['weather'][0]['description']; ?></td>
					</tr>				
				  </table>
	
				</div>	
		        <div>
					<div class="form-group">						
						<input type="submit" class="btn btn-primary btn-lg btn-block" value="Regresar">										
					</div>
					<br>

		        </div>					


		        </div>	

	        </div>

	    </div>

	</div>
	<br>
	
	<footer>
		<span align="center">
			<br>
			<p class=""><strong>Luis Prado. Copyright. 2017. </strong></p>						
		</span>

		<br><br><br>
	</footer>


</form>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>