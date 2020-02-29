<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 15:14
 */

namespace App\Forms;

use Nette;
use App\Model\Entity\Note;
use App\Model\NoteManager;
use Nette\Application\UI\Form;

class NoteFormFactory
{
    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var NoteManager */
    private $noteManager;

    public function __construct(FormFactory $factory, NoteManager $noteManager)
    {
        $this->factory = $factory;
        $this->noteManager = $noteManager;
    }

    public function create(int $id = 0): Form {
        $form = $this->factory->create();
        $form->addText('title', 'Title:');

        $preprocessors = [
            'none' => '',
            'Tex' => 'TEX',
            'Markdown'  => 'Markdown',
        ];

        $form->addSelect('preprocessor', 'Preprocessor:', $preprocessors)
            ->setHtmlAttribute('onChange', 'changeText()');
        $form->addTextArea('text', 'Text:')
            ->setRequired('Please enter your text.');

        $form->addSubmit('send', $id == 0 ? 'Add note' : 'Edit note');

        if(!empty($id)){
            $note = $this->noteManager->getNoteById($id);
            $form->setDefaults([
                'title' => $note->getTitle(),
                'text' => $note->getText(),
                'preprocessor' => $note->getPreprocessor()
            ]);
        }

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($id): void {
            $this->noteManager->saveNote($values->text, $values->title, $id, $values->preprocessor);
        };
        return $form;
    }
}