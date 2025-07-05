<?php

function patternOzCyrill(array $array): array
{
    $pattern = [];
    foreach ($array as $value) {
        $pattern[] = '/' . $value . '/';
    }

    return $pattern;
}

function ozCyrillToLatin(null|string $string, bool $isUcFirst = true): null|string
{
    $cyr = [
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'қ', 'ҳ', 'ғ', 'ў',
        'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Қ', 'Ҳ', 'Ғ', 'Ў',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
    ];
    $lat = [
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'h', 'g\'', 'o\'',
        'r', 's', 't', 'u', 'f', 'x', 'ts', 'ch', 'sh', 'sh', '\'', 'i', '', 'e', 'yu', 'ya',
        'A', 'B', 'V', 'G', 'D', 'Ye', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'H', 'G\'', 'O\'',
        'R', 'S', 'T', 'U', 'F', 'X', 'Ts', 'Ch', 'Sh', 'Sh', '\'', 'I', '', 'E', 'Yu', 'Ya'
    ];

    $pattern = patternOzCyrill($cyr);
    $subject = preg_replace($pattern, $lat, $string);
    return $isUcFirst
        ? ucfirst($subject)
        : $subject;
}

function patternLatin($array)
{
    foreach ($array as $value) {
        if (preg_match('/([A-Z]|[a-z])\'/', $value, $matches)) {
            $preg = preg_replace('/\'/', '\\\'', $value);
            $pattern[] = '/' . $preg . '/';
        } else {
            $pattern[] = '/' . $value . '/';
        }
    }

    return $pattern;
}

function latinToCyrill(null|string $string, bool $isUcFirst = true): null|string
{
    $cyr = [
        'е', 'ё', 'ю', 'я', 'ц', 'ч', 'ш', 'у', 'г', 'у', 'г',
        'Е', 'Ё', 'Ю', 'Я', 'Ц', 'Ч', 'Ш', 'У', 'Г', 'У', 'Г', 'Е', 'Ё', 'Ю', 'Я', 'Ц', 'Ч', 'Ш',
        'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'к', 'л', 'м', 'н', 'о', 'п', 'к', 'й', 'р', 'т', 'у', 'ф', 'х', 'х', 'с',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'К', 'Л', 'М', 'Н', 'О', 'П', 'К', 'Й', 'Р', 'Т', 'У', 'Ф', 'Х', 'Х', 'С', 'ъ', 'Ъ', 'ъ', 'Ъ'
    ];

    $lat = [
        'ye', 'yo', 'yu', 'ya', 'ts', 'ch', 'sh', 'o\'', 'g\'', 'o‘', 'g‘',
        'Ye', 'Yo', 'Yu', 'Ya', 'Ts', 'Ch', 'Sh', 'O\'', 'G\'', 'O‘', 'G‘', 'YE', 'YO', 'YU', 'YA', 'TS', 'CH', 'SH',
        'a', 'b', 'v', 'g', 'd', 'e', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'y', 'r', 't', 'u', 'f', 'h', 'x', 's',
        'A', 'B', 'V', 'G', 'D', 'E', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'Y', 'R', 'T', 'U', 'F', 'H', 'X', 'S', '\'', '\'', '‘', '‘'
    ];

    $pattern = array_merge(['/^E/', '/^e/', '/\\sE/', '/\\se/'], patternLatin($lat));
    $replacement = array_merge(['Э', 'э', ' Э', ' э'], $cyr);
    $subject = preg_replace($pattern, $replacement, $string);
    return $isUcFirst
        ? ucfirst($subject)
        : $subject;
}

function latinToOzCyrill(null|string $string, bool $isUcFirst = true): null|string
{
    $cyr = [
        'е', 'ё', 'ю', 'я', 'ц', 'ч', 'ш', 'ў', 'ғ', 'ў', 'ғ',
        'Е', 'Ё', 'Ю', 'Я', 'Ц', 'Ч', 'Ш', 'Ў', 'Ғ', 'Ў', 'Ғ', 'Е', 'Ё', 'Ю', 'Я', 'Ц', 'Ч', 'Ш',
        'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'к', 'л', 'м', 'н', 'о', 'п', 'қ', 'й', 'р', 'т', 'у', 'ф', 'ҳ', 'х', 'с',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Қ', 'Й', 'Р', 'Т', 'У', 'Ф', 'Ҳ', 'Х', 'С', 'ъ', 'Ъ', 'ъ', 'Ъ'
    ];

    $lat = [
        'ye', 'yo', 'yu', 'ya', 'ts', 'ch', 'sh', 'o\'', 'g\'', 'o‘', 'g‘',
        'Ye', 'Yo', 'Yu', 'Ya', 'Ts', 'Ch', 'Sh', 'O\'', 'G\'', 'O‘', 'G‘', 'YE', 'YO', 'YU', 'YA', 'TS', 'CH', 'SH',
        'a', 'b', 'v', 'g', 'd', 'e', 'j', 'z', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'y', 'r', 't', 'u', 'f', 'h', 'x', 's',
        'A', 'B', 'V', 'G', 'D', 'E', 'J', 'Z', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'Y', 'R', 'T', 'U', 'F', 'H', 'X', 'S', '\'', '\'', '‘', '‘'
    ];

    $pattern = array_merge(['/^E/', '/^e/', '/\\sE/', '/\\se/'], patternLatin($lat));
    $replacement = array_merge(['Э', 'э', ' Э', ' э'], $cyr);
    $subject = preg_replace($pattern, $replacement, $string);
    return $isUcFirst
        ? ucfirst($subject)
        : $subject;
}

function patternCyrill($array)
{
    foreach ($array as $value) {
        $pattern[] = '/' . $value . '/';
    }

    return $pattern;
}

function cyrillToLatin($string)
{
    $cyr = [
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'қ', 'ҳ', 'ғ', 'ў',
        'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Қ', 'Ҳ', 'Ғ', 'Ў',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
    ];
    $lat = [
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'h', 'g\'', 'o\'',
        'r', 's', 't', 'u', 'f', 'x', 'ts', 'ch', 'sh', 'sh', '\'', 'i', '', 'e', 'yu', 'ya',
        'A', 'B', 'V', 'G', 'D', 'Ye', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'H', 'G\'', 'O\'',
        'R', 'S', 'T', 'U', 'F', 'X', 'Ts', 'Ch', 'Sh', 'Sh', '\'', 'I', '', 'E', 'Yu', 'Ya'
    ];

    $pattern = patternCyrill($cyr);
    return preg_replace($pattern, $lat, $string);
}
