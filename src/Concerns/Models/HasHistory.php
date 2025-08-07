<?php

namespace SaasPro\Concerns\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SaasPro\Models\History;

trait HasHistory {

    public static function bootHasHistory(){
        self::created(function(self $model){
            $model->saveHistory($model->getHistoryEvent('created'), Auth::user());
        });

        self::updated(function(self $model){
            $model->saveHistory($model->getHistoryEvent('updated'), Auth::user());
        });

        self::deleted(function(self $model){
            $model->saveHistory($model->getHistoryEvent('deleted'), Auth::user());
        });
    }

    function history(){
        return $this->morphMany(History::class, 'entity');
    }

    function saveHistory($event, ?Model $editor = null){
        $history = $this->history()->create([
            'event' => $event,
            'state' => $this->attributesToArray()
        ]);

        if($editor) {
            $history->editor()->associate($editor);
        }

        $history->save();
    }

    function getHistoryEvent($event) {
        return $event;
    }

}