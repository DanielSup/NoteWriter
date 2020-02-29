<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.2.20
 * Time: 14:24
 */

declare(strict_types=1);

namespace App\Presenters;


use App\Forms\NoteFormFactory;
use App\Model\NoteManager;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;

class NotePresenter extends BasePresenter
{
    /** @var NoteManager */
    private $noteManager;

    /** @var  NoteFormFactory */
    private $noteFormFactory;
    /** @persistent */
    public $lastMarkdown = "none";

    public function __construct(NoteManager $noteManager, NoteFormFactory $noteFormFactory)
    {
        $this->noteManager = $noteManager;
        $this->noteFormFactory = $noteFormFactory;
    }

    public function actionAdd(){
        $this->template->actualText = "";
    }

    public function actionEdit($id){
        $this->template->id = $id;
    }

    /**
     * This method is called after selecting a preprocessor and ensures showing an editable div with the preprocessed text.
     * @param $text
     * @param $markdown
     */
    public function handleConvert($text, $markdown)
    {
        if (!$this->isAjax() || $markdown == "none"){
            return;
        }
        $className = "App\\Model\\Preprocessor\\".$markdown . "Preprocessor";
        $preprocessor = new $className();
        $this->template->actualText = $preprocessor->textToHTML($text);
        $this->lastMarkdown = $markdown;
        $this->redrawControl("wrapper");
        $this->redrawControl("textFill");
    }

    /** This method is called after losing focus of the editable div with already preprocessed text
     * @param $text
     * @param $markdown
     */
    public function handleConverthtml($html, $markdown)
    {
        $className = "App\\Model\\Preprocessor\\".$markdown . "Preprocessor";
        $preprocessor = new $className();
        $actualText = $preprocessor->HTMLToText($html);
        $this->lastMarkdown = $markdown;
        $this->sendResponse(new JsonResponse(['text' => $actualText]));
    }

    protected function createComponentAddForm() : Form{
        return $this->noteFormFactory->create();
    }

    protected function createComponentEditForm(){
        return new Multiplier(function ($noteId) : Form {
            return $this->noteFormFactory->create(intval($noteId));
        });
    }

    public function renderAdd(){
    }

    public function renderDefault(){
        $this->template->notes = $this->noteManager->getNotes();
    }

}