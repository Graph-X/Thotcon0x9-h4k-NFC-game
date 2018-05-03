<!--
        Author: W3layouts
        Author URL: http://w3layouts.com
        License: Creative Commons Attribution 3.0 Unported
        License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_name('MULTIVERSE');
session_start();
//assign passed variables
if (isset($_GET['ct']))
{
        $challenge_text = $_GET['ct'];
        $challenge_text = base64_decode($challenge_text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Hak4Kidz Building Block Multiverse(tm)</title>
<!-- Meta tag Keywords removed by Graph-X -->
<meta charset="utf-8">
<!-- css files -->
<link href="css/style2.css" rel="stylesheet" type="text/css" media="all">
<link href="css/jque.css" rel="stylesheet" type="text/css">

<link href="//fonts.googleapis.com/css?family=Voltaire" rel="stylesheet">
<!--//online-fonts -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">-->
</head>
<body>
<!--header-->
<!--//header-->

<div id='dialog'><?php echo($challenge_text) ?></div>

<div class="w3layouts-head">
<h1>CONGRATULATIONS!!!</h1>

</div>
</div>
<!--main-->
<div class="main-w3l">
        <div class="w3layouts-main">
        </div>
        
        <div class="progress-w3l">
			<script>
				jQuery(document).ready(function( $ ) {
				$('.counter').counterUp({
				delay: 20,
				time: 2000
				});

				$( "#dialog" ).dialog({ 
						autoOpen: false, 
						modal: true, 
						show: { 
								effect: "puff", 
								duration: 1000 
						}, 
						hide: { 
								effect: "explode", 
								duration: 1000
						},
				} );
				$( "#dialog" ).dialog( "open" );
				$( "#dialog" ).click(function() {
				$( "#dialog" ).dialog( "close" );
				});
				});
			</script>
        </div>
</div>
<!--//main-->


<!--footer-->
<footer>
        <p></p>
</footer>

<!--//footer-->

</body>
</html>