<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * GETTER des users de la conversation.
     */
    public function users() {
        return $this->hasMany('App\Models\User');
    }
}
