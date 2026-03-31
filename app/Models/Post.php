<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public const TYPE_PRODUCT = 'product';
    public const TYPE_NEWS = 'news';

    protected $fillable = [
        'type',
        'category_id',
        'title',
        'slug',
        'seo_title',
        'seo_description',
        'summary',
        'content',
        'address',
        'area',
        'area_from',
        'area_to',
        'floor_count',
        'floor_count_from',
        'floor_count_to',
        'unit_count',
        'unit_count_from',
        'unit_count_to',
        'bedroom_count',
        'bedroom_count_from',
        'bedroom_count_to',
        'bathroom_count',
        'bathroom_count_from',
        'bathroom_count_to',
        'image',
        'price',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'area' => 'decimal:2',
        'area_from' => 'decimal:2',
        'area_to' => 'decimal:2',
        'price' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    public static function types(): array
    {
        return [
            self::TYPE_PRODUCT => 'Product',
            self::TYPE_NEWS => 'News',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(PostImage::class)->orderBy('sort_order')->orderBy('id');
    }
}
