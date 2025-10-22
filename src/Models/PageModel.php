<?php

namespace MemoGram\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $reference
 * @property array $states
 * @property string $states_hash
 * @property ?string $version
 */
class PageModel extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'states' => 'array',
    ];

    public function getTable()
    {
        return $this->table ?? config('memogram.database.pages');
    }

    public function getConnectionName()
    {
        return $this->connection ?? config('memogram.database.connection');
    }

    public function uses(): HasMany
    {
        return $this->hasMany(PageUseModel::class, 'page_id', 'id');
    }
}