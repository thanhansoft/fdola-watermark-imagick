<?php
include 'src/WatermarkImagick.php';

use Fdola\WatermarkImagick;

$model = new WatermarkImagick();
$model->image(__DIR__.'/test.jpg', __DIR__.'/result.jpg', __DIR__.'/logo.png', 'center', 10, false, 1);
//$model->text(__DIR__.'/test.jpg', __DIR__.'/result.jpg', 'Welcome to Thanhansoft.com', 'bottom-right');

?>

<img src="result.jpg"/>
