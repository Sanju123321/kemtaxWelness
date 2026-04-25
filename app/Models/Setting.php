<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    /**
     * Get a setting value by key, with an optional default.
     */
    public static function getValue(string $key, $default = null): mixed
    {
        if (!Schema::hasTable('settings')) {
            return $default;
        }

        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
    }

    /**
     * Get all settings as a key→value array (optionally filtered by group).
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)->pluck('value', 'key')->toArray();
    }
}
