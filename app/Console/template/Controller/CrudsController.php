<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class retasl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tag.index');
    }

    public function data(Request $request)
    {
        //搜索
        $res = $request->only([controsofield]);
        if (!empty($res)){
            $model = '';
            controsoiffield;
            if(!empty($model)){
                $res = $model->paginate($request->get('limit',30))
                             ->toArray();
            }else{
                $res = Tag::orderBy('id','desc')
                          ->paginate($request->get('limit',30))
                          ->toArray();
            }
        }else{
            //数据查询
            $res = Tag::orderBy('id','desc')
                      ->paginate($request->get('limit',30))
                      ->toArray();
        }
        $dataarray = [];
        foreach ($res['data'] as $key => $val){
            $dataarray[$key] = $val;
            if (isset($val['datetime'])){
                $dataarray[$key]['datetime'] = date('Y-m-d H:i:s',$val['datetime']);
            }
            if (isset($val['timestamp'])){
                $dataarray[$key]['timestamp'] = date('Y-m-d H:i:s',$val['timestamp']);
            }
            if (isset($val['createtime'])){
                $dataarray[$key]['createtime'] = date('Y-m-d H:i:s',$val['createtime']);
            }
            if (isset($val['updatetime'])){
                $dataarray[$key]['updatetime'] = date('Y-m-d H:i:s',$val['updatetime']);
            }
        }
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $dataarray
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,strvalidate);
        $data = $request->all();
        if (isset($data['datetime'])){
            if (!is_numeric($data['datetime'])){
                $data['datetime'] = strtotime($data['datetime']);
            }
        }
        if (isset($data['timestamp'])){
            if (!is_numeric($data['timestamp'])){
                $data['timestamp'] = strtotime($data['timestamp']);
            }
        }
        if (isset($data['createtime'])){
            if (!is_numeric($data['createtime'])){
                $data['createtime'] = strtotime($data['createtime']);
            }
        }
        if (isset($data['updatetime'])){
            if (!is_numeric($data['updatetime'])){
                $data['updatetime'] = strtotime($data['updatetime']);
            }
        }
        if (Tag::create($data)){
            return redirect(route('admin.tag'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.tag'))->with(['status'=>'系统错误']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,strvalidate);
        $tag = Tag::findOrFail($id);
        $data = $request->only(fieldarray);
        if (isset($data['time'])){
            if (!is_numeric($data['time'])){
                $data['time'] = strtotime($data['time']);
            }
        }
        if (isset($data['date'])){
            if (!is_numeric($data['date'])){
                $data['date'] = strtotime($data['date']);
            }
        }
        if (isset($data['datetime'])){
            if (!is_numeric($data['datetime'])){
                $data['datetime'] = strtotime($data['datetime']);
            }
        }
        if (isset($data['timestamp'])){
            if (!is_numeric($data['timestamp'])){
                $data['timestamp'] = strtotime($data['timestamp']);
            }
        }
        if (isset($data['createtime'])){
            if (!is_numeric($data['createtime'])){
                $data['createtime'] = strtotime($data['createtime']);
            }
        }
        if (isset($data['updatetime'])){
            if (!is_numeric($data['updatetime'])){
                $data['updatetime'] = strtotime($data['updatetime']);
            }
        }
        if ($tag->update($data)){
            return redirect(route('admin.tag'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.tag'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (Tag::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


}
