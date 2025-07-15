<?php

namespace App\Filament\Resources\ExamResource\Pages;

use App\Filament\Resources\ExamResource;
use Filament\Resources\Pages\Page;
use App\Models\Exam;

class CropQuestions extends Page
{
    protected static string $resource = ExamResource::class;

    protected static string $view = 'filament.resources.exam-resource.pages.crop-questions';

    public ?Exam $record = null;

    public function mount(Exam $record): void
    {
        $this->record = $record;
    }
}
