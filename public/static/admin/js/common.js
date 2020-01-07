function singwaapp_save(form) {
     var data = $(form).serialize();
     var url = $(form).attr('url');
     $.post(url,data,function (res) {
       if(res.code == 0){
           layer.msg(result.msg,{icon:5,time:1000});
       }else if(res.code == 1){
          self.location = res.data.jump_url
       }
     },'JSON');
}

/***
 * 时间插件适配方法
 * **/
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
}

/***
 * 通用化删除
 * */
function article_del(obj){
    var url =$(obj).attr("del_url");
    layer.confirm('确认要删除吗？',function(index){
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(data){
                if(data.code == 1){
                    self.location = data.data.jump_url
                }else if(data.code == 0){
                    layer.msg(data.msg,{icon:2,time:2000});
                }
            },
            error:function(data) {
                console.log(data.msg);
            },
        });
    });
}

//****
// 状态
// /
function app_status(obj){
    var url =$(obj).attr("status-url");
    layer.confirm('确认要修改状态吗？',function(index){
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(data){
                if(data.code == 1){
                    self.location = data.data.jump_url
                }else if(data.code == 0){
                    layer.msg(data.msg,{icon:2,time:2000});
                }
            },
            error:function(data) {
                console.log(data.msg);
            },
        });
    });
}
