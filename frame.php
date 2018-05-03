<!--
        Author: W3layouts
        Author URL: http://w3layouts.com
        License: Creative Commons Attribution 3.0 Unported
        License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
//assign passed variables
if (isset($_GET['tf']))
{
        $tags_found = $_GET['tf'];
        $tags_remain = $_GET['tr'];
        $guide_name = $_GET['gn'];
        $pc = $_GET['pc'];
        $pr = $_GET['pr'];
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
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
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
<?php 
if ( isset($_GET['np']) && $_GET['np'] != 1)
{
       echo(" <div id='dialog'>".$challenge_text . "</div>");
}
else{
	echo("<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css'>
		  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js'></script>
		  <script type='text/javascript'>
			$.confirm({
				title: 'New Player Detected',
				content: '' +
				'<form action=\"\" class=\"formName\">' +
				'<div class=\"form-group\">' + 
				'<label>Please enter your handle</label>' +
				'<input type=\"text\" placeholder=\"Batman\" class=\"name form-control\" required>' +
				'</div>' +
				'</form>',
				buttons: {
					formSubmit: {
						text: 'Submit',
						btnClass: 'btn-blue',
						action: function(){
							var hndl = this.$content.find('.name'),val();
							if (!handle){
								$.alert('a handle is required');
								return false;
							}
							var request = new XMLHttpRequest();
							request.open('POST', 'np.php',true);
								request.onreadystatechange = function()
							{
								if (this.readyState == 4 && this.status == 200)
								{
									var resp = this.responseText;
									if (resp == 'OK')
									{
										$.alert('Thank you ' + hndl);
									}
									else
									{
										$.alert('unknown error occurred');
				
									}
								}
							}
							request.setRequestHeader('Content-type', 'application/x-wwww-form-urlencoded');
							request.send('h=' + hndl + '&pid=' + ". $_SESSION['pid'] . ");
							}
					},
					cancel: function(){
						//close
					},
				},
				onContentReady: function(){
					var jc = this;
					this.$content.find('form').on('Submit', function (e){
						e.preventDefault();
						jc.$$formSubmit.trigger('click');
					});
				}
				});
		</script>
	");
}
?>

<div class="w3layouts-head">
        <h1>Hak4Kidz Building Block Multiverse(tm)</h1>

</div>
</div>
<!--main-->
<div class="main-w3l">
        <div class="w3layouts-main">
                <h2>Hak4Kidz Building Block Multiverse(tm)</h2>
        </div>
        <div class="agile-sub">
                <!--count-down -->
                <div class="count" >
                        <div class="agile_count_grid1">
                                <div class="agile_count_grid_left">
                                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                </div>
                                <div class="agile_count_grid_right">
                                        <h3>Pieces</h3>
                                        <?php echo('<p class="counter">' . $tags_found . '</p>'); ?> 
                                </div>
                                <div class="clear"> </div>
                                <h3>Found</h3>
                        </div>
                        <div class="pro-w3l">
                                <?php echo('<img src="images/' . $guide_name . '.png" alt="image" > <p>'. $guide_name .'</p>'); ?>
                        </div>
                        <div class="agile_count_grid2">
                                <div class="agile_count_grid_left">
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </div>
                                <div class="agile_count_grid_right">
                                        <h3>Pieces</h3>
                                        <?php echo('<p class="counter">' . $tags_remain . '</p>'); ?>
                                </div>
                                <div class="clear"> </div>
                                <h3>Remaining</h3>
                        </div>
                </div>

                <!-- //count-down -->

        </div>
        <div class="progress-w3l">
                <div class="agile-info">
                        <p>Total Progress<p>
                        <h4><?php echo($pc); ?></h4>
                        <div class="clear"></div>
                </div>
                <div class="pro_bar">
                        <?php echo('<p>' . $pc . '</p> <h6>' . $pr . '</h6>'); ?>
                </div>
                        <?php echo('<div class="progressbars" progress="' . $pc . '%"></div>'); ?>
                                        <!-- js -->
                                <!--<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>-->
                <!-- //js -->
                <!-- js files -->
                <!-- Starts-Number-Scroller-Animation-JavaScript -->
                                        <script src="js/waypoints.min.js"></script> 
                                        <script src="js/counterup.min.js"></script>
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
                                        <script src="js/jprogress.js" type="text/javascript"></script>
                                                <script>
                                                        // activate jprogress
                                                        $(".progressbars").jprogress({
                                                                background: "#E67E22"
                                                        });
    


                        </div>
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