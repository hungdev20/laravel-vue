<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'usergroups';
    protected $fillable = [
        'name',
        'description',
    ];
    use HasFactory;
    public function user(): HasOne
    {
        return $this->hasOne(User::class, "groupId");
    }
}
