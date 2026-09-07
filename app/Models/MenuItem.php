<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['label', 'url', 'page_id', 'location', 'order'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getResolvedUrlAttribute()
    {
        if ($this->page_id && $this->page) {
            return route('page.show', $this->page->slug);
        }
        return $this->url ?: '#';
    }
}
