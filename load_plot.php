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
?>

<!-- Write variables to file (settings.txt) -->
<?php
    //print("<h2>$steering</h2>");
?>

<!-- Call SteeringGenerator.py on the file to create a steering file -->

<!-- Run Spectrum on the steering file -->
<?php
    // $output=`2>logs/error.log ./Spectrum/Spectrum -p Steering/$steering > logs/spectrum.log`;

    exec("2>logs/error.log ./Spectrum/Spectrum -p Steering/$steering > logs/spectrum.log", $output, $return_status);
    //print("<h2>$return_status</h2>");
?>

<?php
    $plotted = file_exists("plots/atlas_mtt_5fb_plot_0.png");
?>

<?php if(($plotted == TRUE) && ($return_status == 0)) {?>
    <h2><a href="./logs/error.log" target="_newtab">Spectrum Error Log</a></h2>
    <h2><a href="./logs/spectrum.log" target="_newtab">Spectrum Log</a></h2>
    <img src="plots/atlas_mtt_5fb_plot_0.png" alt="ERROR" width="800">
<?php } else {?>
    <br>
    <br>
    <h2><a href="./logs/error.log" target="_newtab">Spectrum Error Log</a></h2>
    <br>
    <br>
    <h1><font color="#Ef3E3E" size="40px">ERROR</font></h1>
<?php } ?>

<!-- Reset Collision -->
<script>
    ResetCollision();
</script>

<br>
<br>
<br>
<br>
<br>
<br>
