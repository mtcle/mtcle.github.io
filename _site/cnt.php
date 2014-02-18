 <?php

$n=file_get_contents('cnt.txt');

$n++;

file_put_contents('cnt.txt',$n);

echo "document.write($n);";

?>
