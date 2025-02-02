<?php
require_once('model/catalog.php');

$products = getProducts(null, null, 1, 15);
var_dump($products);
?>
