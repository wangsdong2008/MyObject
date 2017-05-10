//验证是否为空,如果为空返回 false,否则返回 true 


function CheckIsNull(Inform, Inputname) {
    var Form = Inform + "."
    eval("Temp=" + Form + Inputname + ".value;");
    if (Temp == "") {
        alert("提醒您:不能为空");
        eval(Form + Inputname + ".focus();");
        return false;
    } else {
        eval(Form + Inputname + ".className=" + Form + Inputname + ".className.replace('RedInput','');");
        return true;
    }
}
//验证是否为数字 


function CheckIsNum(Inform, Inputname) {
    if (!CheckIsNull(Inform, Inputname)) return false;
    else {
        var Form = Inform + "."
        eval("Temp=" + Form + Inputname + ".value;");
        if (isNaN(Temp)) {
            alert("提醒您:不为数字");
            eval(Form + Inputname + ".className='RedInput';");
            eval(Form + Inputname + ".focus();");
            return false;
        } else {
            eval(Form + Inputname + ".className=" + Form + Inputname + ".className.replace('RedInput','');");
            return true;
        }
    }
}
//验证是否为E-MAIL 


function CheckIsEmail(Inform, Inputname) {
    if (!CheckIsNull(Inform, Inputname)) return false;
    else {
        var Form = Inform + "."
        eval("Temp=" + Form + Inputname + ".value;");
        if (Temp.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1) {
            alert("提醒您:不为EMAIL");
            // eval(Form+Inputname+".className='RedInput';"); 
            eval(Form + Inputname + ".focus();");
            return false;
        } else {
            //eval(Form+Inputname+".className="+Form+Inputname+".className.replace('RedInput','');"); 
            return true;
        }
    }
}
//验证是否为HTTP地址 


function CheckIsHttp(Inform, Inputname) {
    if (!CheckIsNull(Inform, Inputname)) return false;
    else {
        var Form = Inform + "."
        eval("Temp=" + Form + Inputname + ".value;");
        if (Temp.search(/^http:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/) == -1) {
            alert("提醒您:不为HTTP");
            eval(Form + Inputname + ".className='RedInput';");
            eval(Form + Inputname + ".focus();");
            return false;
        } else {
            eval(Form + Inputname + ".className=" + Form + Inputname + ".className.replace('RedInput','');");
            return true;
        }
    }
}
//验证是否为手机号码 


function CheckIsMobile(Inform, Inputname) {
    if (!CheckIsNull(Inform, Inputname)) return false;
    else {
        var Form = Inform + "."
        eval("Temp=" + Form + Inputname + ".value;");
        if (Temp.search(/^1[3|5]\d{9}$/) == -1) {
            alert("提醒您:不为手机号码");
            eval(Form + Inputname + ".className='RedInput';");
            eval(Form + Inputname + ".focus();");
            return false;
        } else {
            eval(Form + Inputname + ".className=" + Form + Inputname + ".className.replace('RedInput','');");
            return true;
        }
    }
}

function CheckAll(a) {
    o = document.getElementsByName(a)
    for (i = 0; i < o.length; i++)
    o[i].checked = event.srcElement.checked
}

function delid(id) {
    if (confirm("确定要删除吗?")) location.href = '?act=del&d=' + id;
}

function fdel(ch, str) {
    if (f2(ch, "确定要" + ch + "吗？", str)) return true;
    return false;
}

function f(text, t1) {
    var dnum = document.getElementsByName("d").length;
    j = 0;
    if (dnum == 1) {
        if (document.form1.d.checked == true) {
            j++;
        }
    } else {
        for (i = 0; i < dnum; i++) {
            if (document.form1.d[i].checked == true) {
                j++;
            }
        }
    }
    if (j == 0) {
        alert('请选择你要' + text + '的文章');
        return false;
    } else {
        if (!confirm(t1)) return false;
    }
    return true;
}

function f2(text, t1, name) {
    var dnum = document.getElementsByName("d").length;
    j = 0;
    if (dnum == 1) {
        if (document.form1.d.checked == true) {
            j++;
        }
    } else {
        for (i = 0; i < dnum; i++) {
            if (document.form1.d[i].checked == true) {
                j++;
            }
        }
    }
    if (j == 0) {
        alert('请选择你要' + text + '的' + name);
        return false;
    } else {
        if (!confirm(t1)) {
            return false;
        } else {
            return true;
        }
    }
    return true;
}

var searchReq = createAjaxObj();

function createAjaxObj() {
    var httprequest = false;
    if (window.XMLHttpRequest) {
        httprequest = new XMLHttpRequest();
        if (httprequest.overrideMimeType) httprequest.overrideMimeType('text/xml');
    } else if (window.ActiveXObject) {
        //IE
        try {
            httprequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httprequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }
    return httprequest
}

function fp(str) {
    for (i = 0; i < document.form1.page.length; i++) {
        if (document.form1.page.options[i].selected == true) {
            //location.href="?page="+(i+1)+str;	 
            document.form1.action = "?page=" + (i + 1) + str;
            document.form1.submit();
            break;
        }
    }
}

function SelectColor(sEL, form) {
    var dEL = document.all(sEL);
    //    var url = 'color.html?'+encodeURIComponent(sEL);
    var url = '../js/color.html';
    var arr = showModalDialog(url, window, 'dialogWidth:280px;dialogHeight:250px;help:no;scroll:no;status:no');
    //var arr=window.open(url);
    if (arr) {
        form.value = arr;
        //sEL.style.backgroundColor=arr;
    }
}

//下拉框


function CheckIsSelect(Inform, Inputname) {
    var Form = Inform + ".";
    str = "Temp=" + Form + Inputname + "[0].selected";
    eval(str);

    if (Temp == true) {
        alert("提醒您:请选择此项！");
        eval(Form + Inputname + ".focus()");
        return false;
    } else {
        return true;
    }
}