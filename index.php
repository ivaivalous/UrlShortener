<?php
    if($_GET["go"] != "") {
        if($_GET["go"] == "manage") {
            include_once 'manage.php';
            exit;
        }
        include_once 'link.php';
        $l = $linker->Get($_GET["go"]);
 
        if($l["id"] != "") {
            $linker->AddStats($l["id"], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_USER_AGENT']);
            header("Location: ".$l["url"]."");
        }
        else {
            header("Location: http://tsarstva.bg/sh/372/url-shortener/#несъществуващ");
        }
    }
    else header("Location: http://tsarstva.bg/sh/372/url-shortener/");
?>
