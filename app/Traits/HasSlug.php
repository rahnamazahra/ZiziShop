<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public function ensureUniqueSlug($request)
    {
        if ($request->slug) {
            return;
        }

        $slug = Str::slug($this->name, language: null);
        $similarSlugs  = static::where('slug', 'like', "$slug%")->get();

        if ($similarSlugs->isEmpty()) {
            return $this->slug = $slug;
        }

        $counter = 2;
        while ($similarSlugs->contains('slug', $slug. '-' . $counter)) {
            $counter++;
        }

        $this->slug = $slug . '-' . $counter;
    }

}
