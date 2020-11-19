@extends('admin.layout.base')

@section('content')
    <fieldset class="main-field main-field-title">
        <legend>编辑商品</legend>
    </fieldset>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form class="form-horizontal J_ajaxForm" style="margin:10px 20px;" role="form" id="form" action="{{url('admin/goods',array($data->id))}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商品名称</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" autocomplete="off" class="form-control" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商品分类</label>
                            <div class="col-sm-8">
                                <select name="category_id" class="form-control">
                                    <option value="0">请选择分类</option>
                                    @if($category)
                                        @foreach($category as $v)
                                            <option value="{{$v['id']}}" @if($v['id'] == $data->id) selected @endif>{{$v['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span class="red">*</span>店铺封面</label>
                            <div class="col-sm-8">
                                <div class="J_upload_image" data-id="image" data-_token="{{ csrf_token() }}">
                                    @if(!empty($data->image))
                                        <input type="hidden" name="image_val" value="{{ $data->image }}">
                                        <input type="hidden" name="image_path[]" value="{{ $data->image }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-8"><span class="tips">建议尺寸</span></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商品原价</label>
                            <div class="col-sm-8">
                                <input type="text" name="old_price" autocomplete="off" class="form-control" value="{{$data->old_price}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商品价格</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" autocomplete="off" class="form-control" value="{{$data->price}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort" class="col-sm-3 control-label">商品描述</label>
                            <div class="col-sm-8">
                                <textarea name="describe" class="form-control" cols="50" rows="5">{{$data->describe}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">排序</label>
                            <div class="col-sm-8">
                                <input type="text" name="sort" autocomplete="off" class="form-control" value="{{$data->sort}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-8">
                                {{\App\Enums\BoolEnum::enumRadio($data->is_recommend,false,'is_recommend')}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">状态</label>
                            <div class="col-sm-8">
                                {{\App\Enums\GoodsEnum::enumSelect($data->status,false,'status')}}
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-xs-2 col-md-1 col-sm-offset-3">
                                @can('goods.update')
                                    <button type="submit" class="btn btn-primary J_ajax_submit_btn">提交</button>
                                @endcan
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="{{url('admin/goods')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


