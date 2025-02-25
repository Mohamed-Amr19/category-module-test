<?php

namespace Modules\Category\Models;

use App\Traits\Attributes\HasPrimaryImage;
use App\Traits\HasTranslatableWithJsonEscape;
use App\Traits\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;

// use Modules\Category\Database\Factories\CategoryFactory;

class Category extends Model implements HasMedia
{

    use HasTranslatableWithJsonEscape;
    use HasActiveScope;
    use HasPrimaryImage;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'is_active',
        'parent_id',

    ];

    public $translatable = [
        'name',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
