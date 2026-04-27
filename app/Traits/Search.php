<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Search
{
    protected function applyNameSearch(Builder $query, Request $request)
    {
        $search =$request->input('search') ?? '';

        if ($search !== '') {
            $query->where('name', 'like', '%'.$search.'%');
        }

        return $search;
    }
}
