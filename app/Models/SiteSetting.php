<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'support_email',
        'whatsapp',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
    ];

    /**
     * Return the single settings row, creating it if it doesn't exist.
     */
    public static function get(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /**
     * Build the wa.me URL from the stored whatsapp number.
     */
    public function whatsappUrl(): string
    {
        $number = preg_replace('/\D/', '', $this->whatsapp ?? '');

        return $number ? "https://wa.me/{$number}" : '#';
    }

    /**
     * Return phone stripped to digits only, for use in tel: links.
     */
    public function telLink(): string
    {
        return $this->phone ? '+'.preg_replace('/\D/', '', $this->phone) : '#';
    }
}
