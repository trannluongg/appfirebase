<?php
/**
 * Created by PhpStorm.
 * User: TranLuong
 * Date: 10/09/2021
 * Time: 10:08
 */

namespace App\Http\Controllers;


use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FirebaseController extends Controller
{
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Note:
     * @param Request $request
     * @return mixed
     * User: TranLuong
     * Date: 10/09/2021
     */
    public function createOrUpdate(Request $request)
    {
        $response = $this->firebaseService->createOrUpdate($request);
        $statusCode = $response['status_code'] ?? 0;

        if(!in_array($statusCode, [Response::HTTP_OK, Response::HTTP_CREATED]))
        {
            return $this->responseSuccess();
        }

        return $this->responseError('');
    }
}