<?php
namespace App\Services;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class QuestionExtractor
{
    public static function run(Exam $exam): void
    {
        $text = self::extractText($exam->file_path);

        if (strlen(trim($text)) < 100) {
            \Log::warning("Empty or invalid text for exam ID {$exam->id}");
            return;
        }

        
        \Log::info("Extracted and saved " . count($questions) . " questions.");
    }

    public static function extractText(string $filePath): string
    {
        $fullPath = storage_path('app/public/' . $filePath);
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($fullPath);
        $text = $pdf->getText();

        return (strlen(trim($text)) > 100) ? $text : self::ocrFallback($fullPath);
    }

    protected static function ocrFallback(string $pdfPath): string
    {
        $tempPath = storage_path('app/temp/page');
        exec("convert -density 150 \"$pdfPath\" -quality 90 \"{$tempPath}-%03d.jpg\"");
        $images = glob($tempPath . '-*.jpg');
        $text = '';

        foreach ($images as $img) {
            $text .= (new \TesseractOCR($img))->run() . "\n";
            @unlink($img);
        }

        return $text;
    }

    protected static function buildPrompt(string $text): string
    {
        return <<<PROMPT
You are an expert exam assistant. Extract all multiple-choice questions from the following text.

Return in JSON format like this:

[
  {
    "question": "What is the capital of France?",
    "options": ["Paris", "London", "Rome", "Berlin"],
    "answer": "Paris"
  }
]

Here is the text:

$text
PROMPT;
    }
}
