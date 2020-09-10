define(['jquery','ajax','template','tools'],function ($,ajax,template,Tools){

    var httpRequest = function(element,options){

        var $more = $('#more'); // 下一页按钮

        this.element = element; // 放模板容器
        this.options = options; // 相关参数
        this.page = {
            pageNum:1,  // 当前第几页
            totalPage:null,  // 总页数
            total:null  // 总记录数
        };
        this.next = this.page.pageNum; // 下一页

        $('#'+this.element).html('<div class="loader"><div class="loader-inner ball-spin-fade-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

        this.getURL = function(params) {
            var queries = [];
            for (var key in  params) {
                if (key !== 'pageNum') {
                    queries.push(key + '=' + params[key]);
                }
            }
            queries.push('pageNum=');
            return this.options.url + '?' + queries.join('&');
        };

        /**
         * 对象初始化
         * @param callback
         */
        this.init = function(callback){
            this.URL = this.getURL(this.options);
            this.getPageRequest(this.page.pageNum,'init',callback);
        };

        /**
         * 分页请求
         * @param pageNum
         * @param type
         * @param callback
         */
        this.getPageRequest = function(pageNum, type , callback) {
            var _this = this;
            console.log(this.options.url + '?page='+ pageNum +'&pageSize=' + Tools.config.pageSize);
            ajax({
                headers: {
                    Authorization: "Bearer " + GV.token,
                    timeout : 5000
                }
            }).get(this.options.url + '?page='+ pageNum +'&pageSize=' + Tools.config.pageSize).then(function (response, xhr) {
                var result = Tools.handleResponse(response);
                console.log(result);

                if(result){
                    _this.page.totalPage = result.last_page;
                    var html = template(_this.options.tpl,result);

                    if(type === 'load'){
                        $('#'+_this.element).append(html);
                    }else{
                        $('#'+_this.element).html(html);
                    }

                    if(result.current_page < result.last_page){
                        $('#more').show();
                        $('#loadmore').show();
                    }else{
                        $('#more').hide();
                        $('#loadmore').hide();
                    }

                    if(typeof callback == 'function'){
                        // 执行回调函数
                        callback(result);
                    }
                }else{
                    // 接口无正确返回数据 todo
                }
            })
        };

        /**
         * get请求
         * @param callback
         * @param errCallback
         */
        this.getRequest = function(callback,errCallback){
            var _this = this;
            ajax({
                headers: {
                    Authorization: "Bearer " + GV.token,
                    timeout : 5000
                }
            }).get(this.options.url).then(function (response, xhr) {
                var result = Tools.handleResponse(response);
                console.log(result);

                if(result){
                    if(_this.options.tpl){
                        var html = template(_this.options.tpl,result);
                        $('#'+_this.element).html(html);
                    }

                    if(typeof callback == 'function'){
                        // 执行回调函数
                        callback(result);
                    }
                }else{
                    // 接口无正确返回数据 todo
                    if(typeof errCallback == 'function'){
                        // 执行回调函数
                        errCallback(result);
                    }
                }
            })
        };

        /**
         * post请求
         * @param postData
         * @param callback
         * @param errCallback
         */
        this.postRequest = function(postData,callback,errCallback){
            var _this = this;
            ajax({
                headers: {
                    'Content-Type': 'application/json'
                },
                dataType: 'json'
            }).post(this.options.url,JSON.stringify(postData)).then(function (response, xhr) {
                var result = Tools.handleResponse(response);

                if(result){
                    if(_this.options.tpl){
                        var html = template(_this.options.tpl,result);
                        $('#'+_this.element).html(html);
                    }

                    if(typeof callback == 'function'){
                        // 执行回调函数
                        callback(result);
                    }
                }else{
                    // 接口无正确返回数据 todo
                    if(typeof errCallback == 'function'){
                        // 执行回调函数
                        errCallback(result);
                    }
                }
            })
        };

        /**
         * 下拉加载
         * @param options
         * @param callback
         */
        this.pullDown = function(options,callback){
            if(options.element !== undefined){
                this.element = options.element;
            }
            if(options.tpl !== undefined){
                this.options.tpl = options.tpl;
            }
            if(this.next < this.page.totalPage){
                this.next += 1;
                this.getPageRequest(this.next,'load',callback);
            }
        }
    };

    return httpRequest;

});
