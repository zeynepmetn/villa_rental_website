<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key) {
            return static::where('key', $key)->value('value');
        });
    }

    /**
     * Set a setting value by key.
     *
     * @param array|string $key
     * @param mixed|null $value
     * @return void
     */
    public static function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            Cache::forget("setting.{$key}");
        }
    }
} 