# fdola-watermark-imagick

php watermark imagick image and text

### Installation
```bash
composer require thanhansoft/fdola-watermark-imagick
```

### How to use?

```bash
use Fdola\WatermarkImagick;

$model = new WatermarkImagick();
//$model->image(__DIR__.'/test.jpg', __DIR__.'/result.jpg', __DIR__.'/logo.png', 'center', 10, false, 1);
$model->text(__DIR__.'/test.jpg', __DIR__.'/result.jpg', 'THanhansoft.com', 'bottom-right', 10, false, 1);
```