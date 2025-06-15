<?php
echo "<pre>";
// current directory path दिखाए
echo "Current directory: " . getcwd() . "\n\n";

// इस folder के सभी files और folders दिखाए
print_r(scandir(getcwd()));
echo "</pre>";
?>
