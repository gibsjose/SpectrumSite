
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

        <script type="text/javascript">
        function ClearNotifications() {
            document.getElementById('notification-container').innerHTML = "";
        }
        </script>

        <script type="text/javascript">
        function DisplayPleaseWait() {
            document.getElementById('notification-container').innerHTML = "<br><br><br><br><h2 class='still-plotting'>Creating the Figure, Please Wait...</h2>";
        }
        </script>

        <!-- Collide Function -->
        <script type="text/javascript">
            function Plot() {

                //Replace the container content with the particle canvas to run the animation each time
                $('#canvas-container').html(function() {
                    canvas = "<canvas id='particle-canvas' width='600px' height='600px'></canvas>";
                    script = "<script type='text/javascript' src='js/protons.js'><\/script>";
                    return canvas + script;
                }); 

                DisplayPleaseWait();

                //Generate a collision
                Collision();

                //Get all the variables from the form
		//var steering_v = document.getElementById('steering').value;
                // turn off predefined plots on this page
                var steering_v = "None";
		//
                var plot_type_v = $('#plot_type').select2("val");
                var data_steering_v = $('#data_steering').select2("val");
                var data_marker_color_v = $('#data_marker_color').select2("val");
                var data_marker_style_v = $('#data_marker_style').select2("val");
                var grid_steering_v = $('#grid_steering').select2("val");
                var pdf_steering_v = $('#pdf_steering').select2("val");
                var pdf_fill_color_v = $('#pdf_fill_color').select2("val");

                var display_style_v = "";
                var overlay_v = document.getElementById('overlay').checked;
                var ratio_v = document.getElementById('ratio').checked;

                var y_overlay_min_v = document.getElementById('y_overlay_min').value;
                var y_overlay_max_v = document.getElementById('y_overlay_max').value;
                var y_ratio_min_v = document.getElementById('y_ratio_min').value;
                var y_ratio_max_v = document.getElementById('y_ratio_max').value;

                if(overlay_v && ratio_v) {
                    display_style_v = "overlay, ratio";
                } else if(overlay_v) {
                    display_style_v = "overlay";
                } else if(ratio_v) {
                    display_style_v = "ratio";
                } else {
                    display_style_v = "";
                }

                var ratio_styles = "";
                var ratios = "";

                //data,grid,pdf
                if(plot_type_v == 0) {
                    plot_type_v = "data,grid,pdf";

                    ratio_styles += "data_tot:data_stat:";
                    ratios += "data_0:data:0:";

                    for(var i = 0; i < data_steering_v.length; i++) {
                        if(i == (data_steering_v.length - 1)) {
                            ratio_styles += "convolute / data";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + i + ")";
                            break;
                        } else {
                            ratio_styles += "convolute / data:";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + i + "):";
                        }
                    }
                }
                //data[],grid[],pdf
                else if(plot_type_v == 1) {
                    plot_type_v = "data[],grid[],pdf";

                    for(var i = 0; i < data_steering_v.length; i++) {
                        if(i == (data_steering_v.length - 1)) {
                            ratio_styles += "convolute / data";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + i + ")";
                            break;
                        } else {
                            ratio_styles += "convolute / data:";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + i + "):";
                        }
                    }
                }
                //data,grid[],pdf
                else if(plot_type_v == 2) {
                    plot_type_v = "data,grid[],pdf";

                    ratio_styles += "data_tot:data_stat:";
                    ratios += "data_0:data:0:";

                    for(var i = 0; i < grid_steering_v.length; i++) {
                        if(i == (grid_steering_v.length - 1)) {
                            ratio_styles += "convolute / data";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + 0 + ")";
                            break;
                        } else {
                            ratio_styles += "convolute / data:";
                            ratios += "([grid_" + i + ", pdf_" + 0 + "]) / (data_" + 0 + "):";
                        }
                    }
                }
                //data,grid,pdf[]
                else if(plot_type_v == 3) {
                    plot_type_v = "data,grid,pdf[]";

                    ratio_styles += "data_tot:data_stat:";
                    ratios += "data_0:data:0:";

                    for(var i = 0; i < pdf_steering_v.length; i++) {
                        if(i == (pdf_steering_v.length - 1)) {
                            ratio_styles += "convolute / data";
                            ratios += "([grid_" + 0 + ", pdf_" + i + "]) / (data_" + 0 + ")";
                            break;
                        } else {
                            ratio_styles += "convolute / data:";
                            ratios += "([grid_" + 0 + ", pdf_" + i + "]) / (data_" + 0 + "):";
                        }
                    }
                }

                var data_steerings_v = "";
                var data_marker_colors_v = "";
                var data_marker_styles_v = "";

                if(data_marker_color_v.length && (data_marker_color_v.length != data_steering_v.length)) {
                    alert("Too few data marker colors specified");
                    return;
                }
                if(data_marker_style_v.length && (data_marker_style_v.length != data_steering_v.length)) {
                    alert("Too few data marker styles specified");
                    return;
                }

                for(var i = 0; i < data_steering_v.length; i++) {
                    if(i == (data_steering_v.length - 1)) {
                        data_steerings_v += data_steering_v[i];

                        if(data_marker_color_v.length) {
                            data_marker_colors_v += data_marker_color_v[i];
                        }

                        if(data_marker_style_v.length) {
                            data_marker_styles_v += data_marker_style_v[i];
                        }

                        break;
                    } else {
                        data_steerings_v += data_steering_v[i] + ", ";

                        if(data_marker_color_v.length) {
                            data_marker_colors_v += data_marker_color_v[i] + ", ";
                        }

                        if(data_marker_style_v.length) {
                            data_marker_styles_v += data_marker_style_v[i] + ", ";
                        }
                    }
                }

                var grid_steerings_v = "";
                for(var i = 0; i < grid_steering_v.length; i++) {
                    if(i == (grid_steering_v.length - 1)) {
                        grid_steerings_v += grid_steering_v[i];
                        break;
                    } else {
                        grid_steerings_v += grid_steering_v[i] + ", ";
                    }
                }

                var pdf_steerings_v = "";
                var pdf_fill_colors_v = "";

                if(pdf_fill_color_v.length && (pdf_fill_color_v.length != pdf_steering_v.length)) {
                    alert("Too few PDF fill colors specified");
                    return;
                }

                for(var i = 0; i < pdf_steering_v.length; i++) {
                    if(i == (pdf_steering_v.length - 1)) {
                        pdf_steerings_v += pdf_steering_v[i];

                        if(pdf_fill_color_v.length) {
                            pdf_fill_colors_v += pdf_fill_color_v[i];
                        }

                        break;
                    } else {
                        pdf_steerings_v += pdf_steering_v[i] + ", ";

                        if(pdf_fill_color_v.length) {
                            pdf_fill_colors_v += pdf_fill_color_v[i] + ", ";
                        }
                    }
                }

                var grid_corr_v = document.getElementById('grid_corr').checked;

                var x_log_v = document.getElementById('x_log').checked;
                var y_log_v = document.getElementById('y_log').checked;

                var plot_band_v = document.getElementById('plot_band').checked;

                var plot_pdf_band_v = document.getElementById('plot_pdf_band').checked;
                var plot_alpha_s_band_v = document.getElementById('plot_alpha_s_band').checked;
                var plot_scale_band_v = document.getElementById('plot_scale_band').checked;

                console.log("steering_v: " + steering_v);
                console.log("plot_type_v: " + plot_type_v);
                console.log("data_steerings_v: " + data_steerings_v);
                console.log("data_marker_colors_v: " + data_marker_colors_v);
                console.log("data_marker_styles_v: " + data_marker_styles_v);
                console.log("grid_steerings_v: " + grid_steerings_v);
                console.log("pdf_steerings_v: " + pdf_steerings_v);
                console.log("pdf_fill_colors_v: " + pdf_fill_colors_v);
                console.log("display_style_v: " + display_style_v);
                console.log("ratio_styles: " + ratio_styles);
                console.log("ratios: " + ratios);
                console.log("plot_pdf_band_v" + plot_pdf_band_v);
                console.log("plot_alpha_s_band_v" + plot_alpha_s_band_v);
                console.log("plot_scale_band_v" + plot_scale_band_v);

                //Get Steering File data from form and send it to PHP for plotting
                data = {
		    steering: steering_v,
                    plot_type: plot_type_v,
                    data_steering: data_steerings_v,
                    data_marker_color: data_marker_colors_v,
                    data_marker_style: data_marker_styles_v,
                    grid_steering: grid_steerings_v,
                    pdf_steering: pdf_steerings_v,
                    pdf_fill_color: pdf_fill_colors_v,
                    display_style: display_style_v,
                    ratio_style: ratio_styles,
                    ratio: ratios,
                    grid_corr: grid_corr_v,
                    x_log: x_log_v,
                    y_log: y_log_v,

                    plot_band: plot_band_v,
                    y_overlay_min: y_overlay_min_v,
                    y_overlay_max: y_overlay_max_v,
                    y_ratio_min: y_ratio_min_v,
                    y_ratio_max: y_ratio_max_v,

                    plot_pdf_band: plot_pdf_band_v,
                    plot_alpha_s_band: plot_alpha_s_band_v,
                    plot_scale_band: plot_scale_band_v,
                };

                //Run the PHP script which creates the steering file, runs spectrum, and updates the page
                $('#canvas-container').load('load_plot.php', data);
            }
        </script>

        <!-- When the user changes the plot type, update the multiplicity of the other select boxes -->
        <script type="text/javascript">
            function ClearDataSteeringFiles() {
                $("#data_steering").select2("data", null);
                $('#data_marker_color').select2("data", null);
                $('#data_marker_style').select2("data", null);
            }

            function ClearDataMarkerColors() {
                $('#data_marker_color').select2("data", null);
            }

            function ClearDataMarkerStyles() {
                $('#data_marker_style').select2("data", null);
            }

            function ClearGridSteeringFiles() {
                $("#grid_steering").select2("data", null);
            }

            function ClearPDFSteeringFiles() {
                $("#pdf_steering").select2("data", null);
                $("#pdf_fill_color").select2("data", null);
            }

            function ClearAllSteeringFiles() {
                ClearDataSteeringFiles();
                ClearGridSteeringFiles();
                ClearPDFSteeringFiles();
            }

            function EnableDataSteeringSelect() {
                $('#data_steering').select2("enable", true);
                $('#data_marker_color').select2("enable", true);
                $('#data_marker_style').select2("enable", true);
            }

            function DisableDataSteeringSelect() {
                $('#data_steering').select2("enable", false);
                $('#data_marker_color').select2("enable", false);
                $('#data_marker_style').select2("enable", false);
            }

            function EnableDataMarkerStyleSelect() {
                $('#data_marker_color').select2("enable", true);
            }

            function DisableDataMarkerStyleSelect() {
                $('#data_marker_color').select2("enable", false);
            }

            function EnableDataMarkerStyleSelect() {
                $('#data_marker_style').select2("enable", true);
            }

            function DisableDataMarkerStyleSelect() {
                $('#data_marker_style').select2("enable", false);
            }

            function EnableGridSteeringSelect() {
                $('#grid_steering').select2("enable", true);
            }

            function DisableGridSteeringSelect() {
                $('#grid_steering').select2("enable", false);
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

            function Observable() {
                var obs = $('#observable').select2("val");

                console.log(obs);

                if(obs == "None") {
                    ClearDataSteeringFiles();
                    ClearGridSteeringFiles();
                    DisableDataSteeringSelect();
                    DisableGridSteeringSelect();

                    return;
                }

                var script_v = 'Utilities/Configuration.py';
                var flags_v = '-o "' + obs + '"';

                data = {
                    script: script_v,
                    flags: flags_v
                };

                $('#data_steering').load('run_script.php', data);

                ClearDataSteeringFiles();
                ClearGridSteeringFiles();

                EnableDataSteeringSelect();
                DisableGridSteeringSelect();
            }

            function DataSteering() {
                var ds = $('#data_steering').select2("val");
                var data = $('#data_steering').select2('data');
                var count = ds.length;
                var text;

                if(count > 0) {
                    text = data[count - 1].text;
                } else {
                    text = " ";
                }

                //Limit the number of data marker colors/styles to the
                $("#data_marker_color").select2({
                    maximumSelectionSize: ds.length,
                    formatResult: colorFormat,
                    formatSelection: colorFormat,
                    escapeMarkup: function(m) { return m; }
                });

                $("#data_marker_style").select2({
                    maximumSelectionSize: ds.length,
                    formatResult: markerStyleFormat,
                    formatSelection: markerStyleFormat,
                    escapeMarkup: function(m) { return m; }
                });

                var pt = $('#plot_type').select2("val");

                //Limit the number of grid steering files to match the number of data if plot type is N, N, 1
                if(pt == 1) {
                    $('#grid_steering').select2({maximumSelectionSize: ds.length});
                }

                //Load the grid with the options corresponding to the data file
                var script_v = 'Utilities/Configuration.py';
                var flags_v = '-d "' + text + '"';

                data = {
                    script: script_v,
                    flags: flags_v
                };

                //If there is only one option, clear out the list and just put the single option
                if(count <= 1) {
                    $('#grid_steering').load('run_script.php', data);
                }

                //If multiple data files selected, append the corresponding grids to the selection box
                else {
                    $.post('run_script.php', data).done(function(_data) {
                        $(_data).appendTo('#grid_steering');
                    });
                }

                //Clear and enable the grid selection
                ClearGridSteeringFiles();
                EnableGridSteeringSelect();
            }

            function GridSteering() {
                var gs = $('#grid_steering').select2("val");
                //console.log(gs);
            }

            function PDFSteering() {
                var ps = $('#pdf_steering').select2("val");

                $("#pdf_fill_color").select2({
                    maximumSelectionSize: ps.length,
                    formatResult: colorFormat,
                    formatSelection: colorFormat,
                    escapeMarkup: function(m) { return m; }
                });
            }

            //Verifies the input for the min/max's to be valid
            function YOverlayMin() {
                var minVal = document.getElementById('y_overlay_min').value;
                var maxVal = document.getElementById('y_overlay_max').value;

                //Clear if not a number
                if(!$.isNumeric(minVal)) {
                    document.getElementById('y_overlay_min').value = "";
                }

                //Clear if greater than max
                if(maxVal) {
                    if(parseFloat(minVal) > parseFloat(maxVal)) {
                        document.getElementById('y_overlay_min').value = "";
                    }
                }

                //Set to a low number if zero is entered
                if(parseFloat(minVal) == 0) {
                    document.getElementById('y_overlay_min').value = "0.001";
                }
            }

            function YOverlayMax() {
                var minVal = document.getElementById('y_overlay_min').value;
                var maxVal = document.getElementById('y_overlay_max').value;

                //Clear if not a number
                if(!$.isNumeric(maxVal)) {
                    document.getElementById('y_overlay_max').value = "";
                }

                //Clear if less than min
                if(minVal) {
                    if(parseFloat(maxVal) < parseFloat(minVal)) {
                        document.getElementById('y_overlay_max').value = "";
                    }
                }
            }

            function YRatioMin() {
                var minVal = document.getElementById('y_ratio_min').value;
                var maxVal = document.getElementById('y_ratio_max').value;

                //Clear if not a number
                if(!$.isNumeric(minVal)) {
                    document.getElementById('y_ratio_min').value = "";
                }

                //Clear if greater than max
                if(maxVal) {
                    if(parseFloat(minVal) > parseFloat(maxVal)) {
                        document.getElementById('y_ratio_min').value = "";
                    }
                }
            }

            function YRatioMax() {
                var minVal = document.getElementById('y_ratio_min').value;
                var maxVal = document.getElementById('y_ratio_max').value;

                //Clear if not a number
                if(!$.isNumeric(maxVal)) {
                    document.getElementById('y_ratio_max').value = "";
                }

                //Clear if less than min
                if(minVal) {
                    if(parseFloat(maxVal) < parseFloat(minVal)) {
                        document.getElementById('y_ratio_max').value = "";
                    }
                }
            }
        </script>

        <script type="text/javascript">
            function colorFormat(color) {
                if (!color.id) return color.text;
                return "<img class='select-color' src='img/root/colors/" + color.id.toLowerCase() + ".png'/>" + "  " + color.text;
            }

            function markerStyleFormat(style) {
                if (!style.id) return style.text;
                return "<img class='select-marker-style' src='img/root/marker-styles/" + style.id.toLowerCase() + ".png'/>" + "  " + style.text;
            }

            function fillStyleFormat(style) {
                if (!style.id) return style.text;
                return "<img class='select-fill-style' src='img/root/fill-styles/" + style.id.toLowerCase() + ".png'/>" + "  " + style.text;
            }
        </script>

        <!-- Initialize the Forms -->
        <script type="text/javascript">
        function InitializeForms() {

            //Initialize the forms using the select2 interface: Default to Plot Type 0 (1, 1, 1)
            //$('#steering').select2();
            $('#plot_type').select2();
            $('#observable').select2();
            $('#observable').select2('val', 'None');
            $('#data_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});
            $('#grid_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});
            $('#pdf_steering').select2({closeOnSelect: false, maximumSelectionSize: 1});

            $("#data_marker_color").select2({
                maximumSelectionSize: 1,
                formatResult: colorFormat,
                formatSelection: colorFormat,
                escapeMarkup: function(m) { return m; }
            });

            $("#data_marker_style").select2({
                maximumSelectionSize: 1,
                formatResult: markerStyleFormat,
                formatSelection: markerStyleFormat,
                escapeMarkup: function(m) { return m; }
            });

            $("#pdf_fill_color").select2({
                maximumSelectionSize: 1,
                formatResult: colorFormat,
                formatSelection: colorFormat,
                escapeMarkup: function(m) { return m; }
            });

            //Populate the forms with the data in the steering files
            $('#steering').load('get_steering_files.php');
            $('#data_steering').load('get_data_steering_files.php');
            $('#grid_steering').load('get_grid_steering_files.php');
            $('#pdf_steering').load('get_pdf_steering_files.php');

            //Bind OnChange events
            $('#plot_type').on("change", PlotType);
            $('#observable').on("change", Observable);
            $('#data_steering').on("change", DataSteering);
            $('#data_steering').on("select2-remove", DataSteering);
            $('#grid_steering').on("change", GridSteering);
            $('#pdf_steering').on("change", PDFSteering);

            $('#y_overlay_min').on('change', YOverlayMin);
            $('#y_overlay_max').on('change', YOverlayMax);
            $('#y_ratio_min').on('change', YRatioMin);
            $('#y_ratio_max').on('change', YRatioMax);

            //Default to Data/Grid disabled
            DisableDataSteeringSelect();
            DisableGridSteeringSelect();
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
                    <!-- <li><a href="grids.html">GRIDS</a></li>
                    <li><a href="pdf-sets.html">PDF SETS</a></li> -->
                </ul>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content">
                <h2 class="content-head is-center">Spectrum Plot Panel</h2>
                <div id="test-container">
                    <!-- Used for test jQuery output from PHP scripts -->
                </div>
                <div class="pure-g">
                    <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-2-5">
                        <div id="form-container">
                            <form class="pure-form pure-form-stacked" action="JavaScript:Plot()" method="post">
                                <fieldset>
<!---
                                    <br>
                                    <label for="steering">Pre-Defined Plots</label>
                                    <select class="pure-u-1" name="steering" id="steering">
                                        <option>None</option>
                                    </select>
                                    <br>
-->
                                    <hr color="#39B54A" width="100%" size="2" align="left">
                                    <br>
                                    <label for="plot_type">Plot Type</label>
                                    <select class="pure-u-1" name="plot_type" id="plot_type">
                                        <option value="0">1 Data, 1 Grid, 1 PDF</option>
                                        <option value="1">N Data, N Grids, 1 PDF</option>
                                        <option value="2">1 Data, N Grids, 1 PDF</option>
                                        <option value="3">1 Data, 1 Grid, N PDFs</option>
                                    </select>

                                    <label for="observable">Physics process</label>
                                    <select class="pure-u-1" name="observable" id="observable">
                                        <option>None</option>
                                        <option>Inclusive Z</option>
                                        <option>Inclusive Jets</option>
                                        <option>Top</option>
                                    </select>

                                    <label for="data_steering">Cross section</label>
                                    <select placeholder="Data File" class="pure-u-1" name="data_steering" id="data_steering" multiple>
                                        <option>None</option>
                                    </select>
                                    <select placeholder="Color" class="pure-u-1" name="data_marker_color" id="data_marker_color" multiple>
                                        <option value="1" id="1">Black</option>
                                        <option value="2" id="2">Red</option>
                                        <option value="3" id="3">Green</option>
                                        <option value="4" id="4">Blue</option>
                                    </select>
                                    <select placeholder="Style" class="pure-u-1" name="data_marker_style" id="data_marker_style" multiple>
                                        <option value="20" id="20">Circle</option>
                                        <option value="21" id="21">Square</option>
                                        <option value="22" id="22">Triangle</option>
                                        <option value="23" id="23">Inverted Triangle</option>
                                    </select>

                                    <label for="grid_steering">ApplGrid File</label>
                                    <select placeholder="Grid File" class="pure-u-1" name="grid_steering" id="grid_steering" multiple>
                                        <option>None</option>
                                    </select>

                                    <label for="pdf_steering">PDF</label>
                                    <select placeholder="PDF File" class="pure-u-1" name="pdf_steering" id="pdf_steering" multiple>
                                        <option>None</option>
                                    </select>
                                    <select placeholder="Color" class="pure-u-1" name="pdf_fill_color" id="pdf_fill_color" multiple>
                                        <option value="1" id="1">Black</option>
                                        <option value="2" id="2">Red</option>
                                        <option value="3" id="3">Green</option>
                                        <option value="4" id="4">Blue</option>
                                    </select>

                                    <br>                                    
                                    <br>
                                    <button type="submit" id="submit" class="button-submit pure-button"><i class="fa fa-rocket"></i> Go!</button>
                                    <br>

                                    <label for="overlay">
                                        <input id="overlay" type="checkbox" checked> Overlay
                                    </label>

                                    <label for="ratio">
                                        <input id="ratio" type="checkbox" checked> Ratio
                                    </label>

                                    <label for="grid_corr">
                                        <input id="grid_corr" type="checkbox"> Apply Corrections to NLO QCD (Electroweak, etc.)
                                    </label>

                                    <label>Include in Uncertainty Band:</label>
                                    <input id="plot_pdf_band" type="checkbox" checked> PDF Band &emsp;<input id="plot_alpha_s_band" type="checkbox"> Alpha S Band &emsp;<input id="plot_scale_band" type="checkbox"> Scale Band

                                    <br>
                                    <h3 color="#1F8DD6">Style Options</h3>
                                    <!-- <hr color="#39B54A" width="100%" size="2" align="left"> -->

                                    <label for="plot_band">
                                        <input id="plot_band" type="checkbox"> Use Bands Instead of Points
                                    </label>

                                    <label for="x_log">
                                        <input id="x_log" type="checkbox" checked> Logarithmic X Axis
                                    </label>

                                    <label for="y_log">
                                        <input id="y_log" type="checkbox" checked> Logarithmic Y Axis
                                    </label>

                                    <label>Overlay</label>
                                    <div class="min-max">
                                        <input class="min-max-input" width="60px" placeholder="Min" id="y_overlay_min">
                                    </div>
                                    <div class="min-max">
                                        <input class="min-max-input" width="60px" placeholder="Max" id="y_overlay_max">
                                    </div>
                                    <br>
                                    <br>
                                    <label>Ratio</label>
                                    <div class="min-max">
                                        <input class="min-max-input" width="60px" placeholder="Min" id="y_ratio_min">
                                    </div>
                                    <div class="min-max">
                                        <input class="min-max-input" width="60px" placeholder="Max" id="y_ratio_max">
                                    </div>
                                    <br>
                                    <br>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="is-center pure-u-1 pure-u-md-1-2 pure-u-lg-3-5">
                        <div id="notification-container" align="center">
                        </div>
                        <div id="canvas-container" align="center">
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
