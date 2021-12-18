<?php

namespace Combindma\Richcms\Models;

use BenSampo\Enum\Traits\CastsEnums;
use Combindma\Richcms\Enums\Country;
use Combindma\Richcms\Traits\Bannable;
use Combindma\Richcms\Traits\UserTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use UserTrait;
    use Filterable;
    use HasRoles;
    use SoftDeletes;
    use Bannable;
    use CastsEnums;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
        'address',
        'city',
        'postcode',
        'country',
        'state',
        'meta' ,
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'provider_id',
        'provider',
        'active',
    ];

    protected $hidden = [
        'password', 'remember_token','deleted_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'meta' => 'array',
        'country' => Country::class,
    ];

    public function getRegisteredAtAttribute()
    {
        return $this->created_at->isoFormat('D MMMM YYYY');
    }
}
