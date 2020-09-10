define(['jquery','layer','validate'],function ($,layer,validate){
    function disableBtn(btnText){
        var btn = $('form').find('button.mainBtn');
        btn.attr('disabled','disabled');
        btn.addClass('greyBtn');
        if(btnText) btn.text(btnText);
    }

    function enableBtn(btnText){
        var btn = $('form').find('button.mainBtn');
        btn.removeAttr('disabled');
        btn.removeClass('greyBtn');
        if(btnText) btn.text(btnText);
    }

    var AjaxForm = {

        submitForm : function(formId,callback){
            $('#' + formId).Validform({
                ajaxPost:true,
                tipSweep:true,
                ajaxpost:{
                    headers: {
                       //'Content-Type': 'application/json',
                        Authorization: "Bearer " + GV.token,
                        timeout : 5000
                    },
                },
                //postonce:true,
                tiptype:function(msg,o,cssctl){
                    if(!o.obj.is("form")){
                        var msgTip=o.obj.siblings(".msgTip");
                        if(o.type != 2){
                            cssctl(msgTip,o.type);
                            layer.msg(msg,{time:800});
                        }else{
                            cssctl(msgTip,2);
                            msgTip.text('');
                        }
                    }
                },
                beforeSubmit:function(form){
                    disableBtn();
                },
                datatype:{
                    "mobile" : /^1[34578]{1}\d{9}$/
                },
                callback:function(data){

                    if(typeof callback == 'function'){
                        enableBtn();
                        callback(data);
                        return;
                    }

                    if(data.status == 'success'){
                        if(data.referrer){
                            window.location.href = data.referrer;
                        }else{
                            layer.msg(data.msg,{time:800});
                            enableBtn();
                        }
                    }else if(data.status == 'fail'){
                        layer.msg(data.msg,{time:800});
                        enableBtn();
                    }
                }
            });
        }
    };

    return AjaxForm;
});