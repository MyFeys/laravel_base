@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">

        <div class="layui-col-md8">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">快捷方式</div>

                        <div class="layui-card-body">



                            <div class="layui-carousel layadmin-carousel layadmin-shortcut">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/index")}}">

                                                <i class="layui-icon layui-icon-console"></i>

                                                <cite>控制台</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/article")}}">

                                                <i class="layui-icon layui-icon-chart"></i>

                                                <cite>信息管理</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/category")}}">

                                                <i class="layui-icon layui-icon-template-1"></i>

                                                <cite>分类管理</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">
                                            <a lay-href="{{url("admin/message")}}">
                                                <i class="layui-icon layui-icon-chat"></i>
                                                <cite>消息管理</cite>
                                            </a>
                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/role")}}">

                                                <i class="layui-icon layui-icon-find-fill"></i>

                                                <cite>角色管理</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/mine/message")}}">

                                                <i class="layui-icon layui-icon-survey"></i>

                                                <cite>留言管理</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/user")}}">

                                                <i class="layui-icon layui-icon-user"></i>

                                                <cite>用户管理</cite>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs3">

                                            <a lay-href="{{url("admin/site")}}">

                                                <i class="layui-icon layui-icon-set"></i>

                                                <cite>系统设置</cite>

                                            </a>

                                        </li>

                                    </ul>

                                </div>

                            </div>



                        </div>

                    </div>

                </div>

                <div class="layui-col-md6">

                    <div class="layui-card">

                        <div class="layui-card-header">信息一览</div>

                        <div class="layui-card-body">

                            <div class="layui-carousel layadmin-carousel layadmin-backlog">

                                <div carousel-item>

                                    <ul class="layui-row layui-col-space10">

                                        <li class="layui-col-xs6">

                                            <a lay-href="{{url("admin/category")}}" class="layadmin-backlog-body">

                                                <h3>信息分类</h3>

                                                <p><cite>{{$categories}}</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="{{url("admin/article")}}" class="layadmin-backlog-body">

                                                <h3>已发布信息</h3>

                                                <p><cite>{{$articles}}</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a lay-href="{{url("admin/user")}}" class="layadmin-backlog-body">

                                                <h3>管理员</h3>

                                                <p><cite>1</cite></p>

                                            </a>

                                        </li>

                                        <li class="layui-col-xs6">

                                            <a href="javascript:;" onclick="layer.tips('测试', this, {tips: 3});" class="layadmin-backlog-body">

                                                <h3>广告数</h3>

                                                <p><cite>{{$adverts}}</cite></p>

                                            </a>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="layui-col-md12">



                    <div class="layui-card">

                        <div class="layui-tab layui-tab-brief layadmin-latestData">

                            <ul class="layui-tab-title">

                                <li class="layui-this">技术指南</li>

                                <li>帮助中心</li>

                            </ul>

                            <div class="layui-tab-content">

                                <div class="layui-tab-item layui-show">

                                    <table class="layui-table" >

                                        <colgroup>

                                            <col width="100">

                                            <col>

                                        </colgroup>

                                        <tbody>

                                        <tr>
                                            <td>当前版本</td>
                                            <td>
                                                <script type="text/html" template>
                                                    v1.0.0
                                                </script>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>基于框架</td>
                                            <td>
                                                <script type="text/html" template>
                                                    Laravel5.5 、  layui-v2.3.0
                                                </script>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>操作系统</td>
                                            <td>Linux centos 7.0</td>
                                        </tr>

                                        <tr>
                                            <td>数据库</td>
                                            <td>Mysql</td>
                                        </tr>


                                        <tr>
                                            <td>主要特色</td>
                                            <td> 响应式 / 清爽 / 极简</td>
                                        </tr>

                                        <tr>
                                            <td>备案网站</td>
                                            <td>http://beian.zzidc.com</td>
                                        </tr>

                                        <tr>
                                            <td>服务码</td>
                                            <td>E201901131216 口令：asd123456</td>
                                        </tr>

                                        </tbody>

                                    </table>

                                </div>

                                <div class="layui-tab-item">

                                    暂无信息

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="layui-col-md4">

            <div class="layui-card">

                <div class="layui-card-header">系统信息</div>

                <div class="layui-card-body layadmin-takerates">

                    <table class="layui-table" style="width: 95%; margin: 16px auto;">

                        <colgroup>

                            <col width="100">

                            <col>

                        </colgroup>

                        <tbody>

                        <tr>
                            <td>当前版本</td>
                            <td>
                                <script type="text/html" template>
                                    v1.0.0
                                </script>
                            </td>
                        </tr>

                        <tr>

                            <td>基于框架</td>
                            <td>

                                <script type="text/html" template>
                                  Laravel5.5 、  layui-v2.3.0
                                </script>
                            </td>

                        </tr>

                        <tr>

                            <td>操作系统</td>

                            <td>Linux centos 7.0</td>

                        </tr>

                        <tr>

                            <td>数据库</td>

                            <td>Mysql</td>

                        </tr>

                        </tbody>

                    </table>

                </div>

            </div>



            <div class="layui-card">

                <div class="layui-card-header">效果报告</div>

                <div class="layui-card-body layadmin-takerates">

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>转化率（日同比 28% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）</h3>

                        <div class="layui-progress-bar" lay-percent="65%"></div>

                    </div>

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>签到率（日同比 11% <span class="layui-edge layui-edge-bottom" lay-tips="下降" lay-offset="-15"></span>）</h3>

                        <div class="layui-progress-bar" lay-percent="32%"></div>

                    </div>

                </div>

            </div>



            <div class="layui-card">

                <div class="layui-card-header">实时监控</div>

                <div class="layui-card-body layadmin-takerates">

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>CPU使用率</h3>

                        <div class="layui-progress-bar" lay-percent="58%"></div>

                    </div>

                    <div class="layui-progress" lay-showPercent="yes">

                        <h3>内存占用率</h3>

                        <div class="layui-progress-bar layui-bg-red" lay-percent="90%"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'console']);
    </script>
@endsection