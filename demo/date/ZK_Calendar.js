var _Ctrl = {
	$:function(id){
		return document.getElementById(id);
	},
	addEvent:function(obj,type,fn){
		if(obj.addEventListener){
			obj.addEventListener(type,fn,false);	
		}else if(obj.attachEvent){
			obj.attachEvent("on"+type,fn);
		}
	}
}
var ZK_Calendar = {
	/*日历模板*/
	template:[
		"<div class='cal_container'>",
			"<dl>",
				"<dt class='cal_top'><a class='l-arrow'><</a><span></span><a class='r-arrow'>></a></dt>",
				"<dt><strong>日</strong></dt>",
				"<dt>一</dt>",
				"<dt>二</dt>",
				"<dt>三</dt>",
				"<dt>四</dt>",
				"<dt>五</dt>",
				"<dt><strong>六</string></dt>",
				"<dd></dd>",
			"</dl>",
		"</div>"
	].join(""),
	/*日历容器*/
	container:null,
	/*当前选择的年份*/
	cYear:1900,
	/*当前选择的月份*/
	cMonth:1,
	init:function(id,config){
		/*参数设置*/
		if(config){
			/*是否开启空白区域自动日期填充*/
			this.autoFull = config.autoFull || false;
			
			/*绑定当前选择项事件*/
			this.onSelect = config.onSelect || null;
			
			/*绑定日志事件*/
			this.logs = config.logs || [];
		}
		/*获取容器*/
		this.container = _Ctrl.$(id);
		
		this.createCalendar();
	},
	createCalendar:function(){
		var cal_div = document.createElement("div");
		cal_div.className = "zk_container";
		cal_div.style.clear = "both";
		cal_div.style.overflow = "hidden";
		cal_div.innerHTML = this.template;
		this.container.appendChild(cal_div);
		
		/*初始今天日期*/
		var cDate = new Date();
		this.cYear = cDate.getFullYear();
		this.cMonth = cDate.getMonth() + 1;
		this.updataCalendar();
		
		this.initMouseEvent();
	},
	updataCalendar:function(){
		var dt = this.container.getElementsByTagName("dt")[0].getElementsByTagName("span")[0];
		var dd = this.container.getElementsByTagName("dd")[0];
		dt.innerHTML = this.cYear + "年" + this.cMonth + "月";
		
		dd.innerHTML = "";
		dd.appendChild(this.drawDate());
	},
	drawDate:function(){
		var that = this,
			md = this.getMonthtoDays(this.cYear, this.cMonth),
			days = md.days,
			firstDay = md.firstDay,
			len = md.len,
			arr = md.arr,
			lastArr = [],
			fragment = document.createDocumentFragment(),
			i = 0,
			cut = false,
			lArr = [],
			nArr = [],
			ct = new Date(),
			cstyle = "";
		
		for(i=0;i<len;i++){
			var value = arr.shift();
			var a = document.createElement("a");
			if(!value){
				a.className = "disabled";
				a.innerHTML = "&nbsp;";
				cut ? nArr.push(a):lArr.push(a);
			}else{
				cut = true;
				a.innerHTML = value;
				
				/*鼠标经过改变样式*/
				_Ctrl.addEvent(a,"mouseover",function(e){
					cstyle = that.target(e).className;
					that.target(e).className = "mouseover";
				})
				_Ctrl.addEvent(a,"mouseout",function(e){
					that.target(e).className = cstyle;
				})
				/*特殊日期样式定义******/
				//today
				if(value == ct.getDate() && that.cYear == ct.getFullYear() && that.cMonth == (ct.getMonth()+1)){
					a.className = "today";
				}
				/*绑定日志事件*/
				var logArr = that.logs;
				if(logArr){
					for(var o=0;o<logArr.length;o++){
						var oy = that.resolveDate(logArr[o].date).y;
						var om = that.resolveDate(logArr[o].date).m;
						var od = that.resolveDate(logArr[o].date).d;
						if(value == od && that.cYear == oy && that.cMonth == om){
							a.className = "log";
							a.href = logArr[o].url; 
							a.target = "_blank";
						}
					}
				}
				
				/*绑定当前选择项事件*/
				if(that.onSelect != null){
					_Ctrl.addEvent(a,"click",function(e){
						var today = that.target(e).innerHTML;
						var date = {year:that.cYear,month:that.cMonth,date:today,week:that.getWeek(today,firstDay)};
						that.onSelect(date);
					})
				}
			}
			fragment.appendChild(a);
		}
		
		/*是否开启空白区域自动日期填充*/
		if(this.autoFull){
			/*获取上一个月的日历数据*/
			var lastMonthDate = this.getLastMonth(this.cYear,this.cMonth);
			lastArr = this.getMonthtoDays(lastMonthDate.year,lastMonthDate.month).arr;
			lastArr.splice(0,lastArr.length-lArr.length)
			if(lArr.length){
				for(i=0;i<lArr.length;i++){
					lArr[i].innerHTML = lastArr[i];
				}
			}
			/*下个月数据直接从1号开始填充*/
			if(nArr.length){
				for(i=0;i<nArr.length;i++){
					nArr[i].innerHTML = i+1;
				}	
			}
		}
		
		return fragment;
	},
	getMonthtoDays:function(y,m){
		var days = new Date(y, m, 0).getDate(),
			firstDay = new Date(y, m - 1, 1).getDay(),
			arr = [],
			i = 0,
			len = Math.ceil((days+firstDay)/7) * 7;
			
		for(i = firstDay; i--;) arr.push(0);
		for(i = 1; i <= days; i++) arr.push(i);
		
		return {days:days,firstDay:firstDay,len:len,arr:arr};
	},
	initMouseEvent:function(){
		var that = this,
			aLeft = that.container.getElementsByTagName("dt")[0].getElementsByTagName("a")[0],
			aRigth = that.container.getElementsByTagName("dt")[0].getElementsByTagName("a")[1];
			
		_Ctrl.addEvent(aLeft,"click",function(){
			var date = that.getLastMonth(that.cYear,that.cMonth);
			that.cYear = date.year;
			that.cMonth = date.month;
			that.updataCalendar();
		})
		_Ctrl.addEvent(aRigth,"click",function(){
			var date = that.getNextMonth(that.cYear,that.cMonth);
			that.cYear = date.year;
			that.cMonth = date.month;
			that.updataCalendar();
		})
	},
	getLastMonth:function(y,m){
		m--;
		if(m < 1){
			m = 12;
			y--;
		}
		return {year:y,month:m};
	},
	getNextMonth:function(y,m){
		m++;
		if(m > 12){
			m = 1;
			y++;
		}	
		return {year:y,month:m};
	},
	/*获取星期几*/
	getWeek:function(date,fd){
		var c = (date-1)%7 + fd;
		var w = c < 7 ? c : c % 7;
		return w;
	},
	/*解析日期*/
	resolveDate:function(date){
		var str = date.indexOf("-") != -1 ? "-":"/";
		var arr = date.split(str);
		return {y:arr[0],m:arr[1],d:arr[2]};
	},
	/*兼容IE获取当前鼠标事件对象*/
	target:function(e){
		var e = e || window.event;
		var target = e.target || e.srcElement;
		return target;	
	}
}


