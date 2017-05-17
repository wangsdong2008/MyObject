$(function(){
    $("#searchform").submit(function(){
        if($("#keyword").val().trim() == ""){
            alert('请输入要查询的内容'); return false;
        }
    })
    $("#test2_li_now>li").each(function(index){
        $(this).click(function(){
            $(this).addClass("now").siblings().removeClass("now");
            $("#searchtype").val(index*1+1);
        });
    })
})/**
 * Created by admin on 2017/5/17.
 */
