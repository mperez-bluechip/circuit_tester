<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Circuit Tester</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/canvas.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>

        <script>
			window.onload = function() {
				var rectangle = document.getElementById('model_space');
				if (rectangle && rectangle.getContext) {
					var ctx = rectangle.getContext("2d");
					if (ctx) {
						ctx.fillStyle = "#000000";
						ctx.fillRect(0,0, ctx.canvas.width, ctx.canvas.height);
					}
				}
			}
		</script>

    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->



      <canvas id="model_space" width="800" height="500">your browser does not support canvas </canvas>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>




    </body>
</html>
