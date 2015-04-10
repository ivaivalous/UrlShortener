<?php
    /* By Bozhurin Quick Link Script (by.bozhur.in)
     * 2012 © Ivaylo Bozhurin (dev at bozhur dot in)
    */
 
class Linker {
 
    // Конструктор за клас Linker
    function Linker() {
        // Подразбираща се часова зона
        date_default_timezone_set('Europe/Helsinki');
 
        // Данни за връзка с базата данни – хост, потребителско име, парола
        $this->connexion = mysql_connect("localhost", "LinkDB", "PASSWORD") or die(mysql_error());
        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET SQL_SAFE_UPDATES=1");
 
        // Избираме базата данни
        mysql_select_db("LinkDB", $this->connexion) or die(mysql_error());
    }
 
    // Връща информация за конкретна кратка връзка
    function Get($link) {
        $q = "SELECT * FROM by_links WHERE link='" .mysql_real_escape_string($link). "' LIMIT 1";
        $res = mysql_query($q, $this->connexion);
        return mysql_fetch_array($res, MYSQL_ASSOC);
    }
 
    // Проверява дали предоставеното кратко име е заето (съществува ли в БД)
    function There($link) {
        $q = "SELECT id FROM by_links WHERE link='".mysql_real_escape_string($link)."'";
        $res = mysql_query($q, $this->connexion);
        return mysql_num_rows($res);
    }
 
    // Връща данните за определен брой кратки връзки
    function GetLinks($limit) {
        $q = "SELECT * FROM by_links WHERE 1 ORDER BY created DESC LIMIT $limit";
        $res = mysql_query($q, $this->connexion);
        for($i=0; $a[$i] = mysql_fetch_array($res, MYSQL_ASSOC); $i++); // Любимият ми for-цикъл!!!
        return $a;
    }      
 
    /* Вмъква информация за нова кратка връзка.
     * За вход приема съкращаван адрес ($url) и
     * кратка връзка ($link)
     */
    function Insert($url, $link, $ip) {
        $q = "INSERT INTO by_links(url, link, ip) VALUES ('".
             mysql_real_escape_string($url) ."', '".
             mysql_real_escape_string($link) ."', '".
             mysql_real_escape_string($ip) ."')";
 
        $res = mysql_query($q, $this->connexion);
        return mysql_affected_rows($res);
    }
 
    // Изтрива данни за връзка от БД
    function Delete($link) {
        $q = "DELETE FROM by_links WHERE link='" .mysql_real_escape_string($link). "'";
        $res = mysql_query($q, $this->connexion);
        return mysql_affected_rows($res);
    }      
 
    // Въвежда данни в таблица „Посещения“
    function AddStats($lid, $vip, $ref, $agent) {
        $q = "INSERT INTO by_visits(lid, vip, referer, agent) VALUES (".
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
