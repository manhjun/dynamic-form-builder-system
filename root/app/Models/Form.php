<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function versions(): HasMany
    {
        return $this->hasMany(FormVersion::class);
    }

    public function activeVersion(): HasOne
    {
        return $this->hasOne(FormVersion::class)->where('status', 'active');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
