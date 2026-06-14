<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['gemini_api_key'];

    public static function getSettings(): static
    {
        return static::firstOrCreate([], ['gemini_api_key' => null]);
    }
}
