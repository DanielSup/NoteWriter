<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 19:26
 */

namespace App\Model\Storage\FileLoader;


use App\Model\Entity\Note;

class CSVLoader implements ILoader
{
    const FORMAT = "Y-m-d H:i:s";


    public function appendNoteToFile(Note $note, string $filename){
        //dummy empty implementation - there will be added one row with the note information at the end of CSV the file.
    }

    public function changeNoteInFile(Note $note, string $filename){
        //dummy empty implementation - there the row with information about the note with the given identificator in the CSV file would be changed.
    }

    public function getNotesFromFile(string $filename): array{
        //dummy implementation - there would be loaded notes from a CSV file given by the filename parameter.
        return [];
    }
}