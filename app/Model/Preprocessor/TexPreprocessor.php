<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 14:24
 */

namespace App\Model\Preprocessor;


class TexPreprocessor implements IPreprocessor
{
    public function textToHTML($text): string{
        //dummy implementation - the preprocessor should contain method from a composer extension to convert text to HTML by TEX preprocessor
        return "<h3>".$text."</h3>";
    }

    public function HTMLToText($html): string{
        // dummy implementation - the preprocessor should contain method from a composer extension to convert HTML created after TEX preprocessing to text
        $html2 = str_replace("<h3>", "", $html);
        return str_replace("</h3>", "", $html2);
    }
}