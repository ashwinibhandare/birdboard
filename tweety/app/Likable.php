<?php
namespace App;

use Illuminate\Database\Eloquent\Builder;

trait Likable
{
    public function scopeWithLikes(Builder $query)
    {
        //SELECT * FROM `tweets` LEFT JOIN (SELECT tweet_id, SUM(liked) likes, SUM(liked) dislike FROM likes GROUP BY tweet_id) likes ON likes.tweet_id = tweets.id
        $query->leftJoinSub('SELECT tweet_id, SUM(liked) likes, SUM(liked) dislike FROM likes GROUP BY tweet_id',
            'likes','likes.tweet_id','tweets.id');
    }
    public function like($user = null, $liked = true)
    {
        return $this->likes()->updateOrCreate(
            [
                'user_id' => $user ? $user->id : auth()->id()
            ],
            [
                'liked' => $liked
            ]);
    }

    public function isLikedBy(User $user)
    {
        return (bool) $user->likes->where('tweet_id', $this->id)->where('liked', true)->count();
    }
    public function isdislikedBy(User $user)
    {
        return (bool) $user->likes->where('tweet_id', $this->id)->where('liked', false)->count();
    }
    public function dislike($user = null)
    {
        return $this->like($user,false);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
