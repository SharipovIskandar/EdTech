<?php

use App\Enums\General\LanguageCodeEnum;
use App\Models\Language;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

function requestOrder()
{
    $sort = request()->get('sort', 'id');
    $direction = request()->get('direction', 'desc');
    $direction = $direction == 'desc'
        ? '-'
        : '';

    $order = request()->get('order', $direction . $sort);

    if ($order[0] == '-') {
        $result = [
            'key' => substr($order, 1),
            'value' => 'desc'
        ];
    } else {
        $result = [
            'key' => $order,
            'value' => 'asc'
        ];
    }
    return $result;
}

function filterPhone($phone)
{
    return str_replace(['(', ')', ' ', '-'], '', $phone);
}

function nudePhone($phone)
{
    if (strlen($phone) > 0) {
        $phone = str_replace(['(', ')', ' ', '-'], '', $phone);
    }

    $phone = preg_replace('/^\+998$/u', '', $phone);

    return $phone;
}

function getRequest($request = null)
{
    return $request ?? request();
}

function defaultLocale()
{
    return Language::where('default', true)->first();
}

function systemLangs()
{
    return Language::whereIn('url', LanguageCodeEnum::values())
        ->active()
        ->get();
}

function langs()
{
    return Language::active()
        ->orderBy('name')
        ->get();
}

function allLanguage()
{
    return Language::all();
}

function routeParam(null|string $separator = ',', string $parameter = 'id'): null|int|string
{
    if (request()->route()->hasParameter($parameter)) {
        $data = request()->route()->parameter($parameter);
        return $separator . (is_object($data) ? $data->id : $data);
    }
    return null;
}

function formatDate(string|int|null $date, $format = 'd.m.Y')
{
    return is_null($date)
        ? null
        : date($format, is_int($date)
            ? $date
            : strtotime($date));
}

function formatTime(string|int|null $time, $format = 'H:i:s')
{
    return is_null($time)
        ? null
        : date($format, is_int($time)
            ? $time
            : strtotime($time));
}

function formatDateTime(string|int|null $dateTime, $format = 'H:i d.m.Y')
{
    return is_null($dateTime)
        ? null
        : date($format, is_int($dateTime)
            ? $dateTime
            : strtotime($dateTime));
}

function formatCurrency($number, $decimal = 2, $round = true)
{
    $decimal = $decimal ?: strlen(explode('.', (string)$number)[1] ?? '');

    return $number !== null
        ? number_format($round ? round($number, $decimal) : $number, $decimal, ',', ' ')
        : null;
}

function docx_to_pdf(string $docx, string $pdf): string
{
    // $command = "unoconv -f pdf -o $pdfFileNamePath $docxFile";
    $isWindows = PHP_OS_FAMILY === 'Windows';
    $convertor = $isWindows
        ? '"C:\Program Files\LibreOffice\program\soffice.exe"'
        : 'sudo libreoffice';

    $docx = escapeshellarg($isWindows ? str_replace('/', '\\', $docx) : $docx);
    $pdf = escapeshellarg($isWindows ? str_replace('/', '\\', $pdf) : $pdf);

    $command = "$convertor --headless --convert-to pdf $docx --outdir $pdf";

    // $process = new Process([$convertor, "--headless", "--convert-to", "pdf", $docx, "--outdir", $pdf]);
    $process = Process::fromShellCommandline($command);
    $process->run();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    return $pdf;
}

function custom_number_format($number)
{
    // Agar butun son bo‘lsa
    if (fmod($number, 1) == 0) {
        return number_format($number, 0, '.', ' ');
    }

    // Agar kasr qismi bo‘lsa, uni hisoblab chiqarish
    $decimal_part = explode('.', (string)$number)[1] ?? '';
    return number_format($number, strlen($decimal_part), '.', ' ');
}

function getSubstringUntilSecondSpace($string): string
{
    $string = trim($string);
    $firstSpace = strpos($string, ' ');
    if ($firstSpace === false) {
        return $string; // Agar probel bo'lmasa, butun stringni qaytarish
    }

    $secondSpace = strpos($string, ' ', $firstSpace + 1);
    if ($secondSpace === false) {
        return $string; // Agar faqat bitta probel bo'lsa, butun stringni qaytarish
    }

    return substr($string, 0, $secondSpace);
}
function summFormat($summa = 0, $precision = 2)
{
    $units = [
        '',
        ' ming',
        ' million',
        ' milliard',
        ' trillion',
        ' kvadrillion',
        ' kvintillion',
        ' sekstillion',
        ' septrillion',
        ' oktillion',
        ' nonillion',
        ' desillion'
    ];

    $index = 0;

    while (abs($summa) >= 1000 && $index < count($units) - 1) {
        $summa /= 1000;
        $index++;
    }

    return round($summa, $precision) . $units[$index];
}

function mlrdFormat($summa = 0, int $decimals = 2, string $suffix = ' mlrd'): string
{
    if (!is_numeric($summa)) {
        return number_format(0, $decimals, '.', '');
    }

    $milliard = $summa / 1_000_000_000;

    if (round($milliard, $decimals) > 0) {
        return number_format($milliard, $decimals, '.', '');
    }

    return number_format(0, $decimals, '.', '');
}


function mlnFormat($summa = 0)
{
    $million = $summa / 1000000;
    return number_format($million, 2, '.', '') . ' mln';
}
