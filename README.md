# fdola-watermark-imagick

php watermark imagick image and text, Watermark with text Suport textare multiline, image less than 200, 400 image watermark auto resize small

### Installation
```bash
composer require thanhansoft/fdola-watermark-imagick
```

### How to use?

```bash
use Fdola\WatermarkImagick;

$model = new WatermarkImagick();
//$model->image(__DIR__.'/test.jpg', __DIR__.'/result.jpg', __DIR__.'/logo.png', 'center', 10, false, 1);
$model->text(__DIR__.'/test.jpg', __DIR__.'/result.jpg', 'Thanhansoft.com', 'bottom-right');
```