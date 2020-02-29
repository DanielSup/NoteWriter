<?php

namespace App\Model\Entity;
use Nette\Utils\DateTime;
use App\Model\Preprocessor\MarkdownPreprocessor;
use App\Model\Preprocessor\TexPreprocessor;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 8:42
 */
class Note {
    private $id;
    private $title;
    private $text;
    private $date;
    private $preprocessor;
    public function __construct($text, $title = "", $id = 0, $date = null, $preprocessor = "none"){
        $this->id = $id;
        $this->text = $text;
        $this->title = $title;
        $this->date = $date == null ? new \DateTime() : $date;
        $this->preprocessor = $preprocessor;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPreprocessor(): string
    {
        return $this->preprocessor;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $preprocessor
     */
    public function setPreprocessor(string $preprocessor)
    {
        $this->preprocessor = $preprocessor;
    }

    public function getPreprocessedText(){
        if ($this->preprocessor == "none"){
            return $this->text;
        }
        $className = "App\\Model\\Preprocessor\\".$this->preprocessor."Preprocessor";
        $preprocessor = new $className();
        return $preprocessor->textToHTML($this->text);
    }
}