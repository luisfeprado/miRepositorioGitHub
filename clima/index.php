<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="estilos.css">
</head>
<body>
<script src="js/mi.js"></script>
 <form action="consulta.php" class="form-inline" method="post">
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
				<img src="imagenes\clima.jpg" alt=""  width="300" height="300">
	        </div>
	        <div class="col-md-6">
		        <div class="ms_div_des_prod">
		        	<h3 class="text-propercase"><b>Clima en tu ciudad</b></h3>		        	
					<p>Escriba el nombre la ciudad:</p>	
		        </div>
				<br>
		        <div>
					<div class="form-group">						
						<input class="form-control" onkeypress="return validar(event)"  id="ciudad" name="ciudad" type="text" placeholder="Ciudad:" style="width:100%"><br><br>
						<input type="submit" class="btn btn-primary btn-lg btn-block" value="Buscar">										
					</div>
					<br>

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