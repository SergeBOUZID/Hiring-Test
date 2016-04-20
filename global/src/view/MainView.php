<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="<?php echo(CONF_CHARSET_ENCODING); ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo(CONF_CHARSET_ENCODING); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo($this->getStrUrlProject('/public/css/CssSheet.css')); ?>" media="screen" />
	</head>
  
	<body>
		<?php // Init var ?>
		<?php 
			$strRteActivNm = $this->getRouteActivNm();
		?>
		
		
		
		<?php // Main content ?>
		<div class="container">
			<div class="header clearfix">
				<nav>
					<ul class="nav nav-pills pull-right">
						<li role="presentation" class="<?php if($strRteActivNm == 'HomePageShow'){echo('active');} ?>">
							<a href="<?php echo($this->getRouteUrl('HomePageShow')); ?>">Home</a>
						</li>
						<li class="<?php if($strRteActivNm == 'ProdPageListShow'){echo('active');} ?>">
							<a href="<?php echo($this->getRouteUrl('ProdPageListShow')); ?>?cur_id=1">Canadian Products</a>
						</li>
						<li class="<?php if($strRteActivNm == 'WeatherPageShow'){echo('active');} ?>">
							<a href="<?php echo($this->getRouteUrl('WeatherPageShow')); ?>">Montreal Weather</a>
						</li>
						<li style="cursor:pointer;">
							<a onclick="$('#wbs-popup-info-id').modal('show');" ><span class="glyphicon glyphicon-info-sign" ></span> Information</a>
						</li>
					</ul>
				</nav>
				<h3 class="text-muted">SSENSE - IT</h3>
			</div>
			
			[[Block:BlockPageBody]]
			[[/Block:BlockPageBody]]
			
			<footer class="footer">
				<p>&copy; 2016 SSENSE</p>
			</footer>
		</div>
		
		
		
		<?php // Popup info ?>
		<div 
			class="modal fade in" 
			id="wbs-popup-info-id" 
			tabindex="-1" 
			role="dialog" 
			aria-labelledby="" 
			aria-hidden="true" 
		> 
		<div class="modal-dialog"> 
		<div class="modal-content" style="padding:5px;" > 
			<div id="id-modal-header" class="modal-header"> 
				<h4 class="modal-title"> Information 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
				</h4>
			</div> 
			<div id="id-modal-body" class="modal-body row" > 
				<strong>Concernant le framework Silex :</strong><br />
				Je ne connais pas ce framework, de plus j'ai eu du mal à trouver de l'aide rapidement sur internet, la doc demandant un temps de recherche plus conséquenc.<br />
				C'est pourquoi j'ai fais ce projet avec un autre framework MVC : <br />
				<a href="http://www.peoplewbs.com/LibertyCode/" target="_blank">http://www.peoplewbs.com/LibertyCode/</a><br />
				Il s'agit d'un framework entièrement codé par mes soins et en libre service. Il permet de réaliser tout aussi bien le travail demandé.<br />
				<br />
				<br />
				<strong>Concernant l'exercice de gestion de la mémoire en cache :</strong><br />
				Je ne connais malheureusement pas ces systèmes, J'ai donc fais avec ce que je pouvais. Je serais intéressé de pouvoir en découvrir davantage sur mes futurs postes.<br />
				<br />
				<br />
				<strong>Base de données :</strong><br />
				<ul>
					<li>Accès à PhpMyAdmin: <a href="/phpmyadmin/" target="_blank">/phpmyadmin/</a></li>
					<li>Db name: <strong><?php echo(CONF_DB_NM); ?></strong></li>
					<li>User: <strong><?php echo(CONF_DB_USER); ?></strong></li>
					<li>Password: <strong><?php echo(CONF_DB_PW); ?></strong></li>
				</ul>
			</div>
			<div class="modal-footer"> 
				<button type="button" class="btn btn-primary pull-right" style="margin-right:5px;" onclick="$('#wbs-popup-info-id').modal('hide');">OK</button> 
			</div> 
		</div> 
		</div> 
		</div> 
		
		
		<?php // Javascript ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<script type="text/javascript" src="<?php echo($this->getStrUrlProject('/public/script/ScriptToolBox.js')); ?>"></script>
		<script type="text/javascript" src="<?php echo($this->getStrUrlProject('/public/script/ScriptUsual.js')); ?>"></script>
		<script type="text/javascript" src="<?php echo($this->getStrUrlProject('/public/script/ScriptAjax.js')); ?>"></script>
		
	</body>
</html>