<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait HasStatus
{
    public function scopeActive($query): void
    {
        if (Schema::getColumnType($this->getTable(), 'status') == 'bool') {
            $query->where('status', true);
        } else {
            $query->where('status', 'active');
        }
    }

    public function scopeActiveList($query, $request = null): void
    {
        $request = getRequest($request);
        $query->when($request->instance == 'active', function ($query) {
            $query->active();
        });
    }

    public function setStatus($value = null): static
    {
        if ($value) {
            $this->status = $value;
        } else {
            if (Schema::getColumnType($this->getTable(), 'status') == 'bool') {
                $this->status = !$this->status;
            } else {
                $this->status = $this->status == 'active' ? 'inactive' : 'active';
            }
        }
        $this->save();
        return $this;
    }
}
