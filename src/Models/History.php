<?php

namespace SaasPro\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model {
    
    protected $fillable = ['event', 'state'];

    protected $casts = [
        'state' => 'array'
    ];

    public function entity(){
        return $this->morphTo();
    }
    
    public function editor(){
        return $this->morphTo();
    }

    function getEntityNameAttribute(){
        return $this->entity->getHistoryEntityName();
    }

    function getEditorNameAttribute(){
        return $this->editor?->getHistoryEditorName();
    }

}
