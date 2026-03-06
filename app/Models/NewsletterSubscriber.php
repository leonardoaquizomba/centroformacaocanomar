<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    /** @use HasFactory<\Database\Factories\NewsletterSubscriberFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'token',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    /** @param Builder<NewsletterSubscriber> $query */
    public function scopeActive(Builder $query): void
    {
        $query->whereNull('unsubscribed_at');
    }
}
