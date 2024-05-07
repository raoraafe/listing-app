<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * Get the users associated with the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role_user');
    }
}
