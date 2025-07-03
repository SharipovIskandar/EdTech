<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;

trait EnumHelper
{
    public static function in(bool $isValidation = true): string
    {
        $data = implode(',', self::values());
        if ($isValidation) {
            $data = 'in:' . $data;
        }
        return $data;
    }

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    public static function list()
    {
        $list = [];
        $group = self::group();
        foreach (self::values() as $value) {
            $list[] = [
                'code' => $value,
                'name' => Lang::has("enum." . $group . $value)
                    ? __('enum.' . $group . $value)
                    : ucfirst($value)
            ];
        }
        return $list;
    }

    public static function group($isTranslate = true)
    {
        $group = method_exists(self::class, 'groupName')
            ? self::groupName()
            : null;

        return $group
            ? ($isTranslate ? $group . '.' : $group)
            : null;
    }

    public static function translate($case, $locale = null)
    {
        $group = self::group();
        return Lang::has("enum." . $group . $case, $locale)
            ? [
                'code' => $case,
                'name' => __('enum.' . $group . $case, locale: $locale),
            ]
            : [
                'code' => $case,
                'name' => $case ? ucfirst($case) : null
            ];
    }

    public static function randomCase(): self
    {
        return self::cases()[array_rand(self::cases())];
    }

    public function toString(): string
    {
        $group = self::group();
        return Lang::has("enum." . $group . $this->value)
            ? __('enum.' . $group . $this->value)
            : ucfirst($this->value ?? '');
    }
}
