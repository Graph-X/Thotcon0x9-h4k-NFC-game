<?php
//Rediret for obvious scan attemptss and humor
if (preg_match("/masscan/",$_SERVER['HTTP_USER_AGENT']))
{
	header("Location: ftp://speedtest.tele2.net\1000GB.zip",true, 302);
	exit();
}
if (preg_match("/curl/",$_SERVER['HTTP_USER_AGENT']))
{
	header("Location: ftp://speedtest.tele2.net/1000GB.zip",true, 302);
	exit();
}
if (preg_match("/wget/",$_SERVER['HTTP_USER_AGENT']))
{
	header("Location: ftp://speedtest.tele2.net/1000GB.zip",true, 302);
	exit();
}
if (strtoupper($_GET['tag']) == '04:5C:65:B2:EC:4A:81')
{
	echo("<html><head><title>SUPER EXTRA BONUS LEVEL POINTS GOOD TIME YEAH!!!</title></head><body><script alert('YOU HAVE JUST FOUND AN EASTER EGG IN THE GAME!!!!  THAT MEANS YOU WIN STUFF!!  THE STRING BELOW IS A FLAG FOR THE CTF! USE IT TO GET SUPER MEGA MEGA POINTS!\n\n 195d32d553c8ad25c94d800eebe16baa')</script></body></html>");
       exit();
}	
// Hak4Kidz Chicago 2017 Building Block Multiverse NFC Game
// Codename: fake it till ya make it

session_name('MULTIVERSE');
session_start();
$DEBUG = true;
$_SESSION['DEBUG'] = true;


//General Game Mechanics Functions Start//


//builds the url to send to frame.php
function url_writer($response)
{
    $tf = $_SESSION['tf'];
    $tr = $_SESSION['tr'];
    $pr = $_SESSION['pr'];
    $pc = $_SESSION['pc'];
    if ($_SESSION['step'] == 0)
    {
        $gn = 'unknown';
    }
    else
    {
        $gn = $_SESSION['guide_name'];
    }
    $ct = base64_encode($response);
    $url = "frame.php?tf=".$tf ."&tr=" . $tr . "&gn=". $gn . "&pc=" . $pc . "&pr=". $pr . "&ct=" . $ct;
    return $url;
}
function console_walker($v,$k)
{
	if (empty($k)){
	echo('<script>console.log("[-] empty key was passed.");</script>');
	}
	echo('<script> console.log("'.$k .' ==> '. $v .'");</script>');
}

function num_challenges()
{
    include('dbconnect.php');
    $query = "SELECT * FROM challenges";
    $r = $mysqli->query($query) or trigger_error($mysqli->error);
    $mysqli->close();
    return $r->num_rows;
}
//get current challenge information

function challenge($id)
{
	if (!empty($id)){
		echo("<script>console.log('the number of the id is ". $id . "')</script>");
		include('dbconnect.php');
		$query = "SELECT ctext, ctag, answer, riddle, ranswer from challenges where id=" . $id;
		if ($c = $mysqli->query($query))
		{
			return $c->fetch_assoc();
		}
		else{ 
			return false; 
			}
	}
}


//Get the guide clues and current_tag information out of the database
function find_guides()
{
    $rando = rand(1,4);
    include('dbconnect.php');
    $r = $mysqli->query('select name, tag_id, corder, clues, welcome from guides where id=' . $rando);
    $mysqli->close();
    if ($arr = $r->fetch_assoc())
    {
		if ($_SESSION['DEBUG']) 
		{ 
			array_walk($arr, 'console_logger'); 
		}
        return $arr;
    }
    else
	{
        return false;
    }
}


//Check phone id 
function check_pid($pid)
{
    include('dbconnect.php');
    $result = $mysqli->query("SELECT * FROM guides WHERE phone = '" . $pid . "'" ) or trigger_error($mysqli->error);
    $row = $result->fetch_row();
    if (count($row) == 1);
    {
        return true;
    }
    return false;
}

//End General Game Mechannics Functions//

//Player Functions//
function add_player($pid){
	include('dbconnect.php');
	$query = "INSERT INTO players (pid,game_tag,challenges_solved,challenges_remain,guide_name) VALUES('".$pid."','".$_SESSION['game_piece']."','".$_SESSION['tf']."','".$_SESSION['tr']."','".$_SESSION['guide_name']."')";
	$r = $mysqli->query($query) or trigger_error($mysqli->error);
	$mysqli->close();
}
function retrieve_player($pid)
{
	include('dbconnect.php');
	$query = "select * from players where pid='".$pid."'";
	$r = $mysqli->query($query) or trigger_error($mysqli->error);
	$row = $r->fetch_row();
	if (count($row) === 1)
	{
		$arr = $r->fetch_assoc();
		$_SESSION['pid'] = $arr['pid'];
		$_SESSION['gtag'] = $arr['game_tag'];
		$_SESSION['guide_name'] = $arr['guide_name'];
		$_SESSION['tr'] = $arr['challenges_remain'];
		$_SESSION['tf'] = $arr['challenges_solved'];
		$_SESSION['handle'] = $arr['handle'];
		$_SESSION['char_elligible'] = $arr['char_elligible'];
		
	}
}
function update_player()
{
	include('dbconnect.php');
	$query = "update players set(challenges_remain=".$_SESSION['tr'].",challenges_solved=".$_SESSION['tf']." where pid=".$_SESSION['pid'];
}

//Session Functions//


//Check to see if the session exists
function session_exists($pid)
{
    if(isset($_SESSION['pid']) && $_SESSION['pid'] === $pid)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function new_session($pid, $tag)
{
    //clear out any esisting session
    session_unset();
    session_destroy();
    session_name('MULTIVERSE');
    session_start();
    session_regenerate_id(true);
	
    //building new session
    $_SESSION['pid'] = $pid;
    $_SESSION['game_piece'] = $tag;
    $_SESSION['handle'] = null;
    $r = find_guides();
    if ($r != false)
    {
        $_SESSION['guide_name'] = $r['name']; //Guide Name
        $_SESSION['guide_tag'] = $r['tag_id']; //Guide's tag
        $_SESSION['next_tag'] = $r['tag_id']; //Next tag to search for.
        $_SESSION['current_tag'] = null; //current tag in the "dugout"
        $_SESSION['step'] = 0; //Starting at zero
        $_SESSION['clues'] = $r['clues'];
        $_SESSION['order'] = $r['corder']; //challenge order for the guide.
        $_SESSION['welcome'] = $r['welcome'];
	$_SESSION['riddle'] = null; //Riddle 
	$_SESSION['ranswer'] = null; //riddle tag
	$_SESSION['np'] = 1; //new player 
        $_SESSION['tr'] = 5;
        $_SESSION['tf'] = 0;
        $_SESSION['pc'] = 0;
        $_SESSION['pr'] = 100;
        //      array_walk($_SESSION, 'iter_array');
    }

}

//returns assoc array of all the session values
function get_session()
{
    $handle = $_SESSION['handle'];
    $next_tag = $_SESSION['next_tag'];
    $guide_name = $_SESSION['guide_name'];
    $guide_tag = $_SESSION['guide_tag'];
    $current_tag = $_SESSION['current_tag'];
    $game_piece = $_SESSION['game_piece'];
    $step = $_SESSION['step'];
    $clues = $_SESSION['clues'];
    $welcome = $_SESSION['welcome'];
    $order = $_SESSION['order'];
    $np = $_SESSION['np'];
    $tf = $_SESSION['tf'];
    $tr = $_SESSION['tr'];
    $pc = $_SESSION['pc'];
    $pr = $_SESSION['pr'];
    $sess = array(
        'next_tag' => $next_tag,
        'guide_name' => $guide_name,
        'guide_tag' => $guide_tag,
        'current_tag' => $current_tag,
        'game_piece' => $game_piece,
        'step' => $step,
        'clues' => $clues,
        'welcome' => $welcome,
        'order' => $order,
        'tf' => $tf,
        'tr' => $tr,
        'pc' => $pc,
        'pr' => $pr,
	'handle' => $handle,
    );
    return $sess;
}
//save the current session
function save_session($sess)
{
    $_SESSION['handle'] = $sess['handle'];
    $_SESSION['next_tag'] = $sess['next_tag'];
    $_SESSION['guide_name'] = $sess['guide_name'];
    $_SESSION['guide_tag'] = $sess['guide_tag'];
    $_SESSION['current_tag'] = $sess['current_tag'];
    $_SESSION['step'] = $sess['step'];
    $_SESSION['game_piece'] = $sess['game_piece'];
    $_SESSION['clues'] = $sess['clues'];
    $_SESSION['order'] = $sess['order'];
    $_SESSION['welcome'] = $sess['welcome'];
    $_SESSION['tf'] = $sess['tf'];
    $_SESSION['tr'] = $sess['tr'];
    $_SESSION['pr'] = $sess['pr'];
    $_SESSION['pc'] = $sess['pc'];
 //   session_write_close();
}

// END SESSION FUNCTIONS  //



// ################################################3#####
// #
// #   Main routine
// #
// #
// #############################################################3

if (isset($_GET['tag']) && isset($_GET['pid']) ){
    $tag = strtoupper($_GET['tag']); //tag scanned
    $pid = strtoupper($_GET['pid']); //phone id
}
else {
    //Something went wrong redirect somewhere else
    header("Location: https://www.hak4kidz.com");
    exit;
}

if (session_exists($pid) == false)
{	
	new_session($pid,$tag);	
	add_player($pid,$tag);
}
// Get player's handle //
if ($_SESSION['np'] == 1)
{
	echo("
	<html>
	<head>
	<title>h4k building block multiverse</title>
	</head>
	<body>
	<script type='text/javascript'>
	function add_hndl(){
	var hndl = prompt('New player detected, please enter your handle');
	var req = new XMLHttpRequest();
	if (hndl == 'null'){ 
	alert('You must enter a handle in order to play the game');
	add_hndl();
	}
	req.open('POST','np.php',true);
	req.onreadystatechange = function(){
	  if (this.readyState == 4 && this.status == 200)
	  {
		  var resp = this.responseText;
		  if (resp == 'OK')
		  {
			 alert('Thank you ' + hndl);
			 location.reload();
			 
		  }
		  else{ alert('unknown error occured ' + resp);}
	   }
	}
	req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	req.send('h=' + hndl + '&gp=' + '".$_SESSION['game_piece']."');
	}
	add_hndl();	
        </script></body></html>");
	exit;
}

//getting the total number of challenges in the game
$ccount = num_challenges();

//game piece set? This will tell us if we have an existing session returning
if ($_SESSION['np'] < 1){
	$sess = get_session();
	if ($DEBUG) {
		echo ("<script> console.log('Current Session information:');</script>");
		array_walk($_SESSION, 'console_walker');
	}
	//Find your guide  Step 0a
	if ($_SESSION['step'] == 0)
	{				
		if ( $tag == $_SESSION['game_piece'])
		{
			if ($DEBUG) {echo('<script>console.log("we made it to the find your guide area...");</script>');}
			$message = "Oh no!  It looks as though your guide is a little bit lost... This is not good!  Especailly since they are supposed to be the ones keeping you from that fate! Fear not though, I have found some clues that might provide insight as to who and where your guide is.  If you think you know who it is, scan the tag that belongs to your guide.\n\n";
			$message = $message . $_SESSION['clues'];
			if ($DEBUG){echo("<script>console.log(" . $message . ")</script>");}
		}
	//Found our guide Step 0b
		if ($tag == $_SESSION['guide_tag'])
		{
			$_SESSION['step']++;
			$challenge = challenge($_SESSION['order'][$_SESSION['step']]);
			if ($DEBUG) { array_walk($challenge, 'console_walker'); }
			$message = $_SESSION['welcome'] . $challenge['ctext'];
			$_SESSION['next_tag'] = $challenge['ctag'];
		}
	//Not guide and not game piece
		if ($tag != $_SESSION['guide_tag'] && $tag != $_SESSION['game_piece'])
		{
			$message = "I'm sorry but this doesn't appear to be your guide.  Keep searching though!  The Multiverse Universe is counting on you!";
		}

	//Build url for iframe and write html
		$url = url_writer($message);
		//save_session($_SESSION);
		echo('<html><head><title>Hak4Kidz Building Block Multiverse</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
		exit();
	}


	//Challenges Steps 1-7
	if ($DEBUG) { echo("<script>console.log('STEP: ".$_SESSION['step']."')</script>"); }
	if ($_SESSION['step'] <= $ccount){
		//step 1
		if ($_SESSION['step'] != 0)
		{
			
			//grab the correct chllenge information.
			if ($_SESSION['step'] < $ccount){
				$challenge = challenge($_SESSION['order'][$_SESSION['step']]);
				if ($DEBUG) 
				{ 
					echo("<script>console.log('============current challenge information================')</script>");
					array_walk($challenge, 'console_walker'); 
					echo("<script>console.log('============end of challenge information=================')</script>");
				}
			}

			if ($_SESSION['step'] == $ccount )
			{
				$challenge = challenge($ccount);
				if ($DEBUG) { 
					echo("<script>console.log('==========================LAST CHALLENGE INFORMATION=======================')</script>");
					array_walk($challenge, 'console_walker'); 
					echo("<script>console.log('==========================END OF CHALLENGE INFORMATION=====================')</script>");
				}
					
			}
			
			//if we have just gotten to the challenge area and scanned the first tag.
			if ($tag == $challenge['ctag'] && $tag == $_SESSION['next_tag'])
			{
				if ($DEBUG) { echo("<script> console.log('app thinks ctag has been scanned')</script>"); }
				$message = $challenge['riddle'];
				$_SESSION['next_tag'] = $challenge['ranswer'];
				$_SESSION['current_tag'] = $tag;
				if ($_SESSION['step'] == $ccount)
				{
					if ($DEBUG){ echo("<script>console.log('Final challenge has been solved, you should see the winning screen');</script>") }
					$ct = base64_encode($message);
					$url = "final.php?ct=" . $ct;
					echo('<html><head><title>YOU WON!</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
					exit();
				}
				else{
					
					$url = url_writer($message);
					echo('<html><head><title>Hak4Kidz Building Block Multiverse</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
					exit();
				}
			}
			//if we have found the answer to the riddle and scanned that tag.
			if ($tag == $challenge['ranswer'] && $_SESSION['next_tag'] == $challenge['ranswer'] && $_SESSION['current_tag'] == $challenge['ctag'])
			{
				if ($DEBUG) { echo("<script>console.log('It appeast we have for the answer to the village riddle')</script>"); }
				$_SESSION['next_tag'] = $_SESSION['guide_tag'];
				$_SESSION['current_tag'] = $tag;
				
				
				$message = "Element fragment signature recorded.  Please return to guide for cataloging.\n\n Signature: " . $tag;	
				$url = url_writer($message);
				echo('<html><head><title>Hak4Kidz Building Block Multiverse</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
				exit();
			}
			//return to guide and updated sesssion stats
			if ($tag == $_SESSION['guide_tag'] && $_SESSION['next_tag'] == $_SESSION['guide_tag'] && $challenge['ranswer'] == $_SESSION['current_tag'])
			{	
				
				if ($DEBUG) { echo("<script> console.log('we have returned to the guide with the fragment')</script>"); }
				$_SESSION['step']++;
				if ($_SESSION['step'] == $ccount)
				{
					$challenge = challenge($ccount);
				}
				else
				{
					$challenge = challenge($_SESSION['order'][$_SESSION['step']]);
				}
				if ($DEBUG) { array_walk($challenge, 'console_walker'); }
				$_SESSION['tf']++;
				$_SESSION['pc'] = $_SESSION['pc'] + 20;
				$_SESSION['pr'] = $_SESSION['pr'] - 20;
				$_SESSION['tr']--;
				$_SESSION['next_tag'] = $challenge['ctag'];
				$_SESSION['current_tag'] = $tag;
				$_SESSION['clues'] = $challenge['ctext'];
				
				
				$message = $challenge['ctext'];
				$url = url_writer($message);
				echo('<html><head><title>Hak4Kidz Building Block Multiverse</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
				exit();
				
			}
		}
		else
		{
			$message = "It does not appear that this scan matched anything I know how to handle";
			if ($DEBUG) { array_walk($_SESSION, 'console_walker');}
		}
		if (empty($message)){
			$message = "This is not the tag you are looking for.  Please try another tag.";
			if ($DEBUG) { array_walk($_SESSION, 'console_walker'); }
		}
	}
}

if ($DEBUG) { echo("<script>console.log('end of file.  WE fell throuugh the if statemetn.')</script>"); }

$url = url_writer($message);
echo('<html><head><title>Hak4Kidz Building Block Multiverse</title></head><body><iframe src="'. $url . '" width=100% height=100%/></body></html>');
