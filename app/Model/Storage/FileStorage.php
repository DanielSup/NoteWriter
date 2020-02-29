<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 9:13
 */

namespace App\Model\Storage;

use App\Model\Entity\Note;
use App\Model\Storage\FileLoader\ILoader;


class FileStorage implements IStorage
{
    private $filename;

    /** @var ILoader */
    private $fileLoader;

    public function __construct($filename, ILoader $fileLoader){
        $this->filename = $filename;
        $this->fileLoader = $fileLoader;
    }

    public function save(Note $note)
    {
        if(empty($note->getId())){
            $this->fileLoader->appendNoteToFile($note, $this->filename);
        } else {
            $this->fileLoader->changeNoteInFile($note, $this->filename);
        }
    }

    public function getNotes(): array
    {
        $notes = $this->fileLoader->getNotesFromFile($this->filename);
        usort($notes, function($a, $b){
            if ($a->getDate() < $b->getDate()){
                return 1;
            } elseif ($a->getDate() > $b->getDate()) {
                return -1;
            }
            return 0;
        });
        return $notes;
    }

    public function getNoteById($id): Note
    {
        foreach($this->getNotes() as $note){
            if ($note->getId() == $id){
                return $note;
            }
        }
        return null;
    }
}