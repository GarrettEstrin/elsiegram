<?php
$file = ABSPATH . "elsiegram-ui/index.html";
if(is_file($file)) {
    readfile($file);
} else {
	echo "app not found";
}