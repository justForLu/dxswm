define(['jquery','layer'],function ($,layer){
    var Tools = {
        config : {
            pageSize:10     // 前端分页数
        },

        /**
         * ajax请求响应码
         */
        responseCode : {
            'success' : 200
        },

        /**
         * 请求响应处理函数
         * @param response
         * @returns {*}
         */
        handleResponse : function(response){
            if(response && typeof response == "object"){

                if(response.status){
                    switch(response.status){
                        case 'success':
                            if(response.data){
                                return response.data;
                            }else{
                                return true;
                            }
                            break;
                        case 'fail':
                            layer.msg(response.msg,{time:1000});
                                return false;
                            break;
                        default :
                            return false;
                    }
                }else{
                    console.log('响应出错');
                    return false;
                }
            }else{
                console.log('请求出错');
                return false;
            }
        },

        /**
         * 查询字符串获取函数
         * @param name
         * @returns {null}
         */
        getQueryString : function(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }
    };

    return Tools;
});