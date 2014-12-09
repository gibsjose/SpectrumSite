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
    $data_steering = $_POST['data_steering'];
    $grid_steering = $_POST['grid_steering'];
    $pdf_steering = $_POST['pdf_steering'];

    //DEBUG: Print output
    print("<h2>$steering</h2>");
    // print("<h2>Data Steering File: $data_steering</h2>");
    // print("<h2>Grid Steering File: $grid_steering</h2>");
    // print("<h2>PDF Steering File: $pdf_steering</h2>");
?>

<!-- Write variables to file (settings.txt) -->
<?php
    //print("<h2>$steering</h2>");

    //If 'steering' is not 'None', then create a steering file with the other steerings
?>

<!-- Call SteeringGenerator.py on the file to create a steering file -->

<!-- Run Spectrum on the steering file -->
<?php
    // $output=`2>logs/error.log ./Spectrum/Spectrum -p Steering/$steering > logs/spectrum.log`;

    exec("2>logs/error.log ./Spectrum/Spectrum -p $steering > logs/spectrum.log", $output, $return_status);
    //print("<h2>$return_status</h2>");
?>

<?php
    //$plotted = file_exists("plots/atlas_mtt_5fb_plot_0.png");
    $plots = glob('plots/*.png');
    if(count($plots) != 0) {
        $plot = $plots[0];
        $plotted = TRUE;
    } else {
        $plotted = FALSE;
    }
?>

<?php if(($plotted == TRUE) && ($return_status == 0)) {?>
    <h2><a href="./logs/error.log" target="_newtab">Spectrum Error Log</a></h2>
    <h2><a href="./logs/spectrum.log" target="_newtab">Spectrum Log</a></h2>
<?php print("<img src=\"$plot\" alt=\"ERROR\" width=\"600px\">"); ?>

<?php } else {?>
    <br>
    <br>
    <h2><a href="./logs/error.log" target="_newtab">Spectrum Error Log</a></h2>
    <h2><a href="./logs/spectrum.log" target="_newtab">Spectrum Log</a></h2>
    <br>
    <br>
    <h1><font color="#Ef3E3E" size="40px">ERROR</font></h1>
<?php } ?>

<br>
<br>
<br>
<br>
<br>
<br>
