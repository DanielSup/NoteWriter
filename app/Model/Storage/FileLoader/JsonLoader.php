<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 18:57
 */

namespace App\Model\Storage\FileLoader;


use App\Model\Entity\Note;

class JsonLoader implements ILoader
{

    const FORMAT = "Y-m-d H:i:s";

    private $id;
    private $title;
    private $text;
    private $date;
    private $preprocessor;
    public function __construct($id, $title, $text, $date, $preprocessor)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->date = $date;
        $this->preprocessor = $preprocessor;
    }


    public function appendNoteToFile(Note $note, string $filename){
        //dummy empty implementatiion - there the note would be appended to the array inside the JSON file and then the JSON file would be updated.
    }

    public function changeNoteInFile(Note $note, string $filename){
        //dummy empty implementatiion - there the note with the given identificator would be changed in the array inside the JSON file and then the JSON file would be updated.
    }

    public function getNotesFromFile(string $filename): array{
        //dummy implementatiion - there would be loaded notes from a JSON file given by the filename parameter.
        return [];
    }
}