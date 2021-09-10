<?php
/**
 * Created by PhpStorm.
 * User: TranLuong
 * Date: 26/07/2021
 * Time: 11:54
 */

namespace App\Traits;


trait FirebaseNotifyTrait
{
    public function pushNotifyToFirebase($fields = [])
    {
        $api_key = config('firebase.firebase_api_key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('firebase.firebase_url_send_notify'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}