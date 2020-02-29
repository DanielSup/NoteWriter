<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 14:24
 */

namespace App\Model\Preprocessor;


class MarkdownPreprocessor implements IPreprocessor
{
    public function textToHTML($text): string{
        //dummy implementation - the preprocessor should contain method from a composer extension to convert text to HTML by Markdown preprocessor.
        return "<h2>".$text."</h2>";
    }

    public function HTMLToText($html): string{
        //dummy implementation - the preprocessor should contain method from a composer extension to convert HTML created by Markdown preprocessor back to text.
        $html2 = str_replace("<h2>", "", $html);
        return str_replace("</h2>", "", $html2);
    }
}