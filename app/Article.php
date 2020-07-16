<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

}
