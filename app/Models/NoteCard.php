<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\Traits\UpdatesOnTouch;
use LaravelEnso\Rememberable\Traits\Rememberable;
use App\Person;

class NoteCard extends Model
{
    use AvoidsDeletionConflicts, UpdatesOnTouch, Rememberable;

    protected $guarded = ['id'];

    protected $touches = ['notecard'];

    protected $fillable = ['gid', 'note', 'rin', 'name', 'description', 'is_active', 'type_id', 'group'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    public function person()
    {
        return $this->belongsToMany(Person::class);
    }


    public function notecard()
    {
        return $this->morphTo();
    }

    public function isDefault()
    {
        return $this->is_default;
    }

    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    public function scopeNotDefault($query)
    {
        return $query->whereIsDefault(false);
    }

    public function scopeFor($query, int $notecard_id, string $notecard_type)
    {
        return $query->whereAddressableId($notecard_id)
            ->whereAddressableType($notecard_type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_default');
    }

    public function store()
    {
        DB::transaction(function () {
            $defaultNote = $this->notecard->note;

            if ($this->is_default) {
                optional($defaultNote)->update(['is_default' => false]);
            } elseif (! $defaultNote) {
                $this->is_default = true;
            }

            $this->save();
        });
    }

    public function makeDefault()
    {
        DB::transaction(function () {
            $this->notecard->notes()
                ->whereIsDefault(true)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }


    public function getLoggableMorph()
    {
        return config('enso.notes.loggableMorph');
    }

    public function shouldBeSingle(): bool
    {
        return ! $this->canBeMultiple()
            && $this->notecard->note()->exists();
    }

    public function isNotSingle(): bool
    {
        return $this->canBeMultiple()
            && $this->notecard->notes()->where('id', '<>', $this->id)->exists();
    }

    private function canBeMultiple(): bool
    {
        return method_exists($this->notecard, 'notes');
    }
}
