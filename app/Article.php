<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
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

}
