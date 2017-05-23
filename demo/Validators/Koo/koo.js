/*

 KooTeam Form Validate By Tag v1.0.5
 http://kooteam.com
 E-Mail:sinbo@jabinfo.com

 Copyright (c) 2012 Sinbo
 Dual licensed under the MIT and GPL licenses, located in
 MIT-LICENSE.txt and GPL-LICENSE.txt respectively.

 Date: Mon June 11 22:40:40 2012 -0800

*/
(function () {
    $.fn.Koo = function (callback) {
        var hashspan = new Object();
        function validateField(field, temp) {
            var error = false;
            var msg = '';
            var val = $(field).val();
            for (i = 1; i < temp.length; i++) {
                tp_flag = temp[i];
                if (temp[i].charAt(0) == '!') {
                    if (val == '') {
                        error = false;
                        continue;
                    }
                    tp_flag = temp[i].substr(1, temp[i].length - 1);
                }
                var ime = false;
                switch (tp_flag) {
                    case 'need':
                        if ($.trim(val) != val) {
                            val = $.trim(val);
                            $(field).val(val);
                        }
                        if (val == '') {
                            error = true;
                            msg = '\u4e0d\u80fd\u4e3a\u7a7a';
                        }
                        break;
                    case 'digit':
                        if (!/^[0-9]\d*$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u6570\u5b57';
                        }
                        ime = true;
                        break;
                    case 'chinese':
                        if (val == '' || !/^[\u4e00-\u9fff]*$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u6c49\u5b57';
                        }
                        break;
                    case 'money':
                        if (!/^\d+(\.\d{1,2})?$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u91d1\u989d';
                        }
                        ime = true;
                        break;
                    case 'card':
                        if (!/^\d{15}|\d{18}$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u8eab\u4efd\u8bc1\u53f7';
                        }
                        ime = true;
                        break;
                    case 'zip':
                        if (!/^[0-9]\d{5}(?!\d)$/.test(val)) {
                            error = true;
                            msg = '\u90ae\u7f16\u9519\u8bef';
                        }
                        ime = true;
                        break;
                    case 'float':
                        if (!/^(-|\+)?\d+(\.\d+)?$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u6570\u5b57';
                        }
                        ime = true;
                        break;
                    case 'tel':
                        if (!/^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$|^\d{11}$|^\d{10}$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u7535\u8bdd\u53f7\u7801';
                        }
                        ime = true;
                        break;
                    case 'mobile':
                        if (!/^(\+?86)?(13[0-9]|15[0-9]|18[0-9])\d{8}$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u624b\u673a\u53f7\u7801';
                        }
                        ime = true;
                        break;
                    case 'char':
                        if (val=='' || !/^[a-z\_\-A-Z]*$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u82f1\u6587\u5b57\u7b26';
                        }
                        ime = true;
                        break;
                    case 'date':
                        if (val != '' && !/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u65e5\u671f\u683c\u5f0f';
                        }
                        ime = true;
                        break;
                    case 'mail':
                        if (!/^[a-zA-Z0-9]+(\.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+){1,3}$/.test(val)) {
                            error = true;
                            msg = '\u8bf7\u8f93\u5165\u90ae\u7bb1\u5730\u5740';
                        }
                        ime = true;
                        break;
                    default:
                        sinbo_id09323 = tp_flag.substr(1, tp_flag.length - 1).replace('$', '-');
                        switch (tp_flag.charAt(0)) {
                            case 'l'://长度必须等于多少
                                var st0911 = parseInt(tp_flag.substr(1));
                                if (val == '' || val.length != st0911) {
                                    error = true;
                                    msg = '\u957f\u5ea6\u5fc5\u987b\u7b49\u4e8e' + st0911 + '\u4f4d';
                                }
                                break;
                            case 's'://必须小于
                                var st0921 = parseInt(tp_flag.substr(1));
                                if (val == '' || !/^-?([1-9]\d*\.?\d*|0\.?\d*[1-9]\d*|0?\.?0+|0)$/.test(val) || parseFloat(val) >= st0921) {
                                    error = true;
                                    msg = '\u5fc5\u987b\u5c0f\u4e8e' + st0921;
                                }
                                break;
                            case 'b'://必须大于
                                var st0922 = parseInt(tp_flag.substr(1));
                                if (val == '' || !/^-?([1-9]\d*\.?\d*|0\.?\d*[1-9]\d*|0?\.?0+|0)$/.test(val) || parseFloat(val) <= st0922) {
                                    error = true;
                                    msg = '\u5fc5\u987b\u5927\u4e8e' + st0922;
                                }
                                break;
                            case '#'://两个值必须相等
                                if (document.getElementById(sinbo_id09323).value != val) {
                                    error = true;
                                    msg = '\u4e24\u6b21\u8f93\u5165\u4e0d\u4e00\u81f4';
                                }
                                break;
                            case '%'://二选一
                                if (val == '' && document.getElementById(sinbo_id09323).value == '') {
                                    error = true;
                                    msg = '\u81f3\u5c11\u8981\u586b\u51991\u9879';
                                }
                                break;
                            case '_'://后面的数字大于前面
                                if (parseInt(val) < parseInt(document.getElementById(sinbo_id09323).value)) {
                                    error = true;
                                    msg = '\u4e0d\u80fd\u5c0f\u4e8e\u5b83';
                                }
                                break;
                            case '*'://后面的时间大于前面的时间
                                msg = '\u5fc5\u987b\u5927\u4e8e\u524d\u9762\u65f6\u95f4';
                                if (val == '' || document.getElementById(sinbo_id09323).value == '') {
                                    error = true;
                                }
                                before323 = document.getElementById(sinbo_id09323).value.split('-');
                                curent238 = val.split('-');
                                if (before323.length != curent238.length) {
                                    error = true;
                                } else {
                                    for (c = 0; c < before323.length; c++) {
                                        if (parseInt(before323[c]) < parseInt(curent238[c])) {
                                            break;
                                        } else {
                                            if (parseInt(before323[c]) > parseInt(curent238[c])) {
                                                error = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                                break;
                        }
                        break;
                }
                if (ime) { $(field).css('ime-mode', 'disabled') }
                if (error)
                    break;
            }
            errID = $(field).attr('id');
            if (errID == undefined)
                errID = $(field).attr('class');
            errID = 'ko' + errID.replace(/[\_|\s\-\|\W]/gi, '');
            cur = $(field).next();
            if (error) {
                if ($(field).attr('title') != undefined && $(field).attr('title') != '') { msg = $(field).attr('title') }
                if (!$('#' + errID).length) {
                    if (cur.tagName == 'SPAN' || (cur[0] != undefined && cur[0].tagName == 'SPAN')) {//覆盖原来span内容
                        if (hashspan[errID] == undefined) {
                            hashspan[errID] = $(cur).html();
                        }
                        $(cur).html('<span style="color:red;">' + msg + '</span>');
                    } else {//新增错误信息
                        var tp = temp[0].substr(temp[0].length - 1, 1);
                        if (tp == 'j') {
                            var tipspan = $('<span style="position:absolute;display:inline-block;z-index:9999" id="' + errID + '" class="kootip">' + msg + '</span>');
                            var curOffset = $(field).position();
                            tipspan.css('left', (curOffset.left + 14) + 'px');
                            tipspan.css('top', (curOffset.top + $(field).height() + 2) + 'px');
                            $(field).after(tipspan);
                        } else {
                            $(field).after('<span id="' + errID + '" class="kootip">' + msg + '</span>');
                        }
                    }
                }
            } else {
                if (hashspan[errID] != undefined) {//如果没有错误，则恢复原来的字
                    $(cur).html(hashspan[errID]);
                } else {
                    if ($('#' + errID)) {
                        $('#' + errID).remove();
                    }
                }
            }
            return !error;
        }
        function getCheck(obj) {
            var template_id = $(obj).attr('id');
            if (template_id == undefined || template_id.indexOf('-') < 0) {
                template_id = $(obj).attr('class');
                if (template_id == undefined || template_id.indexOf('-') < 0)
                    return null;
                var lst = $.trim(template_id).replace(/\s+/g, ' ').split(' ');
                for (var i = 0; i < lst.length; i++) {
                    if (lst[i].indexOf('-') > -1) {
                        template_id = lst[i];
                        break;
                    }
                }
            }
            return template_id.split('-');
        }
        var formstate123268 = false;
        function validateForm(obj) {
            $(obj).submit(function () {
                if (formstate123268) {//如果是重复提交则返回
                    return false;
                }
                formstate123268 = true;
                var validationError = false;
                $('input,select,textarea', this).each(function () {
                    var temp = getCheck(this);
                    if (temp != null && temp.length > 1) {
                        if (!validateField(this, temp)) {
                            validationError = true;
                        }
                    }
                });
                formstate123268 = false;
                if (validationError) {
                    return false;
                }
                if (callback != undefined && typeof (callback) == 'function') {
                    var result = callback();
                    if (typeof (result) == 'boolean') {
                        return result;
                    }
                }
                return true;
            });

            $('input', obj).each(function () {
                var temp = getCheck(this);
                if (temp == null || temp.length < 2)
                    return;
                var objType = $(this).attr('type');
                if (objType == 'checkbox' || objType == 'radio') {
                    if (temp[1] == $(this).val()) {
                        $(this).attr('checked', 'true');
                    }
                }
                if (temp[1] == 'date') {
                    var val = $(this).val().split(' ');
                    $(this).val(val[0]);
                    $(this).datepicker();
                    $(this).css('ime-mode', 'disabled')
                }
            });

            $('select', obj).each(function () {
                var temp = getCheck(this);
                if (temp != null && temp.length > 1) {
                    var val = temp[1];
                    $(this).children('option', this).each(function () {
                        if ($(this).attr('value') == val) {
                            $(this).attr('selected', 'selected');
                        }
                    });
                    $(this).change(function () {
                        validateField(this, temp)
                    });
                }
            });

            $('optgroup', obj).each(function () {
                var temp = getCheck(this);
                if (temp[1] != undefined && temp.length > 1) {
                    var val = temp[1];
                    $(this).children('option', this).each(function () {
                        if ($(this).val() == val) {
                            $(this).attr('selected', 'selected');
                        }
                    });
                }
            });

            $('input,textarea', obj).each(function () {
                var temp = getCheck(this);
                if (temp != null && temp[1].length > 1) {
                    $(this).blur(function () {
                        validateField(this, temp);
                    });
                }
            });
        }
        this.each(function (i, elem) {
            validateForm(elem);
        });
    }
})(jQuery);

(function ($) {
    $.fn.calendar = function (options) {
        options = $.extend({
            initDate: new Date(),
            monthText: ['1\u6708', '2\u6708', '3\u6708', '4\u6708', '5\u6708', '6\u6708', '7\u6708', '8\u6708', '9\u6708', '10\u6708', '11\u6708', '12\u6708'],
            weekText: ['\u65e5', '\u4e00', '\u4e8c', '\u4e09', '\u56db', '\u4e94', '\u516d'],
            range: [new Date(1949, 0, 1), new Date(2015, 0, 1)],
            clickEvent: null
        }, options);
        function MonthInfo(y, m) {
            var monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            var d = (new Date(y, m, 1));
            d.setDate(1);
            if (d.getDate() == 2) d.setDate(0);
            y += 1900;
            return {
                days: m == 1 ? (((y % 4 == 0) && (y % 100 != 0)) || (y % 400 == 0) ? 29 : 28) : monthDays[m],
                firstDay: d.getDay()
            }
        };
        function InitCalendar(cal, date) {
            cal.html('');
            var month = MonthInfo(date.getFullYear(), date.getMonth());
            var year = $('<ul style="list-style:none;width:147px; margin:0px; padding:0px; text-align:center;"></ul>');
            year.append('<li style="width:75px;float:left;"><a href="#" style="display:block;text-decoration:none; color:#2a2a2a;" cal="year" year="' + date.getFullYear() + '" style="display:block;text-decoration:none;color:#2a2a2a;">' + date.getFullYear() + '\u5e74</a></li>').append('<li style="width:70px;float:left;" month="' + date.getMonth() + '"><a href="#" cal="month"  style="display:block; text-decoration:none; color:#2a2a2a;">' + options.monthText[date.getMonth()] + '</a></li>');
            cal.append(year);
            var today = $('<ul style="list-style:none; width:147px; margin:0px; padding:0px; text-align:center;"></ul>');
            today.append('<li style="float:left;"><a href="#" cal="preyear" style="display:block; text-decoration:none; color:#2a2a2a;"><<</a></li>').append('<li style="float:left;"><a href="#" cal="preweek" style="display:block; text-decoration:none;width:30px; color:#2a2a2a;"><</a></li>').append('<li style="width:40px;float:left;"><a href="#" cal="today" style="display:block; text-decoration:none; color:#2a2a2a;">\u4eca\u5929</a></li>').append('<li style="float:left;"><a href="#" cal="nextweek"  style="display:block;width:35px; text-decoration:none; color:#2a2a2a;">></a></li>').append('<li style="float:left;"><a href="#" cal="nextyear" style="display:block;text-decoration:none;color:#2a2a2a;">>></a></li>');
            cal.append(today);
            var week = $('<ul style="list-style:none; width:147px; margin:0px; padding:0px; text-align:center;"></ul>');
            for (i = 0; i < 7; i++) {
                week.append('<li style="height:auto;float:left;width:21px;height:18px;">' + options.weekText[i] + '</li>');
            };

            cal.append(week);
            for (i = 0; i < 6; i++) {
                var days = $('<ul style="list-style:none; width:147px; margin:0px; padding:0px; text-align:center;"></ul>');
                for (var j = 0; j < 7; j++) {
                    var d = 7 * i - month.firstDay + j + 1;
                    var css = d == date.getDate() ? 'style="color:#da2727;text-decoration:underline;font-weight:bold;"' : '';
                    if (d > 0 && d <= month.days) {
                        var curd = new Date(date.getFullYear(), date.getMonth(), d);
                        if (curd >= options.range[0] && curd <= options.range[1]) {
                            days.append('<li style="float:left;width:21px;height:18px;text-align:center;"><a href="#" ' + css + ' year="' + date.getFullYear() + '" month="' + date.getMonth() + '" date="' + d + '"  style="display:block; text-decoration:none; color:#2a2a2a;">' + d + '</a></li>');
                        } else {
                            days.append('<li style="color:#dcdcdc;float:left;width:21px;height:18px;">' + d + '</li>');
                        }
                    } else {
                        days.append('<li style="float:left;width:21px;height:18px;">&nbsp;</li>');
                    }
                };

                cal.append(days)
            };

            cal.find('a').focus(function () {
                this.blur()
            });
            cal.find('a').click(function () {
                if ($(this).attr('cal') == 'today') {
                    InitCalendar(cal, new Date());
                    if (options.clickEvent != null) options.clickEvent(new Date())
                } else if ($(this).attr('cal') == 'preyear') {
                    date.setFullYear(date.getFullYear() - 1);
                    InitCalendar(cal, date)
                } else if ($(this).attr('cal') == 'nextyear') {
                    date.setFullYear(date.getFullYear() + 1);
                    InitCalendar(cal, date)
                } else if ($(this).attr('cal') == 'preweek') {
                    date.setMonth(date.getMonth() - 1);
                    InitCalendar(cal, date)
                } else if ($(this).attr('cal') == 'nextweek') {
                    date.setMonth(date.getMonth() + 1);
                    InitCalendar(cal, date)
                } else if ($(this).attr('cal') == 'year') {
                    var year = $('<select style="width:' + (this.clientWidth - 1) + 'px"></select>');
                    var selected = $(this).attr('year');
                    for (var i = options.range[0].getFullYear() ; i <= options.range[1].getFullYear() ; i++) {
                        year.append('<option value="' + i + '">' + i + '</option>');
                    };

                    year.change(function () {
                        date.setFullYear(this.value);
                        InitCalendar(cal, date)
                    });
                    year.val(selected);
                    $(this).replaceWith(year)
                }
                else if ($(this).attr('cal') == 'month') {
                    var mon = $('<select style="width:' + (this.clientWidth - 2) + 'px"></select>');
                    selected = $(this).parent().attr('month');
                    for (i = 0; i < 12; i++) {
                        mon.append('<option value="' + i + '">' + options.monthText[i] + '</option>')
                    };

                    mon.change(function () {
                        date.setMonth(this.value);
                        InitCalendar(cal, date)
                    });
                    mon.val(selected);
                    $(this).replaceWith(mon)
                } else {
                    cal.find('.calendar_selected').removeAttr('class');
                    this.className = 'calendar_selected';
                    if (options.clickEvent != null) options.clickEvent(new Date($(this).attr("year"), $(this).attr("month"), $(this).attr("date")));
                };

                return false
            })
        };

        return this.each(function () {
            var cal = $(this);
            var date = options.initDate;
            InitCalendar(cal, date)
        })
    }
})(jQuery);
(function ($) {
    $.fn.datepicker = function (options) {
        options = $.extend({
            initDate: '',
            monthText: ['1\u6708', '2\u6708', '3\u6708', '4\u6708', '5\u6708', '6\u6708', '7\u6708', '8\u6708', '9\u6708', '10\u6708', '11\u6708', '12\u6708'],
            weekText: ['\u65e5', '\u4e00', '\u4e8c', '\u4e09', '\u56db', '\u4e94', '\u516d'],
            range: [new Date(1949, 0, 1), new Date(2015, 0, 1)],
            splitChar: "-"
        }, options);
        return this.each(function () {
            $(this).focus(function () {
                if ($('#' + this.id + '_date').length == 0) {
                    var area = $('<div id="' + this.id + '_date" style="font-size:12px; width:152px;z-index:999; height:176px;background:white;border:1px #999 solid;color:#2a2a2a;padding-top:6px; padding-left:6px" class="jabinfo_02"></div>');
                    var dateinput = this;
                    var initdate = new Date();
                    if (this.value != '') {
                        var d = dateinput.value.split(options.splitChar);
                        if (d.length == 3)
                            initdate = new Date(d[0], d[1] - 1, d[2]);
                    };

                    area.calendar({
                        initDate: initdate,
                        range: options.range,
                        monthText: options.monthText,
                        weekText: options.weekText,
                        clickEvent: function (date) {
                            dateinput.value = date.getFullYear() + options.splitChar + (date.getMonth() + 1) + options.splitChar + date.getDate();
                            area.remove();
                            errID = dateinput.getAttribute('name') + '231314';
                            if ($('#' + errID)) {
                                $('#' + errID).remove();
                            }
                        }
                    });
                    var offset = $(this).offset();
                    area.css({
                        position: 'absolute',
                        left: $(this).offset().left,
                        top: $(this).offset().top + this.clientHeight
                    });
                    area.mouseover(function () { area.attr('class', 'jabinfo_01') });
                    area.mouseout(function () { area.attr('class', 'jabinfo_02') });
                    $('body').append(area);
                } else {
                    $('#' + this.id + '_date').remove();
                }
            });
            $(this).blur(function () {
                if ($('#' + this.id + '_date').attr('class') == 'jabinfo_02') { $('#' + this.id + '_date').remove() }
            });
        })
    }
})(jQuery);