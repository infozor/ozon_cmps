<?php

$product_id = '1712066954';
$price_with_ozon_card = '1915.00';

$sqlstr = sprintf("
							UPDATE
							  public.ozon_product_info
							SET
							  price_with_ozon_card = '%s' --price_with_ozon_card
							WHERE
							  product_id = '%s'
                           ",  $price_with_ozon_card, $product_id);

echo $sqlstr;