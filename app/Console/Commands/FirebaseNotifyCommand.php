<?php

namespace App\Console\Commands;

use App\Models\FirebaseDeviceToken;
use App\Traits\FirebaseNotifyTrait;
use Illuminate\Console\Command;

class FirebaseNotifyCommand extends Command
{
    use FirebaseNotifyTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Firebase Notify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firebase_devices = FirebaseDeviceToken::all();
        $array_device     = $this->__getDeviceToken($firebase_devices);
        if (count($array_device) > 0)
        {
            $body        = 'Có thông báo mới';
            $data_notify = [
                'title'        => "Thông báo",
                'body'         => $body,
                'click_action' => 'https://appfirebase.abc/dashboard'
            ];
            $body        = ['body' => $body];

            $fields = [
                'registration_ids' => $array_device,
                'notification'     => $data_notify,
                'data'             => $body,

            ];

            $response = $this->pushNotifyToFirebase($fields);
            dump($response);
        }
        return 0;
    }

    private function __getDeviceToken($firebase_devices): array
    {
        $array_device = [];
        if (count($firebase_devices) > 0)
        {
            foreach ($firebase_devices as $device)
            {
                $array_device[] = $device->fdt_token;
            }
        }
        return $array_device;
    }
}
