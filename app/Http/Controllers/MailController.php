<?php

namespace App\Http\Controllers;

use App\Mail\PublicShipped;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function __construct()
    {

    }

    /**
     * 测试邮件发送方法
     *
     */
    public function test()
    {
        $data = [
            'view' => 'test',
            'subject' => '测试标题_subject',
            'assign' => [
                'title' => '测试标题',
            ],
            'queue_name' => 'emails',
            'attach' => base_path().'/public/style/media/image/logo.png'
        ];

        $when = Carbon::now()->addSecond(0);

        MailSend(Auth::guard('manager')->user(), $data, $when);
    }

    /**
     * 邮件发送调度方法
     *
     * @param $user
     * @param $data
     */
    static  public function email($user, $data, $when = null)
    {
        $when = empty($when) ? Carbon::now() : $when;

        Mail::to($user)->later($when, new PublicShipped($data));
    }
}