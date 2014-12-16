<!-- Setup Spectrum Environment -->
<?php
    include_once "setup.php";
    setupSpectrumEnv();
?>

<!-- Remove All Plots (*.png) -->
<?php
    $plots = glob('plots/*.png');
    foreach($plots as $plot) {
        if(is_file($plot)) {
            unlink($plot);
        }
    }
?>

<!-- Get HTTP Request from JS on plot.php -->
<?php
    $steering = $_POST['steering'];
    $plot_type = $_POST['plot_type'];
    $data_steering = $_POST['data_steering'];
    $data_marker_color = $_POST['data_marker_color'];
    $data_marker_style = $_POST['data_marker_style'];
    $grid_steering = $_POST['grid_steering'];
    $pdf_steering = $_POST['pdf_steering'];
    $pdf_fill_color = $_POST['pdf_fill_color'];
    $display_style = $_POST['display_style'];
    $ratio_style = $_POST['ratio_style'];
    $ratio = $_POST['ratio'];
    $grid_corr = $_POST['grid_corr'];

    //Style Options
    $x_log = $_POST['x_log'];
    $y_log = $_POST['y_log'];
    $plot_band = $_POST['plot_band'];
?>

<!-- Write variables to file (settings.txt) -->
<?php
    //If 'steering' is 'None', then create a steering file with the other data
    if(strcasecmp($steering, "None") == 0) {
        $input = "tmp/kvp.txt";
        $output = "tmp/steering.txt";

        //Remove the existing KVP File
        unlink($input);

        //Remove the existing Steering File
        unlink($output);

        //Write a new kvp file
        $kvp_file = fopen($input, "w");

        $data_steerings = explode(",", $data_steering);
        $data_directory = "";
        $data_file = "";

        $grid_steerings = explode(",", $grid_steering);
        $grid_directory = "";
        $grid_file = "";

        $pdf_steerings = explode(",", $pdf_steering);
        $pdf_directory = "";
        $pdf_file = "";

        $ratio_styles = explode(":", $ratio_style);
        $ratios = explode(":", $ratio);

        //Create the zip for the data files
        // $d_zip = new ZipArchive();
        // $data_zip_filename = "tmp/data.zip";
        // $d_zip->open($data_zip_filename, ZipArchive::CREATE);

        //Get the data, grid, and pdf directories from the selected files
        foreach($data_steerings as $file) {
            $data_directory = $data_directory . dirname($file) . ",";
            $data_file = $data_file . basename($file) . ",";

            // $actual_data_file = basename($data_file, '.txt') . "_data.txt";
            // $file_to_add = $data_directory . $actual_data_file;
            // $d_zip->addFile($file_to_add);
        }

        // $d_zip->close();

        //Create the zip for the grid files
        // $g_zip = new ZipArchive();
        // $grids_zip_filename = "tmp/grids.zip";
        // $g_zip->open($grids_zip_filename, ZipArchive::CREATE);

        foreach($grid_steerings as $file) {
            $grid_directory = $grid_directory . dirname($file) . ",";
            $grid_file = $grid_file . basename($file) . ",";

            // $actual_grid_file = basename($grid_file, '.txt') . ".root";
            // $file_to_add = $grid_directory . $actual_grid_file;
            // $g_zip->addFile($file_to_add);
        }

        // $g_zip->close();

        foreach($pdf_steerings as $file) {
            $pdf_directory = $pdf_directory . dirname($file) . ",";
            $pdf_file = $pdf_file . basename($file) . ",";
        }

        $kvp_text = "plot_type = $plot_type\n".
                    "data_directory = $data_directory\n".
                    "grid_directory = $grid_directory\n".
                    "pdf_directory = $pdf_directory\n".
                    "data_steering_files = $data_file\n".
                    "data_marker_color = $data_marker_color\n".
                    "data_marker_style = $data_marker_style\n".
                    "grid_steering_files = $grid_file\n".
                    "pdf_steering_files = $pdf_file\n".
                    "pdf_fill_color = $pdf_fill_color\n".
                    "display_style = $display_style\n".
                    "grid_corr = $grid_corr\n".
                    "x_log = $x_log\n".
                    "y_log = $y_log\n".
                    "plot_band = $plot_band\n";

        $i = 0;
        foreach($ratio_styles as $rs) {
            $kvp_text = $kvp_text . "ratio_style_" . $i . " = " . $rs . "\n";
            $i = $i + 1;
        }

        $i = 0;
        foreach($ratios as $r) {
            $kvp_text = $kvp_text . "ratio_" . $i . " = " . $r . "\n";
            $i = $i + 1;
        }

        fwrite($kvp_file, $kvp_text);
        fclose($kvp_file);

        //Make sure input exists
        if(file_exists($input)) {
            //Call SteeringGenerator.py on the file to create a steering file
            $ret = `2>&1 Utilities/SteeringGenerator.py $input $output`;

            //Steering file is now the newly generated file
            $steering = $output;

            //Generate a link to the generated file for viewing
            //print("<h2><a href=\"$steering\" target=\"_newtab\">Steering File</a></h2>");
        }
    } else {
        //Print the Steering File name if a pre-built file was specified
        //print("<h2>$steering</h2>");
    }
?>

<!-- Run Spectrum on the steering file -->
<?php
    exec("2>logs/error.log ./Spectrum/Spectrum -p $steering > logs/spectrum.log", $output, $return_status);
?>


<?php
    //Get the name of the plot
    $plots = glob('plots/*.png');
    if(count($plots) != 0) {
        //Append the timestamp to the file
        $plot_dir = dirname($plots[0]);
        $plot_name = basename($plots[0], '.png');
        $timestamped_filename = $plot_dir . "/" . $plot_name . "-" . date("Y-m-d\TH-i-s") . ".png";

        //Rename the plot to the timestamped version
        rename($plots[0], $timestamped_filename);
        $plot = $timestamped_filename;

        $plotted = TRUE;
    } else {
        $plotted = FALSE;
    }
?>

<?php if(($plotted == TRUE) && ($return_status == 0)) {?>
    <br>
    <br>
    <?php print("<img src=\"$plot\" alt=\"ERROR\" width=\"600px\">"); ?>
    <br>
    <br>
    <!-- @TODO Add 'download under anchor options to download the file instead of view it' -->
    <div class="download-buttons pure-g is-center">
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
            <a href=<?php print("\"$plot\"")?> target="_newtab"><button width="90%" class="button-plot pure-button"><i class="fa fa-chevron-circle-down"></i> Plot</button></a>
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
            <a href=<?php print("\"tmp/data.zip\"")?> target="_newtab"><button width="90%" class="button-data pure-button"><i class="fa fa-chevron-circle-down"></i> Data</button></a>
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
            <a href=<?php print("\"tmp/grids.zip\"")?> target="_newtab"><button width="90%" class="button-grid pure-button"><i class="fa fa-chevron-circle-down"></i> Grid</button></a>
        </div>
        <div class="pure-u-1 pure-u-md-1-2 pure-u-lg-1-4">
            <a href=<?php print("\"$steering\"")?> target="_newtab"><button width="90%" class="button-steering pure-button"><i class="fa fa-chevron-circle-down"></i> Steering</button></a>
        </div>
    </div>
    <br>
    <div class="error-log-buttons pure-g is-center">
        <div class="pure-u-1">
            <a href="./logs/error.log" target="_newtab"><button class="button-error pure-button"><i class="fa fa-exclamation-circle"></i> Spectrum Error Log</button></a>
        </div>
        <br>
        <br>
        <div class="pure-u-1">
            <a href="./logs/spectrum.log" target="_newtab"><button class="button-log pure-button"><i class="fa fa-info-circle"></i> Spectrum Log</button></a>
        </div>
    </div>
<?php } else {?>
    <h1><font color="#Ef3E3E" size="40px">ERROR</font></h1>
    <br>
    <br>
    <div class="error-log-buttons pure-g is-center">
        <div class="pure-u-1">
            <a href="./logs/error.log" target="_newtab"><button class="button-error pure-button"><i class="fa fa-exclamation-circle"></i> Spectrum Error Log</button></a>
        </div>
        <br>
        <br>
        <div class="pure-u-1">
            <a href="./logs/spectrum.log" target="_newtab"><button class="button-log pure-button"><i class="fa fa-info-circle"></i> Spectrum Log</button></a>
        </div>
    </div>
<?php } ?>

<br>
<br>
<br>
<br>
<br>
<br>
