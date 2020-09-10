$(function(){
    //返回
    $('.ico-left').click(function(){
        try {
            JSBridge.invoke('toReturn');
        } catch(e) {
            document.write(e.description);
        }

    });
});


