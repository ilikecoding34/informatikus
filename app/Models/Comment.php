<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\NotifyMail;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'post_id', 'user_id'];

    public static function boot()
    {
        parent::boot();

        self::created(function($comment){
            Mail::to('fejdav@gmail.com')->send(new NotifyMail($comment, 'comment'));
        });
    }

        /**
         * Get the user that owns the Comment
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function post()
        {
            return $this->belongsTo(Post::class, 'post_id');
        }

}
