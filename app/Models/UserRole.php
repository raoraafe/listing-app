<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['name','title'];

    const ROLE_CUSTOMER = 'customer';
    const ROLE_INSURANCE_PROVIDER = 'insurance_provider';
    const ROLE_ADMIN = 'admin';

    /**
     * Get the users associated with the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
