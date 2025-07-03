<?php

namespace App\Traits;

trait Scopes
{
    public function scopeWhereEqual($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->where($tableField, $request->$requestField);
    }

    public function scopeWhereIn2($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        $values = array_filter($request->$requestField ?? [], function ($value) {
            return !in_array($value, [null, 'undefined']);
        });

        if (count($values) > 0)
            $query->whereIn($tableField, $values);
    }

    public function scopeWhereEqualDate($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereDate($tableField, $request->$requestField);
    }

    public function scopeWhereLike($query, $tableField, $requestField = null, $request = null, bool $multiLike = false): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined'])) {
            if ($multiLike) {
                $query->where(function ($query) use ($request, $requestField, $tableField) {
                    $value = $request->{$requestField};
                    $cyrill = latinToCyrill($value);
                    $latin = ozCyrillToLatin($value);
                    $query->where($tableField, 'like', '%' . $value . '%')
                        ->orWhere($tableField, 'like', '%' . $cyrill . '%')
                        ->orWhere($tableField, 'like', '%' . $latin . '%');
                });
            } else {
                $query->where($tableField, 'like', '%' . $request->{$requestField} . '%');
            }
        }
    }

    public function scopeOrWhereLike($query, $tableField, $requestField = null, $request = null, bool $multiLike = false): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined'])) {
            if ($multiLike) {
                $query->orWhere(function ($query) use ($request, $requestField, $tableField) {
                    $value = $request->{$requestField};
                    $cyrill = latinToCyrill($value);
                    $latin = ozCyrillToLatin($value);
                    $query->where($tableField, 'like', '%' . $value . '%')
                        ->orWhere($tableField, 'like', '%' . $cyrill . '%')
                        ->orWhere($tableField, 'like', '%' . $latin . '%');
                });
            } else {
                $query->orWhere($tableField, 'like', '%' . $request->{$requestField} . '%');
            }
            // $query->orWhere($tableField, 'like', '%' . $request->$requestField . '%');
        }
    }

    public function scopeWhereHasLike($query, $relationName, $tableField, $requestField = null, $request = null, bool $multiLike = false): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereHas($relationName, function ($query) use ($tableField, $requestField, $request, $multiLike) {
                $query->whereLike($tableField, $requestField, $request, $multiLike);
                // $query->where($tableField, 'like', '%' . $request->$requestField . '%');
            });
    }

    public function scopeWhereHasEqual($query, $relationName, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereHas($relationName, function ($query) use ($tableField, $requestField, $request) {
                $query->where($tableField, $request->$requestField);
            });
    }

    public function scopeOrWhereHasLike($query, $relationName, $tableField, $requestField = null, $request = null, bool $multiLike = false): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->orWhereHas($relationName, function ($query) use ($tableField, $requestField, $request, $multiLike) {
                $query->whereLike($tableField, $requestField, $request, $multiLike);
                // $query->where($tableField, 'like', '%' . $request->$requestField . '%');
            });
    }

    public function scopeWhereBetween2($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;

        $start = $requestField . '_start';
        $end = $requestField . '_end';
        if ($request->$start) {
            $query->whereDate($tableField, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->whereDate($tableField, '<=', $request->$end);
        }
    }

    public function scopeWhereBetween3($query, $tableField, $request = null): void
    {
        $request = getRequest($request);
        $start = $tableField . '_start';
        $end = $tableField . '_end';
        if ($request->$start) {
            $query->where($tableField, '>=', $request->$start);
        }
        if ($request->$end) {
            $query->where($tableField, '<=', $request->$end);
        }
    }

    public function scopeWhereFromToDate($query, $tableField, $from = 'from_date', $to = 'to_date', $request = null): void
    {
        $request = getRequest($request);

        if ($request->get($from)) {
            $query->whereDate($tableField, '>=', $request->{$from});
        }
        if ($request->get($to)) {
            $query->whereDate($tableField, '<=', $request->{$to});
        }
    }

    public function scopeWhereHasFromToDate($query, $relationName, $tableField, $from = 'from_date', $to = 'to_date', $request = null)
    {
        $request = getRequest($request);
        $from = $relationName . '_' . $from;
        $to = $relationName . '_' . $to;

        if ($request->{$from} || $request->{$to}) {
            $query->whereHas($relationName, function ($query) use ($tableField, $from, $to, $request) {
                $query->whereFromToDate($tableField, $from, $to, $request);
            });
        }
    }

    public function scopeWhereEqualJson($query, $column, $field, $requestField = null, $request = null, $value = null)
    {
        $request = getRequest($request);
        $requestField = $requestField ?: $field;
        $value = $value ?: $request->{$requestField};

        if ($value) {
            $query->whereRaw("json_value($column, '$.$field') = ?", [$value]);
        }
    }

    public function scopeWhereSearchJson($query, string $column, array $fields, $request = null, $value = null, $requestField = 'search')
    {
        $request = getRequest($request);
        $search = $value ?: $request->{$requestField};

        if ($search) {
            $query->where(function ($query) use ($fields, $search, $column) {
                foreach ($fields as $index => $field) {
                    $index == 0
                        ? $query->whereRaw("json_value($column, '$.$field') like ?", ["%$search%"])
                        : $query->orWhereRaw("json_value($column, '$.$field') like ?", ["%$search%"]);
                }
            });
        }
    }

    public function scopeSort($query, $field = null, $direction = 'desc'): void
    {
        $sort = $field
            ? [
                'key' => $field,
                'value' => $direction
            ]
            : null;

        $order = $sort ?: requestOrder();

        if ($order['key'] == 'fullname') {
            foreach (['surname', 'name', 'patronymic'] as $value) {
                $query->orderBy($value, $order['value']);
            }
        } else {
            $query->orderBy($order['key'] == 'id' ? $this->getTable() . '.id' : $order['key'], $order['value']);
        }
    }

    public function scopeWhereSearch($query, $fieldNames, $request = null, $deepSearch = false, $requestField = 'search', bool $multiLike = false)
    {
        $request = getRequest($request);
        $search = $request->get($requestField);

        if ($search) {
            $query->where(function ($query) use ($fieldNames, $requestField, $request, $multiLike) {
                foreach ($fieldNames as $index => $field) {
                    $index == 0
                        ? $query->whereLike($field, $requestField, $request, $multiLike)
                        : $query->orWhereLike($field, $requestField, $request, $multiLike);
                    // $index == 0
                    //     ? $query->where($field, 'like', '%' . $search . '%')
                    //     : $query->orWhere($field, 'like', '%' . $search . '%');
                }
            });

            $query->when(empty(array_diff(['surname', 'name', 'patronymic'], $this->getFillable())) && empty(array_diff(['surname', 'name', 'patronymic'], $fieldNames)), function ($query) use ($search, $multiLike) {
                $query->orWhere(function ($query) use ($search, $multiLike) {
                    $concat = "surname || ' ' || name || ' ' || patronymic";
                    $query->whereRaw("$concat like ?", ["%$search%"])
                        ->when($multiLike, function ($query) use ($search, $concat) {
                            $cyrill = latinToCyrill($search);
                            $latin = ozCyrillToLatin($search);
                            $query->orWhereRaw("$concat like ?", ["%$latin%"])
                                ->orWhereRaw("$concat like ?", ["%$cyrill%"]);
                        });
                });
            });

            if ($this->translatable) {
                $query->orWhereHas('translations', function ($query) use ($fieldNames, $search, $deepSearch) {
                    $query->where(function ($query) use ($fieldNames, $search, $deepSearch) {
                        foreach ($fieldNames as $key => $field) {
                            $key == 0
                                ? $query->where(function ($query) use ($field, $search, $deepSearch) {
                                    $query->where('field_name', $field)
                                        ->when(!$deepSearch, function ($query) {
                                            $query->where('language_url', app()->getLocale());
                                        })
                                        ->where('field_value', 'like', '%' . $search . '%');
                                })
                                : $query->orWhere(function ($query) use ($field, $search, $deepSearch) {
                                    $query->where('field_name', $field)
                                        ->when(!$deepSearch, function ($query) {
                                            $query->where('language_url', app()->getLocale());
                                        })
                                        ->where('field_value', 'like', '%' . $search . '%');
                                });
                        }
                    });
                });
            }
        }
    }

    public function scopeWhereHasSearch($query, $relation, $fieldNames, $request = null, $deepSearch = false, $requestField = 'search', bool $multiLike = false)
    {
        $request = getRequest($request);
        if ($request->search) {
            $query->whereHas($relation, function ($query) use ($fieldNames, $request, $deepSearch, $requestField, $multiLike) {
                $query->whereSearch($fieldNames, $request, $deepSearch, $requestField, $multiLike);
            });
        }
    }

    public function scopeCustomPaginate($query, $per_page = null, $requestField = 'per_page', $request = null)
    {
        $request = getRequest($request);
        return $query->paginate($request->get($requestField, $per_page ?? self::count()));
    }

    /////////////////////////
    public function scopeWhereEqualYear($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined']))
            $query->whereYear($tableField, $request->$requestField);
    }

    public function scopeWhereEqualMonth($query, $tableField, $requestField = null, $request = null): void
    {
        $request = getRequest($request);
        $requestField = $requestField ?? $tableField;
        if (!in_array($request->$requestField, [null, 'undefined'])) {
            $query->whereMonth($tableField, $request->$requestField);
        }
    }
}
