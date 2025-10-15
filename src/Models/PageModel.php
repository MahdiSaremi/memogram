<?php

namespace MemoGram\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $reference
 * @property array $states
 * @property string $states_hash
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
}