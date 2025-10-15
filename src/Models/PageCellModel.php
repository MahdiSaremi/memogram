<?php

namespace MemoGram\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $use_id
 * @property int $message_id
 * @property string $key
 * @property bool $is_taking_control
 */
class PageCellModel extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function getTable()
    {
        return $this->table ?? config('memogram.database.pages');
    }

    public function getConnectionName()
    {
        return $this->connection ?? config('memogram.database.connection');
    }

    public function use(): BelongsTo
    {
        return $this->belongsTo(PageUseModel::class, 'use_id', 'id');
    }
}