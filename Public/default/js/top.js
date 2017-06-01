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
    $("#Favorite").click(function () {
        id = $("#Favorite").attr("rel");
        token = $("#token").val();
        $.get("/User/addFavorite.html",{id:id,token:token,t:Math.random()},function(data){
            data = data*1;
            switch(data){
                case 0:{
                    alert('请登录');
                    break;
                }
                case 1:{
                    alert('很抱歉，加入失败');
                    break;
                }
                case 2:{
                    alert('此文章已经存在，不用再次收藏');
                    break;
                }
                case 3:{
                    alert('收藏成功，请在会员中心查看');
                    break;
                }
            }
        })
    })
})
