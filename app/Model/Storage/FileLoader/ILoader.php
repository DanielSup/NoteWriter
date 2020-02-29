<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.2.20
 * Time: 10:34
 */

namespace App\Model\Storage\FileLoader;


use App\Model\Entity\Note;

interface ILoader
{
    public function appendNoteToFile(Note $note, string $filename);
    public function changeNoteInFile(Note $note, string $filename);
    public function getNotesFromFile(string $filename): array;
}