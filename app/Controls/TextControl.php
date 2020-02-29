<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 14:30
 */

namespace App\Controls;


use Nette\Application\UI\Control;

class TextControl extends Control
{
    public $actualText = "";
    public $lastMarkdown = "none";

    public function handleConvertToHTML($text, $markdown)
    {
        if (!$this->isAjax()){
            return;
        }
        if ($markdown == "none"){
            $className = $this->lastMarkdown . "Processor";
            $preprocessor = new $className();
            $this->actualText = $preprocessor->HTMLToText($text);
        } else {
            $className = $markdown . "Processor";
            $preprocessor = new $className();
            $this->actualText = $preprocessor->textToHTML($text);
            $this->lastMarkdown = $markdown;
        }
    }
}