<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sandbox: home - Animsition</title>
    <link href="/web/js/animsition-master/dist/css/animsition.min.css" rel="stylesheet">


    <script type="text/javascript" src="/web/js/jquery-1.7.1.min.js"></script>
    <script src="/web/js/animsition-master/dist/js/animsition.min.js" charset="utf-8"></script>

</head>
<body>
<div>

    <div class="item bg-indigo">
        <h1>Animsition: Sandbox</h1>
    </div>

    <h2>Defaults</h2>
    <ol>
        <li><a class="animsition-link" href="addMotorPop.php">Basic</a></li>
        <li><a class="animsition-link" href="emitPeriodPop.php">Options</a></li>
        <li><a class="animsition-link" href="data-options.html">Data options</a></li>
        <li><a class="animsition-link" href="methods-in.html">Methods in</a></li>
        <li><a class="animsition-link" href="methods-out.html">Methods out</a></li>
    </ol>

    <h2>Overlays</h2>
    <ol>
        <li><a class="animsition-link" href="overlay1.html">Overlay1</a></li>
        <li><a class="animsition-link" href="overlay2.html">Overlay2</a></li>
    </ol>

</div>


<script>
    $(document).ready(function() {
        $('div').animsition({
            inClass: 'fade-in-up-sm',
            outClass: 'fade-out-up-sm',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
            loading: true,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'animsition-loading',
            loadingInner: '', // e.g '<img src="loading.svg" />'
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: [ 'animation-duration', '-webkit-animation-duration'],
            // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
            overlay : false,
            overlayClass : 'animsition-overlay-slide',
            overlayParentElement : 'body',
            transition: function(url){ window.location.href = url; }
        });
    });
</script>

</body>
</html>