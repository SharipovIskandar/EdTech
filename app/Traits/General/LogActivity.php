<?php

namespace App\Traits\General;

use Illuminate\Support\Facades\Lang;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogActivity
{
    use LogsActivity;

    public $logLocale = 'uz';

    public function getDescriptionForEvent(string $eventName): string
    {
        // $message = 'log_message.' . $this->getTable() . '.' . $eventName;
        // $messageAttributes = 'message_attributes.' . $this->getTable();

        // if (!(Lang::has($message, $this->logLocale) && Lang::has($messageAttributes, $this->logLocale))) {
        //     return __('log_message.default.' . $eventName, [
        //         'first_attribute' => $this->id
        //     ], $this->logLocale);
        // }

        // $attribute = [];

        // foreach (__($messageAttributes, locale: $this->logLocale) ?: [] as $key => $value) {
        //     $attribute[$key] = $this->convertObject($value);
        // }

        // return __($message, $attribute, $this->logLocale);
        return request()->ip();
    }

    public function convertObject($array)
    {
        $model = $this;
        foreach ($array as $value) {
            $model = $model?->{$value};
        }
        return $model;
    }

    // modelning ba'zi attributlari o'zgarishiga e'tibor bermaslik
    public function getLogExcept()
    {
        $defaultExcept = [
            'created_at',
            'updated_at',
        ];

        if ($this->logExcept) {
            return array_merge($defaultExcept, $this->logExcept);
        }

        return $defaultExcept;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept($this->getLogExcept())
            ->useLogName($this->getTable())
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
