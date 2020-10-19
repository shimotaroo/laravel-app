<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Phase;
use App\Prefecture;
use App\User;

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
    //引数の頭に?をつけるとnuulableにできる
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
    public function sortByselectedSortType($sort_type)
    {
        if ($sort_type === 'desc') {
            return $this->orderBy('created_at', 'desc');
        } elseif ($sort_type === 'asc') {
            return $this->orderBy('created_at', 'asc');
        } elseif ($sort_type === 'like_count') {
            return $this->withCount('likes')->orderBy('likes_count', 'desc');
        }
    }

    //絞り込み検索時にDBからデータを取得するqueryを作成
    public function makeQueryOfSearch($query, $prefecture_serch, $company_search, $phase_search)
    {
        if($prefecture_serch !== "0") {
            $query->where('prefecture_id', $prefecture_serch);
        }
        if($company_search  !== "0") {
            $query->where('company_type_id', $company_search );
        }
        if($phase_search !== "0") {
            $query->where('phase_id', $phase_search);
        }

        return $query;
    }

    //検索条件の内容を取得
    public function getSearchConditions($prefecture_search, $company_search, $phase_search)
    {
        if($prefecture_search !== "0") {
            $prefecture_search_condition = Prefecture::find($prefecture_search)->prefecture;
        } else {
            $prefecture_search_condition = '指定なし';
        }
        if($company_search  !== "0") {
            $company_search_condition = CompanyType::find($company_search)->company_type;
        } else {
            $company_search_condition = '指定なし';
        }
        if($phase_search !== "0") {
            $phase_search_condition = Phase::find($phase_search)->phase;
        } else {
            $phase_search_condition = '指定なし';
        }

        return [
            'prefecture' => $prefecture_search_condition,
            'company' => $company_search_condition,
            'phase' => $phase_search_condition,
        ];
    }
}
