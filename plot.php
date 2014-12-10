
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
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- Select2 -->
        <link href="select2/select2.css" rel="stylesheet"/>
        <script src="select2/select2.js"></script>

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

                //Get all the variables from the form
                // var steering_v = document.getElementById('steering').value;
                // var data_steering_v = document.getElementById('data_steering').value;
                // var grid_steering_v = document.getElementById('grid_steering').value;
                // var pdf_steering_v = document.getElementById('pdf_steering').value;

                var steering_v = $('#steering').select2("val");
                var plot_type_v = $('#plot_type').select2("val");
                var data_steering_v = $('#data_steering').select2("val");
                var grid_steering_v = $('#grid_steering').select2("val");
                var pdf_steering_v = $('#pdf_steering').select2("val");

                console.log(steering_v);
                console.log(plot_type_v);

                switch(plot_type_v) {
                    case 0:
                        plot_type_v = "data, grid, pdf";
                        break;
                    case 1:
                        plot_type_v = "data[], grid[], pdf";
                        break;
                    case 2:
                        plot_type_v = "data, grid[], pdf";
                        break;
                    case 3:
                        plot_type_v = "data, grid, pdf[]";
                        break;
                }

                console.log(plot_type_v);
                console.log(data_steering_v);
                console.log(grid_steering_v);
                console.log(pdf_steering_v);

                //Get Steering File data from form and send it to PHP for plotting
                data = {
                    steering: steering_v,
                    plot_type: plot_type_v,
                    data_steering: data_steering_v,
                    grid_steering: grid_steering_v,
                    pdf_steering: pdf_steering_v
                };

                //Run the PHP script which creates the steering file, runs spectrum, and updates the page
                $('#canvas-container').load('load_plot.php', data);
            }
        </script>

        <!-- When the user changes the plot type, update the multiplicity of the other select boxes -->
        <script type="text/javascript">

            function ClearDataSteeringFiles() {
                $("#data_steering").select2("data", null);
            }

            function ClearGridSteeringFiles() {
                $("#grid_steering").select2("data", null);
            }

            function ClearPDFSteeringFiles() {
                $("#pdf_steering").select2("data", null);
            }

            function ClearAllSteeringFiles() {
                ClearDataSteeringFiles();
                ClearGridSteeringFiles();
                ClearPDFSteeringFiles();
            }

            function PlotType() {
                var pt = $('#plot_type').select2("val");

                if(pt == 0) {
                    console.log("1 Data, 1 Grid, 1 PDF");
                    $('#data_steering').select2({maximumSelectionSize: 1});
                    $('#grid_steering').select2({maximumSelectionSize: 1});
                    $('#pdf_steering').select2({maximumSelectionSize: 1});

                    ClearAllSteeringFiles();
                }
                else if(pt == 1) {
                    console.log("N Data, N Grids, 1 PDF");
                    $('#data_steering').select2({maximumSelectionSize: 0});

                    //Set this to 1 because it will be properly set when N data files are selected
                    $('#grid_steering').select2({maximumSelectionSize: 1});
                    $('#pdf_steering').select2({maximumSelectionSize: 1});

                    ClearAllSteeringFiles();
                }
                else if(pt == 2) {
                    console.log("1 Data, N Grids, 1 PDF");
                    $('#data_steering').select2({maximumSelectionSize: 1});
                    $('#grid_steering').select2({maximumSelectionSize: 0});
                    $('#pdf_steering').select2({maximumSelectionSize: 1});

                    ClearAllSteeringFiles();
                }
                else if(pt == 3) {
                    console.log("1 Data, 1 Grid, N PDFs");
                    $('#data_steering').select2({maximumSelectionSize: 1});
                    $('#grid_steering').select2({maximumSelectionSize: 1});
                    $('#pdf_steering').select2({maximumSelectionSize: 0});

                    ClearAllSteeringFiles();
                }
            }

            function DataSteering() {
                var ds = $('#data_steering').select2("val");
                console.log(ds);

                var pt = $('#plot_type').select2("val");

                //Limit the number of grid steering files to match the number of data if plot type is N, N, 1
                if(pt == 1) {
                    console.log("Setting max for grids to " + ds.length);
                    $('#grid_steering').select2({maximumSelectionSize: ds.length});
                }
            }

            function GridSteering() {
                var gs = $('#grid_steering').select2("val");
                console.log(gs);
            }

            function PDFSteering() {
                var ps = $('#pdf_steering').select2("val");
                console.log(ps);
            }
        </script>

        <!-- Initialize the Forms -->
        <script type="text/javascript">
        function InitializeForms() {

            //Initialize the forms using the select2 interface: Default to Plot Type 0 (1, 1, 1)
            $('#steering').select2();
            $('#plot_type').select2();
            $('#data_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});
            $('#grid_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});
            $('#pdf_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});

            //Populate the forms with the data in the steering files
            $('#steering').load('get_steering_files.php');
            $('#data_steering').load('get_data_steering_files.php');
            $('#grid_steering').load('get_grid_steering_files.php');
            $('#pdf_steering').load('get_pdf_steering_files.php');

            //Bind OnChange events
            $('#plot_type').on("change", PlotType);
            $('#data_steering').on("change", DataSteering);
            $('#data_steering').on("select2-remove", DataSteering);
            $('#grid_steering').on("change", GridSteering);
            $('#pdf_steering').on("change", PDFSteering);
        }

        //Run this when the window is loaded
        window.onload = InitializeForms;
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
                <h2 class="content-head is-center">Spectrum Plot</h2>
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
                        <div id="form-container">
                            <form class="pure-form pure-form-stacked" action="JavaScript:Plot()" method="post">
                                <fieldset>
                                    <label for="steering">Pre-Defined Plots</label>
                                    <select class="pure-u-1" name="steering" id="steering">
                                        <option>None</option>
                                    </select>
                                    <hr color="#39B54A" width="100%" size="2" align="left">
                                    <br>
                                    <label for="plot_type">Plot Type</label>
                                    <select class="pure-u-1" name="plot_type" id="plot_type">
                                        <option value="0">1 Data, 1 Grid, 1 PDF</option>
                                        <option value="1">N Data, N Grids, 1 PDF</option>
                                        <option value="2">1 Data, N Grids, 1 PDF</option>
                                        <option value="3">1 Data, 1 Grid, N PDFs</option>
                                    </select>

                                    <label for="data_steering">Data Steering File</label>
                                    <select class="pure-u-1 chosen-select-deselect" name="data_steering" id="data_steering" multiple>
                                        <option>None</option>
                                    </select>

                                    <label for="grid_steering">Grid Steering File</label>
                                    <select class="pure-u-1 chosen-select-deselect" name="grid_steering" id="grid_steering" multiple>
                                        <option>None</option>
                                    </select>

                                    <label for="pdf_steering">PDF Steering File</label>
                                    <select class="pure-u-1 chosen-select-deselect" name="pdf_steering" id="pdf_steering" multiple>
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
    </body>
</html>
