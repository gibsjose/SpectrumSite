<!-- Get HTTP Request from JS on plot.php -->
<?php
    //Get the script name and flags
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    //Strip C-Style quotation escaping
    $script = stripslashes($script);
    $flags = stripslashes($flags);

    //Create the full string
    $full = $script . " " . $flags;

    $output = `ls -ltr /afs/cern.ch/sw/lcg/contrib/gcc/4.3.2/x86_64-slc5-gcc43-opt/lib64`;
    print("<h2>$output</h2>");
    print("<br>");

    $output = `ls -ltr /afs/cern.ch/sw/lcg/contrib/mpfr/2.3.1/x86_64-slc5-gcc43-opt/lib`;
    print("<h2>$output</h2>");
    print("<br>");

    $output = `ls -ltr /afs/cern.ch/sw/lcg/contrib/gmp/4.3.2/x86_64-slc5-gcc43-opt/lib`;
    print("<h2>$output</h2>");
    print("<br>");
    $output = `ls -ltr /usr/lib64/`;
    print("<h2>$output</h2>");
    print("<br>");
    //Run the script and print the output
    $output = `2>&1 $full`;
    print("<h2>$output</h2>");
?>
