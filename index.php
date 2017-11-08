<?php

$thescript = basename(__FILE__);

require("common.inc");


header("Content-type: image/png");
readfile($fname);

