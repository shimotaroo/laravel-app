<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'prefecture_id',
        'company_type_id',
        'phase_id',
        'question_content',
        'other_information',
        'impression',
    ];

    //Usersモデルへのリレーション追加
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo('App\Prefecture');
    }

    public function companyType(): BelongsTo
    {
        return $this->belongsTo('App\CompanyType');
    }

    public function phase(): BelongsTo
    {
        return $this->belongsTo('App\Phase');
    }

    //「いいね」におけるArticleとUserの関係は多対多
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    //ユーザーがいいね済みかどうかを判定するメソッド
    public function isLikedByUser(?User $user): bool
    {
        //->likeでArticleモデルからlikesテーブルに紐づくUserモデルがコレクションで返る
        return $user ? (bool)$this->likes->where('id', $user->id)->count() : false;
    }

    //現在のいいね数を算出するメソッド
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    //記事一覧ページで並び替え処理
    public function sortByselectedSortType($sortType)
    {
        if ($sortType === 'desc') {
            return $this->orderBy('created_at', 'desc');
        } elseif ($sortType === 'asc') {
            return $this->orderBy('created_at', 'asc');
        } elseif ($sortType === 'like_count') {
            return $this->withCount('likes')->orderBy('likes_count', 'desc');
        }
    }
}
