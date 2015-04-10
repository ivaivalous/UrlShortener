<?php
    include_once 'link.php';
 
    // Добавяне на препратка
    if($_POST["act"] == "add"){
        /* Ако потребителят представи желана кратка връзка и тя не е заета
         * я вписваме в БД.
        */
        if(($_POST["link"] != "") && (!$linker->There($_POST["link"]))){
            $linker->Insert($_POST["url"], $_POST["link"]);
        }
 
        // Иначе скриптът генерира случайна и вписва нея в БД.
        else {
            for(; $linker->There($_POST["link"] = substr(md5(uniqid()), 0, 5)); );
            $linker->Insert($_POST["url"], $_POST["link"]);
        }
    }
 
    // Премахване на препратка
    if(isset($_GET["del"])) {
        $linker->Delete($_GET["del"]);
    }
 
    // Шпиониране за препратка
    if($_POST["act"] == "spy"){
        $data = $linker->Get($_POST["link"]);
 
        if($data["id"] == "") $error = "Въвели сте несъществуваща връзка.<br />Ако искате, можете да си създадете такава.";
    }
?>
