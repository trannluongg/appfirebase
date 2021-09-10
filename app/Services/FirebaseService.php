<?php
/**
 * Created by PhpStorm.
 * User: TranLuong
 * Date: 19/07/2021
 * Time: 16:55
 */

namespace App\Services;


use App\Models\FirebaseDeviceToken;
use App\Repository\FirebaseDeviceToken\FirebaseDeviceTokenRepositoryInterface;
use Illuminate\Http\Request;

class FirebaseService
{
    private $firebaseDeviceTokenRepository;

    public function __construct(FirebaseDeviceTokenRepositoryInterface $firebaseDeviceTokenRepository)
    {
        $this->firebaseDeviceTokenRepository = $firebaseDeviceTokenRepository;
    }

    /**
     * Note:
     * @param Request $request
     * @return bool
     * User: TranLuong
     * Date: 19/07/2021
     */
    public function createOrUpdate(Request $request): bool
    {
        $token     = $request->get('token');
        $agent     = json_encode(get_agent());
        $old_token = $request->get('old_token') ?? null;
        $data      = [
            'fdt_token' => $token,
            'fdt_agent' => $agent,
        ];

        $user_id             = get_id_by_user('web');
        $data['fdt_user_id'] = $user_id;
        $data['fdt_type']    = FirebaseDeviceToken::TYPE_USER;

        if ($old_token)
        {
            $filter = [
                'where' => [['fdt_token', '=', $old_token]]
            ];
        }
        else
        {
            $filter = [
                'where' => [['fdt_token', '=', $token]]
            ];
        }
        $oldToken = $this->firebaseDeviceTokenRepository->first($filter);
        if ($oldToken)
        {
            $this->firebaseDeviceTokenRepository->updateById($oldToken->id, $data);
            return true;
        }

        $this->firebaseDeviceTokenRepository->create($data);
        return true;
    }
}