<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\assertTrue;

class Category extends Model
{
    use HasFactory;
    protected static function booted(): void
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }
}
