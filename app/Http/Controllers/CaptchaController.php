<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    protected $captcha;
    protected $request;

    public function __construct(CaptchaBuilder $captcha, Request $request)
    {
        $this->captcha = $captcha;
        $this->request = $request;
    }

    /**
     * 生成并保存验证码到session
     *
     * @param $group //验证码保存分组(防止串页面)
     * @return string
     */
    public function captcha($group)
    {
        //可以设置图片宽高及字体
        $this->captcha->build($width = 150, $height = 40, $font = null);

        //保存验证码到session
        $this->request->session()->put($group.'_captcha', $this->captcha->getPhrase());

        //生成链接
        $this->captcha->output();
    }

    /**
     * 验证验证码方法（当确认用户当前状态只会在一个页面下产生验证码时使用）
     *
     * @param $code
     * @return bool
     */
    public function verify($code)
    {
        if ($code == $this->captcha->getPhrase()) {
            return true;
        }

        return false;
    }
}
