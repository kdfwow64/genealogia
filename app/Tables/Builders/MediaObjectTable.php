<?php

namespace App\Tables\Builders;

use App\MediaObject;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class MediaObjectTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/mediaobjects.json';

    public function query(): Builder
    {
        return MediaObject::selectRaw('
            media_objects.id, media_objects.gid, media_objects.group, media_objects.obje_id, media_objects.titl,  media_objects.rin, media_objects.created_at
        ');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
