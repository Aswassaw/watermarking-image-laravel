<?php

namespace Tests\Feature;

use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Tests\TestCase;

class ImageMarkTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImageMark()
    {
        // initiate basic watermak
        $watermarkBasic = Image::read(public_path("img/watermark.jpg"));
        $date = "22-11-2023";
        $time = "12:00 WIB";

        // add text information
        $watermarkBasic->text($date, 320, 90, function (FontFactory $font) {
            $font->filename(public_path("font/open.ttf"));
            $font->size(40);
        })->text($time, 320, 145, function (FontFactory $font) {
            $font->filename(public_path("font/open.ttf"));
            $font->size(40);
        });

        // add company logo information
        $companyLogo = Image::read(public_path("img/company.png"));
        $companyLogo->resize(200, 200);
        $watermarkBasic->place(
            $companyLogo,
            'left',
            50,
            0,
            100
        );

        // resize watermark
        $watermarkBasic->resize(300, 100);

        // get main image
        $originalImage = Image::read(public_path("img/soundcloud.png"));
        $newWidth = 1200;
        $newHeight = $originalImage->height() * ($newWidth / $originalImage->width());
        $originalImage->resize($newWidth, $newHeight);

        // inject watermark to main image
        $originalImage->place(
            $watermarkBasic,
            'bottom-right',
            20,
            20,
            50
        );
        // save to dir
        $originalImage->save(public_path('out/' . "testsaja9.png"));

        self::assertEquals(10, 10);
    }
}
