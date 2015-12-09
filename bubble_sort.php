<?php
$starttime = microtime(true);

$array = array(3,4,1,3,5,1,92,2,4124,424,52,12);

for ($c=0;$c<900000;$c++) {

for ($i=0;$i<count($array);$i++) {
    for ($y=0;$y<count($array)-1;$y++) {
        if ($array[$y+1] < $array[$y]) {
            $t = $array[$y];
            $array[$y] = $array[$y+1];
            $array[$y+1] = $t;
        }
    }
}

}
print_r($array);
echo microtime(true) - $starttime.' sec';

?>
