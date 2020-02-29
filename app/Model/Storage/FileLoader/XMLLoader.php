<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 10:35
 */

namespace App\Model\Storage\FileLoader;


use App\Model\Entity\Note;
use App\Model\Preprocessor\MarkdownPreprocessor;
use App\Model\Preprocessor\TexPreprocessor;

/**
 * This class is a loader for XML files. There can be also loaders for other file formats like JSON, or CSV. The loaders would contain the same methods.
 * The loader for CSV files would also contain the same parameters, but there would be used json_encode and json_decode functions inside my functions.
 * Class XMLLoader
 * @package App\Model\Storage\FileLoader
 */
class XMLLoader implements ILoader
{
    const FORMAT = "Y-m-d H:i:s";

    private $id;
    private $title;
    private $text;
    private $date;
    private $preprocessor;
    private $root;
    private $element;
    public function __construct($id, $title, $text, $date, $preprocessor, $root, $element)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->date = $date;
        $this->preprocessor = $preprocessor;
        $this->root = $root;
        $this->element = $element;
    }

    public function appendNoteToFile(Note $note, string $filename){
        $xmldata = simplexml_load_file($filename) or die("Failed to load");
        $lastId = 0;
        $contentWithNewNote = "<?xml version=\"1.0\"?>".PHP_EOL."<".$this->root.">";
        foreach($xmldata->children() as $noteElement){
            $lastId = intval($noteElement->id);
            $contentWithNewNote .= "<".$this->element.">".PHP_EOL;
            $contentWithNewNote .= "<".$this->id.">".$lastId."</".$this->id.">".PHP_EOL;
            $contentWithNewNote .= "<".$this->title.">".$noteElement->title."</".$this->title.">".PHP_EOL;
            $contentWithNewNote .= "<".$this->text.">".$noteElement->text."</".$this->text.">".PHP_EOL;
            $contentWithNewNote .= "<".$this->date.">".$noteElement->dateTime."</".$this->date.">".PHP_EOL;
            $contentWithNewNote .= "<".$this->preprocessor.">".$noteElement->preprocessor."</".$this->preprocessor.">".PHP_EOL;
            $contentWithNewNote .= "</".$this->element.">".PHP_EOL;
        }
        $contentWithNewNote .= "<".$this->element.">".PHP_EOL;
        $contentWithNewNote .= "<".$this->id.">".($lastId + 1)."</".$this->id.">".PHP_EOL;
        $contentWithNewNote .= "<".$this->title.">".$note->getTitle()."</".$this->title.">".PHP_EOL;
        $contentWithNewNote .= "<".$this->text.">".$note->getText()."</".$this->text.">".PHP_EOL;
        $contentWithNewNote .= "<".$this->date.">".$note->getDate()->format(self::FORMAT)."</".$this->date.">".PHP_EOL;
        $contentWithNewNote .= "<".$this->preprocessor.">".$note->getPreprocessor()."</".$this->preprocessor.">".PHP_EOL;
        $contentWithNewNote .= "</".$this->element.">".PHP_EOL;
        $contentWithNewNote .= "</".$this->root.">";
        file_put_contents($filename, $contentWithNewNote);
    }

    public function changeNoteInFile(Note $note, string $filename){
        $xmldata = simplexml_load_file($filename) or die("Failed to load");
        $contentWithNewNote = "<?xml version=\"1.0\"?>".PHP_EOL."<".$this->root.">";
        foreach($xmldata->children() as $noteElement) {
            $lastId = intval($noteElement->id);
            if (intval($noteElement->id) == $note->getId()){
                $contentWithNewNote .= "<".$this->element.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->id.">".$note->getId()."</".$this->id.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->title.">".$note->getTitle()."</".$this->title.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->text.">".$note->getText()."</".$this->text.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->date.">".$note->getDate()->format(self::FORMAT)."</".$this->date.">".PHP_EOL;
                $contentWithNewNote .= "</".$this->element.">".PHP_EOL;
            } else {
                $contentWithNewNote .= "<".$this->element.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->id.">" . $lastId . "</".$this->id.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->title.">" . $noteElement->title . "</".$this->title.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->text.">" . $noteElement->text . "</".$this->text.">".PHP_EOL;
                $contentWithNewNote .= "<".$this->date.">" . $noteElement->dateTime . "</".$this->date.">".PHP_EOL;
                $contentWithNewNote .= "</".$this->element.">".PHP_EOL;
            }
        }
        $contentWithNewNote .= "</".$this->root.">";
        file_put_contents($filename, $contentWithNewNote);
    }

    public function getNotesFromFile(string $filename): array{
        $notes = array();
        $xmldata = simplexml_load_file($filename) or die("Failed to load");
        foreach($xmldata->children() as $noteElement) {
            $id = $this->id;
            $date = $this->date;
            $title = $this->title;
            $text = $this->text;
            $preprocessor = $this->preprocessor;
            $date = \DateTime::createFromFormat(self::FORMAT, $noteElement->$date);
            $note = new Note($noteElement->$text, $noteElement->$title, $noteElement->$id, $date, $noteElement->$preprocessor);
            array_push($notes, $note);
        }
        return $notes;
    }
}