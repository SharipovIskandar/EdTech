<?php

namespace App\Helpers;

use App\Enums\General\PersonalTypeIntEnum;
use App\Enums\RentTypeEnum;
use App\Enums\RentTypeIntEnum;
use App\Models\Contract\ContractPaymentImport;

class PaymentImportHelper
{
    public $text;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText($text = null)
    {
        $text  = $text ?: $this->text;

        return $text;
    }

    public function lot_number($text = null)
    {
        $lotNumber = null;
        $text = $this->getText($text);
        $pattern = "/(l\d+l)|(ло[тд]\s+ра[кқ]ам(?:и)?\s*(?:\-\s*)?\d+)|(ло[тд]\s*(?:[№\-])?\s*\d+)|(lo[td]\s*(?:[№\-])?\s*\d+)|(lo[td]\s+raqam(?:i)?\s*(?:\-\s*)?\d+)/ui";

        if (preg_match_all($pattern, $text, $matches)) {
            $matches = collect($matches)
                ->flatten()
                ->filter(function ($match) {
                    return !(trim($match) == '' || is_null($match));
                })
                ->map(function ($data) {
                    return preg_replace('/\D+/', '', trim($data ?? ''));
                })
                ->unique();

            $lotNumber = $matches->count() == 1
                ? $matches->first()
                : implode(',', $matches->toArray());
        }

        return $lotNumber;
    }

    public function unique_number($text = null)
    {
        $uniqueNumber = null;
        $text = $this->getText($text);
        $pattern = "/[A-Z]{2}\d{9}\/\d{2}/";

        if (preg_match($pattern, $text, $matches)) {
            $matches = array_filter($matches, function ($match) {
                return !(trim($match == '') || is_null($match));
            });

            $uniqueNumber = $matches[0] ?? null;
        }

        return $uniqueNumber;
    }

    public function pinfl($text = null)
    {
        $pinfl = null;
        $text = $this->getText($text);
        $pattern = "/pinfl\:\s*\d{14}\s+/ui";

        if (preg_match($pattern, $text, $matches)) {
            $matches = array_filter($matches, function ($match) {
                return !(trim($match == '') || is_null($match));
            });

            $pinfl = preg_replace('/\D+/', '', trim($matches[0] ?? null));
        }

        return $pinfl;
    }

    public function account_number($accountNumber, $text = null)
    {
        $number = null;
        $text = $this->getText($text);
        $pattern = "/$accountNumber/";

        if (preg_match($pattern, $text, $matches)) {
            $matches = array_filter($matches, function ($match) {
                return !(trim($match == '') || is_null($match));
            });

            $number = preg_replace('/\D+/', '', trim($matches[0] ?? ''));
        }

        return $number == $accountNumber
            ? $number
            : null;
    }

    public function isSave($contract, $accountNumber, $lot, $number, $payer, $rentType, $paymentDate, $regionId)
    {
        $comment = null;
        $isInn = false;
        $isAccount = false;
        $isInitial = false;

        if (count(explode(',', $lot)) > 1) {
            return [
                'comment' => 'Birdan ortiq lot raqami aniqlandi',
                'is_save' => false,
                'few_lots' => true,
                'is_initial_amount' => $isInitial
            ];
        }

        if (preg_match('/\s*' . config('params.auksion_inn') . '\s+/', $payer)) {
            $isInitial = true;
        }

        if (is_null($contract)) {
            return [
                'comment' => null,
                'is_save' => false,
                'few_lots' => false,
                'is_initial_amount' => $isInitial
            ];
        }

        if (ContractPaymentImport::checkAfterPayment($contract->id, $paymentDate)) {
            return [
                'comment' => 'To\'lov sanasidan keyin to\'lovi mavjud',
                'is_save' => false,
                'few_lots' => false,
                'is_initial_amount' => $isInitial
            ];
        }

        if($contract->region_id != $regionId){
            return [
                'comment' => 'Tushum viloyati shartnoma viloyatiga mos kelmadi',
                'is_save' => false,
                'few_lots' => false,
                'is_initial_amount' => $isInitial
            ];
        }

        $isAccount = in_array($contract->rent_type, RentTypeIntEnum::values()) && $contract->rent_type === intval($rentType == RentTypeEnum::PROPERTY->value) && !is_null($this->account_number($accountNumber));

        if ($contract?->winner_subject_type === PersonalTypeIntEnum::LEGAL->value) {
            if ($contract->winner_inn && preg_match('/\s*(' . $contract->winner_inn . '|' . config('params.auksion_inn') . ')\s+/', $payer)) {
                $isInn = true;
            }
        } elseif (in_array($contract?->winner_subject_type, PersonalTypeIntEnum::personalTypes())) {
            $isInn = true;
        }

        if ($isInn && $isAccount) {
            if ($lot) {
                $comment = "To‘lov tafsilotida keltirilgan ($lot) lot raqami orqali aniqlandi.";
            } elseif ($number) {
                $comment = "To‘lov tafsilotida keltirilgan ($number) unikal raqami orqali aniqlandi.";
            }
        } elseif (!$isAccount) {
            if ($contract->rent_type === null || !in_array($contract->rent_type, RentTypeIntEnum::values())) {
                $comment = "Yer uchastkasining huquq turi tizimda mavjud emas";
            } else {
                $comment = "To‘lov tafsilotida keltirilgan ($accountNumber) hisob raqami yer uchastkasining huquq turiga mos kelmadi.";
            }
        } elseif (!$isInn) {
            if (is_null($contract->winner_inn)) {
                $comment = "Xaridorning STIRi tizimda mavjud emas.";
            } else {
                $comment = "To‘lovchining STIRi xaridor (" . $contract->winner_inn . ") STIRiga mos kelmadi.";
            }
        }

        return [
            'comment' => $comment,
            'is_save' => $isInn && $isAccount,
            'few_lots' => false,
            'is_initial_amount' => $isInitial
        ];
    }
}
