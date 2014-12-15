<!-- Get HTTP Request from JS on plot.php -->
<?php
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    $full = $script . " " . $flags;
    print("<h2>$full</h2>");

    //$output = shell_exec($script . $flags);
    $output = `2>&1 $full`;
    print("<h2>$output</h2>");
?>
