<?php

namespace ExpoHub;

use Illuminate\Database\Eloquent\Model;

/**
 * ExpoHub\ApiToken
 *
 * @property integer $id
 * @property string $name
 * @property string $app_id
 * @property string $app_secret
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\ApiToken whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\ApiToken whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\ApiToken whereAppId($value)
 * @method static \Illuminate\Database\Query\Builder|\ExpoHub\ApiToken whereAppSecret($value)
 * @mixin \Eloquent
 */
class ApiToken extends Model
{
    protected $fillable = ['name', 'app_id', 'app_secret'];
}
