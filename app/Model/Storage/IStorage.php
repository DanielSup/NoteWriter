<?php

namespace App\Model\Storage;

use App\Model\Entity\Note;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 9:08
 */
interface IStorage
{
    public function save(Note $note);
    public function getNotes(): array;
    public function getNoteById($id): Note;
}