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
        let url = '$file';
        http.open('GET', url, true);
        http.onreadystatechange = function() {
            if (http.readyState == 4) {
                $('#content').html(http.responseText);
            }
        }
        http.send(null);
    }</script>";
}

function cat($title, $type = "title")
{
    // This function is used, to make all titles readable for the URL and links
    $title = str_replace("&", "et", str_replace(' ', '-', strtolower($title)));
    if ($type == "title") {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    } elseif ($type == "username") {
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $title);
    }
}

function formatDate($date, $full = false)
{
    $date = clean($date);

    $s = $date;
    $date = strtotime($s);
    if ($full == false) {
        return date('d. M Y', $date);
    } else {
        return date('d. M Y H:m:i', $date);
    }
}

function timeAgo($datetime, $full = false)
{
    // Thx - https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'min',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
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

function getUser($uid)
{
    // This function is used to get the name of the user
    require("config.php");
    require("conn.php");
    if ($uid == 0) {
        return "System";
    } else {
        $u = $conn->query("SELECT * FROM `user` WHERE `id`='$uid' LIMIT 1")->fetch_assoc();
        if (empty($u["id"])) {
            return "Unknown";
        } else {
            return array(
                "id" => $u["id"],
                "name" => $u["username"]
            );
        }
    }
}

function getGroup($gid)
{
    // This function is used to get the name of the user
    require("config.php");
    require("conn.php");
    if (!empty($gid)) {
        $g = $conn->query("SELECT * FROM `groups` WHERE `id`='$gid' LIMIT 1")->fetch_assoc();
        if (empty($g["id"])) {
            return array(
                "id" => 0,
                "name" => "Unknown"
            );
        } else {
            return array(
                "id" => $g["id"],
                "name" => $g["name"]
            );
        }
    } else {
        return array(
            "id" => "",
            "name" => ""
        );
    }
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

function chTtile($type, $volume, $chapter, $name, $short, $title)
{
    $out = "";
    if (substr($chapter, -2) == ".0") {
        $chapter = substr($chapter, 0, -2);
    }
    if ($type == "home") {
        if (!empty($volume)) $out .= "Vol." . $volume . " ";
        $out .= "Ch." . $chapter;
    }
    if ($type == "list") {
        if (!empty($name)) {
            $out = $name;
        } else {
            if (!empty($volume)) $out .= "Volume " . $volume . " ";
            $out .= "Chapter " . $chapter;
            if (!empty($title)) $out .= ": " . $title;
            if ($short == "a") {
                //x
            }
        }
    }
    return $out;
}

function getBrowser()
{
    $uAgent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";
    if (preg_match('/linux/i', $uAgent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $uAgent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $uAgent)) {
        $platform = 'windows';
    }
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
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $uAgent, $matches)) {
        // we have no matching number just continue
    }
    $i = count($matches['browser']);
    if ($i != 1) {
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

function logs($uid, $action, $before, $after)
{
    require("config.php");
    require("conn.php");
    if (config("logs") == 1) {
        $browser = getBrowser();
        $ip = getIpAddress();
        $browserDetails = $browser["userAgent"];
        $browser = $browser["name"] . " " . $browser["version"] . ", " . ucfirst($browser["platform"]);
        $conn->query("INSERT INTO `logs`(`user_id`,`action`,`before`,`after`,`ip`,`browser`,`browser_info`) VALUES('$uid','$action','$before','$after','$ip','$browser','$browserDetails')");
    }
}

function asteristk($string, $amount = 5)
{
    $asterisks = str_repeat("*", $amount);
    return preg_replace('/.{' . $amount . '}$/', $asterisks, $string);
}

function getLastChData($tid)
{
    require("config.php");
    require("conn.php");
    $chapter = $conn->query("SELECT * FROM `chapters` WHERE `title_id`='$tid' ORDER BY `order` DESC LIMIT 1")->fetch_assoc();
    if (empty($chapter["id"])) {
        $chapter["id"] = "";
        $chapter["volume"] = "";
        $chapter["chapter"] = "";
        $chapter["release_name"] = "";
        $chapter["release_short"] = "";
        $chapter["title"] = "";
        $chapter["timestamp"] = "";
        $user["id"] = 0;
        $user["username"] = "";
    } else {
        $user = $conn->query("SELECT `id`, `username` FROM `user` WHERE `id`='" . $chapter["user_id"] . "' LIMIT 1")->fetch_assoc();
    }
    return array(
        "chapter" => array(
            "id" => $chapter["id"],
            "volume" => $chapter["volume"],
            "chapter" => $chapter["chapter"],
            "name" => $chapter["release_name"],
            "short" => $chapter["release_short"],
            "title" => $chapter["title"],
            "time" => $chapter["timestamp"]
        ),
        "user" => array(
            "id" => $user["id"],
            "name" => $user["username"]
        )
    );
}

function gen_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0C2f) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0x2Aff),
        mt_rand(0, 0xffD3),
        mt_rand(0, 0xff4B)
    );
}

function setCkie($name, $value, $expires = "never")
{
    if ($expires == "never") {
        $time = time() + (10 * 365 * 24 * 60 * 60);
    } else {
        $time = $expires;
    }
    setcookie($name, $value, $time, "/");
}

function convArrayToString($array)
{
    $out = "";
    $c = 1;
    foreach ($array as $a) {
        if (is_numeric($a)) {
            if ($c != 1) $out .= ",";
            $out .= $a;
            $c++;
        }
    }
    return $out;
}

function convStringToArray($array)
{
    $out = [];
    $array = explode(",", $array);
    foreach ($array as $e) {
        if (is_numeric($e)) {
            array_push($out, $e);
        }
    }
    return $out;
}
