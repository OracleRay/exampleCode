<?php
function fun($n){
    if($n == 3)return 1;
    $res = 2*(fun($n+1)+1);
    return $res;
}
echo fun(1);
?>