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
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js" type="text/javascript"></script>

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

        function scroolTo(element, duration) {
            if (!duration) {
                duration = 700;
            }
            if (!element.offsetParent) {
                element.scrollTo();
            }
            var startingTop = element.offsetParent.scrollTop;
            var elementTop = element.offsetTop;
            var dist = elementTop - startingTop;
            var start;

            window.requestAnimationFrame(function step(timestamp) {
                if (!start)
                    start = timestamp;
                var time = timestamp - start;
                var percent = Math.min(time / duration, 1);
                element.offsetParent.scrollTo(0, startingTop + dist * percent);

                // Proceed with animation as long as we wanted it to.
                if (time < duration) {
                    window.requestAnimationFrame(step);
                }
            })
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