<!DOCTYPE html>
<html lang="<?= $userlang ?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- TailwindCSS-->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" type="text/css">
    <?php if (config("tailwind_type") == "cdn") { ?>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,line-clamp"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
    <link rel="icon" type="image/x-icon" href="<?= config("url") ?>data/assets/img/favicon.ico">
    <?php if (config("captcha_enabled") == 1) { ?>
        <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    <?php } ?>

    <script type="text/javascript">
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
        let http = getHTTPObject();

        function title(title) {
            document.title = title + " - <?= config("title") ?>";
        }
    </script>

    <style>
        .just {
            hyphens: auto !important;
            text-align: justify !important;
            -webkit-hyphens: auto !important;
            word-wrap: break-word !important;
        }
    </style>