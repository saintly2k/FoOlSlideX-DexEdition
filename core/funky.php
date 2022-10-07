<?php

function clean($data)
{
    // This function is used, to completely sanitize user-input and make any form of scripts harmless and displayable
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    $data = trim($data);
    $data = str_replace("'", "\'", $data);
    return $data;
}

function config($name)
{
    // This function is used to get the value of a specific config-element
    require("config.php");
    require("conn.php");

    foreach ($config as $c) {
        if ($c["name"] == $name) {
            return $c["value"];
        }
    }
}

function callFile($file)
{
    return "<script>function loadContent() {
        url = '$file';
        http.open('GET', url, true);
        http.onreadystatechange = function() {
            if (http.readyState == 4) {
                document.getElementById('content').innerHTML = http.responseText;
            }
        }
        http.send(null);
    }</script>";
}

function cat($title)
{
    $title = str_replace("&", "et", str_replace(' ', '-', strtolower($title)));
    return preg_replace('/[^A-Za-z0-9\-]/', '', $title);
}

function shorten($text, $maxlength = 25)
{
    // This function is used, to display only a certain amount of characters
    if (strlen($text) <= $maxlength) {
        //$text = $text;
    } else {
        $text = substr($text, 0, $maxlength) . "...";
    }
    return $text;
}