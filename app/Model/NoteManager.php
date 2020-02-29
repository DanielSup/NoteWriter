<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 9:02
 */

namespace App\Model;
use App\Model\Entity\Note;
use Nette;
use App\Model\Storage\IStorage;

class NoteManager
{
    use Nette\SmartObject;

    private $storage;

    public function __construct(IStorage $storage)
    {
        $this->storage = $storage;
    }

    public function saveNote(string $text, string $title = "", int $id = 0){
        if (!empty($id)) {
            $note = $this->getNoteById($id);
            $newNote = new Note($text, $title, $id, $note->getDate());
            $this->storage->save($newNote);
        } else {
            $note = new Note($text, $title, $id, new \DateTime());
            $this->storage->save($note);
        }
    }

    public function getNotes(): array{
        return $this->storage->getNotes();
    }

    public function getNoteById($id): Note{
        return $this->storage->getNoteById($id);
    }

}