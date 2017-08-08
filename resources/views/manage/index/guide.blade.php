<title>{{$plugins_name}}</title>
<style>
    body{

    }
    li{
        line-height: 30px;
    }
    .big-bottom {
        margin-bottom: 2em;
    }
    li span {
        color: red;
    }
    a{
        color: green;
        font-size:18px;
        font-weight: 600;
        margin: 0 0.5em 0 0.5em;
    }
    i{
        color: green;
    }
</style>

<h1>laravel插件开发流程</h1>

<h3>目录</h3>
<ul>
    <li>config <span>//配置文件目录</span></li>
    <li>Controllers <span>//控制器目录</span></li>
    <li>Facades <span>//facade方法目录（可以省略）</span></li>
    <li>Model <span>//模型文件目录</span></li>
    <li>Providers <span>//注册服务目录</span></li>
    <li>Service <span>//业务逻辑目录</span></li>
    <li>views <span>//视图文件目录</span></li>
    <li>...自由扩展目录（除资源类目录<span>[例如：config、views文件夹]</span>外，文件夹名称采用大驼峰命令）</li>
</ul>

<h3>Larevel模型文件</h3>
<ul>
    <li>命令空间正确即可用</li>
    <li>使用模型参考laravel官方文档<a href="http://d.laravel-china.org/docs/5.4/eloquent">Eloquent</a>部分</li>
</ul>

<h3>启用关闭插件</h3>
<ul>
    <li>将插件下Providers目录中服务注册类注册到/config/app.php的providers数组下（例如本示例插件示例需添加： <span>App\Plugins\Example\Providers\ExampleProvider::class</span>）</li>
    <li>
        关闭插件时，将服务从/config/app.php的providers数组下删除即可
    </li>
</ul>

<h3>插件配置</h3>
<ul>
    <li>参考本插件下Providers\ExampleProvider.php的boot方法</li>
</ul>

<h3>命令空间</h3>
<ul>
    <li>命令空间必须严格遵守<a href="https://laravel-china.org/topics/2081/psr-specification-psr-4-automatic-loading-specification" target="_blank">PSR-4</a>自动加载规范</li>
    <li>命令空间可以从"Plugins\"开始，例如：
        <ul>
            <li>App\Plugins\Example\Controller 可以简写为 Plugins\Example\Controller</li>
        </ul>
    </li>
</ul>

<h3>外部访问插件方法</h3>
<ul>
    <li>
        例如调用插件下Service\IndexService下的方法:
        <ul>
            <li>1、依赖注入 <span>（强烈推荐使用）</span>
                <ul>
                    <li>以下是使用例子</li>
                    <pre>
use App\Plugins\Example\Service\IndexService;
function test(IndexService $index) {
    $index->dependency();
}
</pre>
                    <li class="big-bottom">代码执行结果：<i>{{ $dependency }}</i></li>
                </ul>
            </li>
            <li>2、使用容器注入：<span>（根据情况选择使用）</span></li>
            <ul>
                <li>在插件下Providers中服务注册类的register方法添加绑定（例子详见ExampleProvider.php）</li>
                <li>在全局使用laravel容器注入访问：app('index_service')->app()</li>
                <li class="big-bottom">执行结果:<i>{{ $app }}</i></li>
            </ul>
            <li>3、使用Facade方法<span>（在容器注入的基础上，根据情况选择使用）</span></li>
            <ul>
                <li>类的写法参照插件下Facades/Example.php</li>
                <li>将类注册到/config/app.php的aliases数组下：'Example' => App\Plugins\Example\Facades\Example::class</li>
                <li>在全局使用facade门面访问：Example::facade()</li>
                <li class="big-bottom">执行结果:<i>{{ $facade }}</i></li>
            </ul>
        </ul>
    </li>
</ul>

<h3>其他</h3>
<ul>
    <li>插件示例源码查看：<a href="https://github.com/tiayo/crm/tree/master/app/Plugins" target="_blank">https://github.com/tiayo/crm/tree/master/app/Plugins</a></li>
    <li>调用视图语法范例：view('example::index');</li>
    <li>读取配置文件语法示例：config('example.plugins_name')</li>
    <li>遵守
        <a href="https://laravel-china.org/topics/2078/psr-specification-psr-1-basic-coding-specification" target="_blank">PSR-1</a>、<a href="https://laravel-china.org/topics/2079/psr-specification-psr-2-coding-style-specification" target="_blank">PSR-2</a>编码规范，遵守<a href="https://zh.wikipedia.org/wiki/SOLID_(%E9%9D%A2%E5%90%91%E5%AF%B9%E8%B1%A1%E8%AE%BE%E8%AE%A1)" target="_blank">SOLID</a>基本原则</li>
</ul>