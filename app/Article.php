<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Article extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 'slug', 'desc', 'content', 'cate_id', 'image', 'status'
    ];

    protected $casts = [
        'cate_id' => 'array'
    ];


    /**
     * Scope a query to article is public.
     *
     */
    public function scopePublic($query) {
        return $query->where('status', 'public');
    }

}
