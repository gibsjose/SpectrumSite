
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Spectrum Cross Section Analysis Software">

        <title>Spectrum</title>
        <link rel="shortcut icon" href="img/spectrum_64.ico">

        <!-- Chosen -->
        <!-- <link rel="stylesheet" href="chosen/docsupport/style.css"> -->
        <!-- <link rel="stylesheet" href="chosen/docsupport/prism.css"> -->
        <link rel="stylesheet" href="chosen/chosen.css">
        <style type="text/css" media="all">
        /* fix rtl for demo */
        .chosen-rtl .chosen-drop { left: -9000px; }
        </style>

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
        <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- Chosen handling and configuration -->
        <script src="chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>

        <!-- Collide Function -->
        <script type="text/javascript">
            function Plot() {
                //Replace the container content with the particle canvas to run the animation each time
                $('#canvas-container').html(function() {
                    canvas = "<canvas id='particle-canvas' width='600px' height='600px'></canvas>";
                    script = "<script type='text/javascript' src='js/protons.js'><\/script>";
                    return canvas + script;
                });

                //Generate a collision
                Collision();

                $('#canvas-container').html(function() {
                    return "<h2>Spectrum still running...</h2>"
                });

                //Get all the variables from the form
                var steering_v = document.getElementById('steering').value;
                var data_steering_v = document.getElementById('data_steering').value;
                var grid_steering_v = document.getElementById('grid_steering').value;
                var pdf_steering_v = document.getElementById('pdf_steering').value;
                // var plot_title_v = document.getElementById('plot_title').value;
                // var plot_band_v = document.getElementById('plot_band').checked;
                // var plot_marker_v = document.getElementById('plot_marker').checked;
                // var plot_staggered_v = document.getElementById('plot_staggered').checked;

                //Get Steering File data from form and send it to PHP for plotting
                data = {
                    steering: steering_v,
                    data_steering: data_steering_v,
                    grid_steering: grid_steering_v,
                    pdf_steering: pdf_steering_v
                    // plot_title: plot_title_v,
                    // plot_band: plot_band_v,
                    // plot_marker: plot_marker_v,
                    // plot_staggered: plot_staggered_v
                };

                //Run the PHP script which creates the steering file, runs spectrum, and updates the page
                $('#canvas-container').load('load_plot.php', data);
            }
        </script>

        <!-- Scans the Steering, Data Steering, Grid Steering, and PDF Steering directories and updates the forms based on their contents -->
        <script type="text/javascript">
            function UpdateForms() {
                $('.chosen-select').chosen();
                $('.chosen-select-deselect').chosen({allow_single_deselect:true});
                
                $('#steering').load('get_steering_files.php');
                $('#data_steering').load('get_data_steering_files.php');
                $('#grid_steering').load('get_grid_steering_files.php');
                $('#pdf_steering').load('get_pdf_steering_files.php');
            }

            //Run this when the window is loaded
            window.onload = UpdateForms;
        </script>

        <!-- When the user changes the plot type, update the multiplicity of the other select boxes -->

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
                <h2 class="content-head is-center">Spectrum Plot</h2>
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
                        <div id="form-container">
                            <form class="pure-form pure-form-stacked" action="JavaScript:Plot()" method="post">
                                <fieldset>
                                    <label for="steering">Pre-Defined Plots</label>
                                    <select name="steering" id="steering" data-placeholder="Pre-Defined Plot" class="pure-u-2-5 chosen-select">
                                        <option>None</option>
                                    </select>
                                    <hr color="#39B54A" width="60%" size="2" align="left">
                                    <br>
                                    <label for="plot_type">Plot Type</label>
                                    <select class="pure-u-2-5 chosen-select" name="plot_type" id="plot_type" onchange="if (this.selectedIndex) PlotTypeChanged();">
                                        <option value="0">1 Data, 1 Grid, 1 PDF</option>
                                        <option value="1">N Data, N Grids, 1 PDF</option>
                                        <option value="2">1 Data, N Grids, 1 PDF</option>
                                        <option value="3">1 Data, 1 Grid, N PDFs</option>
                                    </select>

                                    <label for="data_steering">Data Steering File</label>
                                    <select class="pure-u-2-5 chosen-select-deselect" name="data_steering" id="data_steering" multiple>
                                        <option>None</option>
                                    </select>

                                    <label for="grid_steering">Grid Steering File</label>
                                    <select class="pure-u-2-5 chosen-select-deselect" name="grid_steering" id="grid_steering" multiple>
                                        <option>None</option>
                                    </select>

                                    <label for="pdf_steering">PDF Steering File</label>
                                    <select class="pure-u-2-5 chosen-select-deselect" name="pdf_steering" id="pdf_steering" multiple>
                                        <option>None</option>
                                    </select>
                                    <br>
                                    <br>
                                    <button type="submit" id="submit" class="pure-button">Submit</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="is-center pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">
                        <div id="canvas-container">
                            <canvas id="particle-canvas" width="600px" height="600px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer l-box is-center">
                Check out the <a href="http://www.github.com/gibsjose/Spectrum/">Spectrum Project</a> on GitHub –
                Designed by <a href="http://www.github.com/gibsjose">Joe Gibson</a> – CERN 2014.
            </div>
        </div>

        <!--
        <script type="text/javascript">
        document.observe('dom:loaded', function(evt) {
            var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text: "Oops, nothing found!"},
                '.chosen-select-width'     : {width: "95%"}
            }
            var results = [];
            for (var selector in config) {
                var elements = $$(selector);
                for (var i = 0; i < elements.length; i++) {
                    results.push(new Chosen(elements[i],config[selector]));
                }
            }

            //Load the selects with the steering files
            jQuery('#steering').load('get_steering_files.php');
            jQuery('#data_steering').load('get_data_steering_files.php');
            jQuery('#grid_steering').load('get_grid_steering_files.php');
            jQuery('#pdf_steering').load('get_pdf_steering_files.php');

            return results;
        });
        </script>
        -->
    </body>
</html>
