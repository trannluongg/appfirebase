<?php
/**
 * Created by PhpStorm.
 * User: TranLuong
 * Date: 19/07/2021
 * Time: 16:43
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FirebaseDeviceToken extends Model
{
    protected $table = 'firebase_device_tokens';
    protected $guarded = [];

    const TYPE_USER = 1;
}