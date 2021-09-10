<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseError($message = 'Có lỗi xảy ra, vui lòng thử lại')
    {
        return [
            'error'   => 1,
            'message' => $message
        ];
    }

    public function responseSuccess($message = 'Thành công', $data = [])
    {
        return [
            'error'   => 0,
            'message' => $message,
            'data'    => $data,
        ];
    }

    public function responseUpdateSuccess($title = '')
    {
        return [
            'error'   => 0,
            'message' => 'Cập nhật thành công ' . $title
        ];
    }
}
