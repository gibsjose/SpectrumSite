<!-- Get HTTP Request -->
<?php
    $steering = $_POST['steering'];
    $plot_title = $_POST['plot_title'];
    $plot_band = $_POST['plot_band'];
    $plot_marker = $_POST['plot_marker'];
    $plot_staggered = $_POST['plot_staggered'];
?>

<!-- Display Variables -->
<?php
    print("<h2>Steering File: $steering</h2>");
    print("<h2>Plot Title: $plot_title</h2>");
    print("<h2>Plot Band? $plot_band</h2>");
    print("<h2>Plot Marker? $plot_marker</h2>");
    print("<h2>Plot Staggered? $plot_staggered</h2>");
?>

<!-- Write Key/Value pairs to file s-->
<?php
    $filename = "kvp/settings.txt";

    //Remove the file
    unlink("$filename");

    print("<h2>Writing $filename</h2>");

    //Write a new kvp file
    $kvp_file = fopen("$filename", "w");
    $kvp_text = "steering: $steering\n".
                "plot_title: $plot_title\n".
                "plot_band: $plot_band\n".
                "plot_marker: $plot_marker\n".
                "plot_staggered: $plot_staggered\n";

    fwrite($kvp_file, $kvp_text);
    fclose($kvp_file);

    print("<h2>Wrote $filename</h2>");
?>

<!-- Call Steering Generator Program on the kvp file -->
<?php
    $input = "kvp/settings.txt";
    $output = "Steering/settings.txt";

    //Remove output
    unlink($output);

    //Make sure input exists
    if(file_exists($input)) {
        $ret = `2>&1 Utilities/SteeringGenerator.py $input $output`;
        echo "$ret";
    }
?>

<br>
<br>
<br>
<br>
<br>
<br>
