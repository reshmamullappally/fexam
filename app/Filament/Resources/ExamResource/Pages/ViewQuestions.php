<?php

namespace App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource;
use Filament\Resources\Pages\Page;
use App\Models\Exam;
class ViewQuestions extends Page
{
    protected static string $resource = ExamResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.resources.exam-resource.pages.view-questions';

    public function mount(Exam $record): void
    {
        $this->record = $record;
    }
     public function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}
