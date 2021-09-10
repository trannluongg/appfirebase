<?php
/**
 * Created by PhpStorm.
 * User: TranLuong
 * Date: 19/07/2021
 * Time: 16:48
 */

namespace App\Repository\FirebaseDeviceToken;


use App\Core\BaseRepository\EloquentRepository;
use App\Models\FirebaseDeviceToken;

class FirebaseDeviceTokenRepository extends EloquentRepository implements FirebaseDeviceTokenRepositoryInterface
{
    protected $model;

    public function __construct(FirebaseDeviceToken $model)
    {
        $this->model = $model;
    }
}