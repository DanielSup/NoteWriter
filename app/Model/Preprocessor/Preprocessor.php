<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 14:23
 */

namespace App\Model\Preprocessor;


interface IPreprocessor
{
    public function textToHTML($text): string;
    public function HTMLToText($html): string;
}