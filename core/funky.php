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

function cat($title, $type = "title")
{
    // This function is used, to make all titles readable for the URL and links
    if ($type == "title") {
        $title = str_replace("&", "et", str_replace(' ', '-', strtolower($title)));
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $title);
    } elseif ($type == "username") {
        $title = str_replace("&", "et", str_replace(' ', '-', $title));
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $title);
    }
}

function formatDate($date)
{
    $date = clean($date);

    $s = $date;
    $date = strtotime($s);
    return date('d. M Y', $date);
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

function convertWork($n)
{
    // This function is used to output the status of a title's original work status
    if ($n == 0) $out = "Unknown";
    if ($n == 1) $out = "Publishing";
    if ($n == 2) $out = "Hiatus";
    if ($n == 3) $out = "Completed";
    return $out;
}

function convertUpload($n)
{
    // This function is used to output the status of a title's upload status
    if ($n == 0) $out = "Unknown";
    if ($n == 1) $out = "Uploading";
    if ($n == 2) $out = "Paused";
    if ($n == 3) $out = "Completed";
    return $out;
}

function getUser($uid, $type = "plain")
{
    // This function is used to get the name of the user
    require("config.php");
    require("conn.php");
    if ($uid == 0) {
        if ($type == "plain") $out = "System";
        if ($type == "html") $out =  "<a href='#/' class='text-blue-500 hover:underline'>System</a>";
    } else {
        $u = $conn->query("SELECT * FROM `user` WHERE `id`='$uid' LIMIT 1")->fetch_assoc();
        if (empty($u["id"])) {
            $out = "Unknown";
        } else {
            if ($type == "plain") $out = $u["username"];
            if ($type == "html") $out = "<a href='" . config("url") . "user/" . $u["id"] . "/" . cat($u["username"]) . "' class='text-blue-500 hover:underline'>" . $u["username"] . "</a>";
        }
    }
    return $out;
}

function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function genUsername()
{
    return "user_" . sprintf(
        '%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
function getBrowser()
{
    $uAgent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $uAgent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $uAgent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $uAgent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $uAgent) && !preg_match('/Opera/i', $uAgent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $uAgent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $uAgent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Chrome/i', $uAgent) && !preg_match('/Edge/i', $uAgent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $uAgent) && !preg_match('/Edge/i', $uAgent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Netscape/i', $uAgent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Edge/i', $uAgent)) {
        $bname = 'Edge';
        $ub = "Edge";
    } elseif (preg_match('/Trident/i', $uAgent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $uAgent, $matches)) {
        // we have no matching number just continue
    }
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($uAgent, "Version") < strripos($uAgent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $uAgent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function asteristk($string, $amount = 5)
{
    $asterisks = str_repeat("*", $amount);
    return preg_replace('/.{' . $amount . '}$/', $asterisks, $string);
}
