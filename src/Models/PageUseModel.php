<?php

namespace MemoGram\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $page_id
 * @property int $chat_id
 */
class PageUseModel extends Model
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

    public function page(): BelongsTo
    {
        return $this->belongsTo(PageModel::class, 'page_id', 'id');
    }
}