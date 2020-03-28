<?php

namespace Fdola;

class WatermarkImagick
{
    private $padding = 10;
    private $loop = false;
    private $opacity = 1;

    private function calc($from, $to, $watermark_image, $position = 'bottom-right')
    {
        $image = new \Imagick();
        $image->readImage($from);

        $watermark = new \Imagick();
        $watermark->readImage($watermark_image);
        $watermark->evaluateImage(\Imagick::EVALUATE_MULTIPLY, $this->opacity, \Imagick::CHANNEL_ALPHA);

        $img_Width = $image->getImageWidth();
        $img_Height = $image->getImageHeight();
        $watermark_Width = $watermark->getImageWidth();
        $watermark_Height = $watermark->getImageHeight();

        //$position == 'top-left'
        $x = 0 + $this->padding;
        $y = 0 + $this->padding;
        if ($position == 'center') {
            // Check if the dimensions of the image are less than the dimensions of the watermark
            // In case it is, then proceed to
            if ($img_Height < $watermark_Height || $img_Width < $watermark_Width) {
                // Resize the watermark to be of the same size of the image
                $watermark->scaleImage($img_Width, $img_Height);

                // Update size of the watermark
                $watermark_Width = $watermark->getImageWidth();
                $watermark_Height = $watermark->getImageHeight();
            }

            // Calculate the position
            $x = ($img_Width - $watermark_Width) / 2;
            $y = ($img_Height - $watermark_Height) / 2;
        } else {
            $watermarkResizeFactor = 1;
			if($img_Width <= 200) $watermarkResizeFactor = 3;
			else if($img_Width > 200 && $img_Width <= 400) $watermarkResizeFactor = 2;
			
            // Resize the watermark with the resize factor value
            $watermark->scaleImage($watermark_Width / $watermarkResizeFactor, $watermark_Height / $watermarkResizeFactor);

            $watermark_Width = $watermark->getImageWidth();
            $watermark_Height = $watermark->getImageHeight();

            if ($position == 'bottom-right') {
                // Draw on the bottom right corner of the original image
                $x = ($img_Width - $watermark_Width) - $this->padding;
                $y = ($img_Height - $watermark_Height) - $this->padding;
            } elseif ($position == 'top-right') {
                // Draw on the top right corner of the original image
                $x = ($img_Width - $watermark_Width) - $this->padding;
                $y = 0 + $this->padding;
            } elseif ($position == 'bottom-left') {
                // Draw on the bottom left corner of the original image
                $x = 0 + $this->padding;
                $y = ($img_Height - $watermark_Height) - $this->padding;
            }
        }

        if ($this->loop) {
            $step = 0;
            for ($w = 10; $w < $img_Width; $w += $watermark_Width / 2) {
                for ($h = 10; $h < $img_Height; $h += $watermark_Height * 3) {
                    $image->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $w + $step, $h);
                    $step += $watermark_Width / 2;
                }
            }
        } else $image->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $x, $y);// Draw the watermark on your image. $image->getImageFormat()
        $image->writeImage($to);
    }

    public function image($from, $to, $watermark_image, $position = 'bottom-right', $padding = 10, $loop = false, $opacity = 1)
    {
        $this->padding = $padding;
        $this->loop = $loop;
        $this->opacity = $opacity;
        $this->calc($from, $to, $watermark_image, $position);
    }

    public function text($from, $to, $string, $position = 'bottom-right', $padding = 10, $loop = false, $opacity = 1)
    {
        $this->padding = $padding;
        $this->loop = $loop;
        $this->opacity = $opacity;
        $this->calcText($from, $to, $string, $position);
    }

    private function calcText($from, $to, $text, $position)
    {
        $image = new \Imagick($from);
        $draw = new \ImagickDraw();

        $draw->setFont(__DIR__.'/Arial.ttf');
        $draw->setFontSize(15);
        $draw->setFillColor('black');

        $draw->setGravity($this->Position($position));

        $image->annotateImage($draw, 10, 12, 0, $text);

        $draw->setFillColor('white');
        $image->annotateImage($draw, 11, 11, 0, $text);

        $image->writeImage($to);
    }

    private function Position($position)
    {
        switch ($position) {
            case "bottom-left":
                return 7;
            case "top-left":
                return 1;
            case "top-right":
                return 2;
            case "center":
                return 5;
            default:
                return 9;
        }
    }
}
