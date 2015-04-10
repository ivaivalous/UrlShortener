<?php
	/* Quick Link Script (tsarstva.bg)
	 * By Ivo Marinkov
	*/
	
class Linker {
	function Linker() {
		include "config.php";
		date_default_timezone_set($timezone);
	
		$this->connexion = mysql_connect($db_host, $db_name, $db_password) or die(mysql_error());
		mysql_query("SET CHARACTER SET utf8");
		mysql_query("SET NAMES utf8");
		mysql_query("SET SQL_SAFE_UPDATES=1");
		mysql_select_db($db_name, $this->connexion) or die(mysql_error()); 
	}
	
	// Get info for specified quick link
	function Get($link) {
		$q = "SELECT * FROM a_links WHERE link='" .mysql_real_escape_string($link). "' LIMIT 1";
		$res = mysql_query($q, $this->connexion);
		return mysql_fetch_array($res, MYSQL_ASSOC);
	}
	
	// Check whether specific quick name is existant in DB
	function There($link) {
		$q = "SELECT id FROM a_links WHERE link='".mysql_real_escape_string($link)."'";
		$res = mysql_query($q, $this->connexion);
		return mysql_num_rows($res);
	}
	
	// Get a list of links
	function GetLinks($limit) {
		$q = "SELECT * FROM a_links WHERE 1 ORDER BY created DESC LIMIT $limit";
		$res = mysql_query($q, $this->connexion);
		for($i=0; $a[$i] = mysql_fetch_array($res, MYSQL_ASSOC); $i++); 
		return $a;
	}		
	
	// Insert new 
	function Insert($url, $link, $ip) {
		$q = "INSERT INTO a_links(url, link, ip) VALUES ('".
			 mysql_real_escape_string($url) ."', '".
			 mysql_real_escape_string($link) ."', '".
			 mysql_real_escape_string($ip) ."')";
			 
		$res = mysql_query($q, $this->connexion);
		return mysql_affected_rows($res);
	}
	
	// Delete a link
	function Delete($link) {
		$q = "DELETE FROM a_links WHERE link='" .mysql_real_escape_string($link). "'";
		$res = mysql_query($q, $this->connexion);
		return mysql_affected_rows($res);
	}		
	
	// Insert data into stats
	function AddStats($lid, $vip, $ref, $agent) {
		$q = "INSERT INTO a_visits(lid, vip, referer, agent) VALUES (".
			 mysql_real_escape_string($lid) . ", '" .
			 mysql_real_escape_string($vip) . "', '" .
			 mysql_real_escape_string($ref) . "', '" .
			 mysql_real_escape_string($agent) . "')";
		$res = mysql_query($q, $this->connexion);
		return mysql_affected_rows($res);
	}		
}
$linker = new Linker;

?>
