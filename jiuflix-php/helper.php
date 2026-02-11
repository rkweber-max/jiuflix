<?php

function debug($param, $bool = true) {
    print_r('<pre>');
    var_dump($param);
    print_r('</pre>');

    if ($bool) {
        die();
    }
} 