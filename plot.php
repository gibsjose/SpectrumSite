
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Spectrum Cross Section Analysis Software">

        <title>Spectrum</title>
        <link rel="shortcut icon" href="img/spectrum_64.ico">

        <!-- Lato Font -->
        <link href='//fonts.googleapis.com/css?family=Lato:100,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <!-- Pure -->
        <!-- <link rel="stylesheet" href="https://yui.yahooapis.com/pure/0.5.0/pure-min.css"> -->

        <!-- NOTE: Linking to jsDelivr Instead of Yahoo because Yahoo does not support SSL (HTTPS)-->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/pure/0.5.0/pure-min.css">

        <!--[if lte IE 8]>
            <link rel="stylesheet" href="//cdn.jsdelivr.net/pure/0.5.0/grids-responsive-old-ie-min.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="//cdn.jsdelivr.net/pure/0.5.0/grids-responsive-min.css">
        <!--<![endif]-->

        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Plot Stylesheet -->
        <link rel="stylesheet" href="css/plot.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

        <!-- jQuery -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

        <!-- Collide Function -->
        <script type="text/javascript">
            function Plot() {
                //Somehow reload the canvas when the user presses the button to always play the animation each time
                // $('#canvas-container').load('canvas.php');
                Collision();

                var steering_v = document.getElementById('steering').value;

                //Get Steering File from form and send it to PHP for plotting
                data = {steering: steering_v};
                $('#canvas-container').load('load_plot.php', data);
            }
        </script>
    </head>

    <body>
        <div class="header">
            <div class="home-menu pure-menu pure-menu-open pure-menu-horizontal pure-menu-fixed">
                <li>
                    <a href="index.html">
                        <img src="img/spectrum_64.png">
                    </a>
                </li>
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li class="pure-menu-selected"><a href="plot.php">PLOT</a></li>
                    <li><a href="downloads.html">DOWNLOADS</a></li>
                    <li><a href="grids.html">GRIDS</a></li>
                    <li><a href="pdf-sets.html">PDF SETS</a></li>
                </ul>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content">
                <h2 class="content-head is-center">Plot</h2>
                <div id="form-container">
                    <!-- <form class="pure-form pure-form-stacked" action="./cgi-bin/SteeringGenerator.py" method="post"> -->
                    <form class="pure-form pure-form-stacked" action="JavaScript:Plot()" method="post">
                        <fieldset>
                            <label for="steering">Steering File</label>
                            <center>
                            <select name="steering" id="steering">
                                <option>good_test.txt</option>
                                <option>atlas2012_mtt.txt</option>
                                <option>atlas2012_ptt.txt</option>
                            </select>
                            </center>
                            <button type="submit" id="submit" class="pure-button">Plot</button>
                        </fieldset>
                    </form>
                </div>

                <div id="canvas-container">
                    <canvas id="particle-canvas" width="800" height="800" style="border:0px solid #262626;"></canvas>
                    <script type="text/javascript" src="js/protons.js"></script>
                </div>
            </div>
            <div class="footer l-box is-center">
                Check out the <a href="http://www.github.com/gibsjose/Spectrum/">Spectrum Project</a> on GitHub –
                Designed by <a href="http://www.github.com/gibsjose">Joe Gibson</a> – CERN 2014.
            </div>
        </div>

        <!-- Adds a 'click' Event Listener to the Submit Button such that the particle animation is played only upon submission -->
        <script type="text/javascript">
            var submit = document.getElementById("submit");
            if(submit) {
                // submit.addEventListener('click', function() { Collision(); });
            }
        </script>

    </body>
</html>
