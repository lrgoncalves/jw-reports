<?php

namespace App\Models\Bob;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $connection = 'bob';

    protected $casts = [
				'publisher_id' => 'int',
				'active' => 'bool'
		];

		protected $fillable = [
				'publisher_id',
				'publisher_category_id',
				'news_category_id',
				'publisher_code',
				'title',
				'subtitle',
				'content',
				'author',
				'date',
				'thumb',
				'featured'
		];

		protected $hidden = ['created_at', 'updated_at', 'active'];
}
