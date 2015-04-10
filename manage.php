<?php 
	include_once 'link.php'; 
	
	// Adding a link
	if($_POST["act"] == "add"){
		// If the user has supplied a link string that is not already in DB, add it in
		if(($_POST["link"] != "") && (!$linker->There($_POST["link"]))){
			$linker->Insert($_POST["url"], $_POST["link"], $_SERVER['REMOTE_ADDR']);
		}

		// Otherwise generate a link string and put that into the DB
		else {
			for(; $linker->There($_POST["link"] = substr(str_shuffle("abcdefjhijklmnopqrstuvwxyz0123456789"), 0, 3)); );
			$linker->Insert($_POST["url"], $_POST["link"], $_SERVER['REMOTE_ADDR']);
		}
	}
	
	// Removing a link
	if(isset($_GET["del"])) {
		$linker->Delete($_GET["del"]);
	}
	
	// Spying on a link
	if($_POST["act"] == "spy"){
		$data = $linker->Get($_POST["link"]);
		
		if($data["id"] == "") $error = "You have entered a link that does not exist.<br />If you wish, ypu can create it.";
	}
?> 
		

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		
		<meta name="Author" content="Ivo Marinkov www.ivo.qa" />
		<meta name="copyright" content="Copyright 2012-2013" /> 		
				
		<title>tsarstva.bg.url.shortener > Manage</title>
	</head>
	<body>
		<div style="float: left; margin: 10px;">
		<div style="width: 360px; border-radius: 6px; padding: 0px 6px 6px 6px; 
		            text-align: center; font-size: 16px; background: #92AECA; color: #292995;">
		            
			<form action="pwr" method="post">
				
				<h1>Create a new short link</h1>
				<input type="text" name="url" size="32" value="http://" 
				       style="background: #9EC1E2; border-radius: 2px; border: 1px solid #5C88B2;" />
				<br />
				
				<h2>Quick link</h2>
				http://<strong>example.com/</strong>
				<input type="text" name="link" size="5" 
				       style="background: #9EC1E2; border-radius: 2px; border: 1px solid #5C88B2;" />
				<br /><br />
				
				<input type="hidden" name="act" value="add" />
				<input type="submit" value="Add" />
				
			</form>
		</div>
		
		<div style="width: 360px; border-radius: 6px; padding: 0px 6px 6px 6px; 
		            
		            text-align: center; font-size: 16px; background: #92AECA; color: #292995;">
		            
			<form action="pwr" method="post">
				
				<h1>Spy on an existant link</h1>
				
				http://<strong>example.com/</strong>
				<input type="text" name="link" size="5" style="background: #9EC1E2; 
				             border-radius: 2px; border: 1px solid #5C88B2;" />
				             
				<input type="hidden" name="act" value="spy" />
				<input type="submit" value="Spy" />
				
			</form>
		</div>
		</div>
		
		<div style="float: left; margin: 10px;">
		<div style="width: 360px; border-radius: 6px; padding: 0px 6px 6px 6px; 
		            text-align: center; font-size: 16px; background: #92AECA; color: #292995;">
		            
			<h1>Last links quick list</h1>
			
			<ul style="text-align: left">
		
		<? 
		  // A list of the last 30 short links
		   $list = $linker->GetLinks(30);
		   
			foreach($list as $l) {
				if($l["id"] != "")
					echo '<li><a href="'.$l["url"].'">'.str_replace("http://", "", $l["url"]).
					     '</a> (<a href="http://example.com/'.$l["link"].'">'
					     .$l["link"].'</a>)&nbsp;'.
						 '<a href="http://a.ivo.qa/pwr&amp;del='.$l["link"].
						 '"><img src="http://media.tsarstva.bg/icons/delete.png" '.
						 'style="vertical-align: middle" title="Delete" alt="Delete" border="0" /></a></li>';
			}
		?>
			
			</ul>
		</div>
		
		<? // Section to display if the user has requested to spy on a link
			if(isset($data)) { 
		?>
		
		<div style="width: 360px; border-radius: 6px; padding: 0px 6px 6px 6px; 
		           text-align: center; font-size: 16px; background: #92AECA; color: #292995;">
		           
			<h1>Address data</h1>
			
		<? if($error) echo $error;
			else echo '<a href="'.$data["url"].'">'.str_replace("http://", "", $data["url"]).
			          '</a> (<a href="http://example.com/'.$data["link"].'">'.$data["link"].'</a>)&nbsp;'.
					  '<a href="http://example.com/pwr&amp;del='.$data["link"].
					  '"><img src="http://media.tsarstva.bg/icons/delete.png" '.
					  'style="vertical-align: middle" title="Delete" alt="Delete" border="0" /></a>';
		?>
			
		
		<? } ?>
		
		</div>
	</body>
</html>
