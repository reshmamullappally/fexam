<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                ->label('Course')
                ->relationship('course', 'name') 
                ->searchable()
                ->required(),
            TextInput::make('name')
                ->label('Exam Name')
                ->required()
                ->maxLength(255),
            TextInput::make('year')
                ->label('Year')
                ->required()
                ->numeric()
                ->minValue(1900)
                ->maxValue(2100),
            Select::make('month')
                ->label('Month')
                ->required()
                ->options([
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December',
                ])
                ->native(false), 

            FileUpload::make('file_path')
            ->label('Upload PDF or Image')
            ->disk('public') // saves to storage/app/public
            ->directory('exam_uploads') // folder inside public disk
            ->acceptedFileTypes(['application/pdf', 'image/*']) // only PDF or images
            ->maxSize(40960)
            ->required(false),
             FileUpload::make('image_path')
            ->label('Upload Exam Image')
            ->disk('public') // saves to storage/app/public
            ->directory('exam_image') // folder inside public disk
            ->acceptedFileTypes(['image/*']) // only PDF or images
            ->maxSize(40960)
            ->required(false),
            Textarea::make('details')
            ->label('Details')
            ->rows(4) // Optional: number of visible rows
            ->maxLength(1000)
            ->placeholder('Enter exam details here...'),
            Select::make('exam_type')
                ->label('Exam Type')
                ->required()
                ->options([
                    'OMR' => 'OMR',
                    'Normal' => 'Normal',
                ]),
            Toggle::make('active')
                ->label('Active')
                ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                ->label('Course')
                ->sortable()
                ->searchable(),

            TextColumn::make('name')
                ->label('Exam Name')
                ->sortable()
                ->searchable(),

           TextColumn::make('exam_date')
            ->label('Exam Date')
            ->getStateUsing(fn ($record) =>
                \Carbon\Carbon::createFromDate((int) $record->year, (int) $record->month)->format('F Y')
            ),

            IconColumn::make('active')
                ->boolean()
                ->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Action::make('Extract Questions')
                // ->label('Extract')
                // ->url(fn (Exam $record) => ExamResource::getUrl('extract', ['record' => $record]))
                // ->color('primary')
                // ->icon('heroicon-o-document-text'),
                Action::make('View Questions')
                ->label('View Questions')
                ->url(fn (Exam $record) => ExamResource::getUrl('view_questions', ['record' => $record]))
                ->color('primary')
                ->icon('heroicon-o-document-text'),
                // Action::make('Crop Questions')
                // ->label('Crop Questions')
                // ->url(fn (Exam $record) => ExamResource::getUrl('crop_questions', ['record' => $record]))
                // ->color('primary')
                // ->icon('heroicon-o-document-text'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
            // 'extract' => Pages\ExtractQuestions::route('/{record}/extract'),
            'view_questions' => Pages\ViewQuestions::route('/{record}/view-questions'),
            // 'crop_questions' => Pages\CropQuestions::route('/{record}/crop'),
            
        ];
    }
}
