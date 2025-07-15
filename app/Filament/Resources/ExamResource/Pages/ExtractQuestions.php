<?php

namespace App\Filament\Resources\ExamResource\Pages;

use App\Filament\Resources\ExamResource;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use App\Models\Exam;
use App\Models\Question;
use App\Services\QuestionExtractor;
use Illuminate\Http\RedirectResponse;

class ExtractQuestions extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = ExamResource::class;

    protected static string $view = 'filament.resources.exam-resource.pages.extract-questions';

    public ?Exam $record = null;

    public string $extractedText = '';

    public function mount(Exam $record): void
    {
        $this->record = $record;
        $extractedText=QuestionExtractor::extractText($record->file_path);
        $this->form->fill([
            'extractedText' => $extractedText // You can load OCR text here later
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make('extractedText')
                ->label('Extracted Text')
                ->rows(20)
                ->required(),
        ])->statePath('');
    }
    public function sanitizeXmlContent($xml) {
        return preg_replace_callback('/>([^<]+)</', function ($matches) {
            $escaped = htmlspecialchars($matches[1], ENT_QUOTES | ENT_XML1, 'UTF-8');
            return '>' . $escaped . '<';
        }, $xml);
    }
    public function submit()
    {
        $data = $this->form->getState();
        $xml = $data['extractedText'] ?? '';
        try {
            $sanitizedXml = $this->sanitizeXmlContent($xml);
            $xmlObject = simplexml_load_string($sanitizedXml);
            foreach ($xmlObject->question as $q) {
                $questionText = (string) $q->text;
                $options = $q->option;
                $answer = isset($q->answer) ? (string) $q->answer : null;

                Question::Create(
                [
                    'exam_id'   => $this->record->id,
                    'question'  => $questionText,
                    'option_a'  => isset($options[0]) ? (string) $options[0] : null,
                    'option_b'  => isset($options[1]) ? (string) $options[1] : null,
                    'option_c'  => isset($options[2]) ? (string) $options[2] : null,
                    'option_d'  => isset($options[3]) ? (string) $options[3] : null,
                    'answer'    => $answer,
                ]);
            }

            session()->flash('success', 'Questions saved!');
            return redirect(ExamResource::getUrl());
         }
          catch (\Exception $e) {
            dd($e);
        session()->flash('error', 'Failed to parse XML: ' . $e->getMessage());
         return back();
        }
    }
}
