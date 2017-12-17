<?php

require __DIR__ . "/InnerDateBoundary.php";

$st = new InnerDateBoundary (
	"2017-12-17 to 2017-12-20",
	"2017-12-18 to 2017-12-22",
	"2017-12-17 to 2017-12-21"
);
$st->setDelimeter(" to ");
$st->execute();
$result = $st->getResult();
print_r($result);