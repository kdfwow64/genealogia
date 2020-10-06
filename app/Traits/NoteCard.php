<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use App\Models\Note as Note;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait NoteCard
{
    public static function bootNote()
    {
        self::deleting(function ($model) {
            $shouldRestrict = Config::get('enso.notes.onDelete') === 'restrict'
                && $model->notes()->exists();

            if ($shouldRestrict) {
                throw new ConflictHttpException(
                    __('The entity has notes and cannot be deleted')
                );
            }
        });

        self::deleted(function ($model) {
            if (Config::get('enso.notes.onDelete') === 'cascade') {
                $model->note()->delete();
            }
        });
    }

    public function note()
    {
        return $this->morphOne(Note::class, 'notecard')
            ->whereIsDefault(true);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notecard');
    }
}
