<!--#include file="/include/config.asp"-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Calendar</title>
<style type="text/css">
#myCalendar{ margin:50px 100px;}
</style>
<link rel="stylesheet" href="calendar.css" type="text/css" />

</head>

<body>
<div id="myCalendar"></div>
<script type="text/javascript" src="ZK_Calendar.js"></script>
<script type="text/javascript">
	ZK_Calendar.init("myCalendar",{autoFull:true,
		onSelect:function(date){
			var weekArr = ["日","一","二","三","四","五","六"];
			var str = date.year + "年" + date.month + "月" + date.date + "日  星期" + weekArr[date.week];
			alert(str);  
		},
		logs:[{url:"http://www.oozk.net/learn/as/001/index.html",date:"2011/02/28"},
			{url:"http://www.oozk.net/Demo/ShopExHelp/main.swf",date:"2011/03/12"},
			{url:"http://www.oozk.net/learn/as/002/index.html",date:"2011/06/16"},
			{url:"http://www.oozk.net/learn/js/001/index.html",date:"2011/06/25"},
			{url:"http://www.oozk.net/flash/PV3D/pshow.swf",date:"2011/07/20"},
			{url:"http://www.oozk.net/flash/PV3D/photowall.swf",date:"2011/07/21"},
			{url:"http://www.oozk.net/flash/PV3D/OverTurn.swf",date:"2011/07/25"},
			{url:"http://www.oozk.net/flash/PV3D/TwistedFlip.swf",date:"2011/07/27"},
			{url:"http://www.oozk.net/flash/PV3D/View360.swf",date:"2011/07/28"},
			{url:"http://www.oozk.net/flash/PV3D/OuterSpace.swf",date:"2011/08/02"},
			{url:"http://www.oozk.net/flash/PV3D/",date:"2011/08/02"},
			{url:"http://www.oozk.net/learn/as/003/index.html",date:"2011/08/10"},
			{url:"http://www.oozk.net/test/jsas/JSLoader.html",date:"2011/09/22"},
			{url:"http://www.oozk.net/Demo/js/picsee/PicSee.html",date:"2011/11/16"},
			{url:"http://www.oozk.net/Demo/js/picsee2/PicSee2.html",date:"2011/12/02"},
			{url:"http://www.oozk.net/js/example/astyle.html",date:"2011/12/09"},
			{url:"http://www.oozk.net/learn/js/002/index.html",date:"2011/12/20"},
			{url:"http://www.oozk.net/learn/js/004/index.html",date:"2012/03/01"},
			{url:"http://www.oozk.net/learn/css/001/index.html",date:"2012/03/26"},
			{url:"http://www.oozk.net/learn/as/004/index.html",date:"2012/04/18"},
			{url:"http://www.oozk.net/learn/as/005/index.html",date:"2012/04/23"},
			{url:"http://www.oozk.net/learn/js/003/index.html",date:"2012/05/07"},
			{url:"http://www.oozk.net/learn/js/005/index.html",date:"2012/05/08"},
			{url:"http://www.oozk.net/learn/js/006/index.html",date:"2012/05/10"},
			{url:"http://www.oozk.net/learn/js/007/index.html",date:"2012/06/01"},
			{url:"http://www.oozk.net/learn/js/008/index.html",date:"2012/06/07"}]
	});
</script>
</body>
</html>

