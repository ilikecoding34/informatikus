<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Post extends Model implements Viewable
{
    use HasFactory, InteractsWithViews;

    protected $fillable = ['user_id', 'updated_by_id', 'category_id', 'title', 'link', 'body', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag')->withTimestamps();
    }

    public function file()
    {
        return $this->hasOne(Document::class, 'postid');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
