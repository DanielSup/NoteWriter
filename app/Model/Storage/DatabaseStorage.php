<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 9:13
 */

namespace App\Model\Storage;

use Nette;
use App\Model\Entity\Note;

class DatabaseStorage implements IStorage
{
    private const
        TABLE_NAME = 'note',
        COLUMN_ID = 'id',
        COLUMN_TITLE = 'title',
        COLUMN_TEXT = 'text',
        COLUMN_DATE = 'date',
        COLUMN_PREPROCESSOR = 'preprocessor';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database){
        $this->database = $database;
    }

    public function save(Note $note){
        $count = $this->database->table(self::TABLE_NAME)->count();
        $maxId= $this->database->table(self::TABLE_NAME)->max(self::COLUMN_ID);
        $actualNewId = $count == 0 ? 1 : $maxId + 1;
        $id = $note->getId() != 0 ? $note->getId() : $actualNewId;
        $noteArray = [self::COLUMN_ID => $id,
                      self::COLUMN_TITLE => $note->getTitle(),
                      self::COLUMN_TEXT => $note->getText(),
                      self::COLUMN_DATE => $note->getDate(),
                      self::COLUMN_PREPROCESSOR => $note->getPreprocessor()];
        if ($this->database->table(self::TABLE_NAME)->get($note->getId()) !== null){
            $this->database->table(self::TABLE_NAME)->where('id = ?', $id)->update($noteArray);
        } else {
            $this->database->table(self::TABLE_NAME)->insert($noteArray);
        }
    }

    public function getNotes(): array{
        $notesInDatabase = $this->database->table(self::TABLE_NAME)->order(self::COLUMN_DATE. ' DESC');
        $notes = [];
        foreach($notesInDatabase as $noteInDatabase){
            $note = new Note($noteInDatabase->text, $noteInDatabase->title, $noteInDatabase->id, $noteInDatabase->date, $notesInDatabase->preprocessor);
            array_push($notes, $note);
        }
        return $notes;
    }

    public function getNoteById($id): Note
    {
        $noteRow = $this->database->table(self::TABLE_NAME)->get($id);
        return new Note($noteRow->text, $noteRow->title, $noteRow->id, $noteRow->date, $noteRow->preprocessor);
    }
}