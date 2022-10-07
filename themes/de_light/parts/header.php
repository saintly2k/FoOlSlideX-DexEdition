<!DOCTYPE html>
<html lang="<?= $userlang ?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- TailwindCSS-->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" type="text/css">
    <?php if (config("tailwind_type") == "cdn") { ?>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="<?= config("url") ?>data/assets/img/favicon.ico">

    <script type="text/javascript">
        //Ajax Function
        function getHTTPObject() {
            var xmlhttp;
            if (window.ActiveXObject) {
                try {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (E) {
                        xmlhttp = false;
                    }
                }
            } else {
                xmlhttp = false;
            }
            if (window.XMLHttpRequest) {
                try {
                    xmlhttp = new XMLHttpRequest();
                } catch (e) {
                    xmlhttp = false;
                }
            }
            return xmlhttp;
        }
        //HTTP Objects..
        let http = getHTTPObject();
    </script>