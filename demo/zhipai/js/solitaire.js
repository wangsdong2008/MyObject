;(function() {

$.fn.solitaire = function(options) {
	options = $.extend({}, $.solitaire.defaults, options);

	return this.each(function() {
		new $.solitaire(this, options);
	});
}

$.solitaire = function(element, options) {
	
	var CardType = { Heart: 1, Spade: 2, Club: 3, Diamond: 4 };
	var CardStatus = { Empty: 1, Hide: 2, Show: 3 };
	var CardArea = { Store: 1, Box: 2, Finish: 3 };
	var OrderBy = {	Asc: 1,	Desc: 2 };
	
	var Img = {
		Bg: "url(images/common/Bg.png)",
		Box: "url(images/common/box.png)",
		Finish: "url(images/common/finish.png)",
		Hide: "url(images/common/hide.png)",
		Store: "url(images/common/store.png)",
		Hover: "url(images/common/hover.png)",
		Active: "url(images/common/active.png)",
		Hide: "url(images/common/hide.png)",
		Tip: "url(images/common/tip.png)"
	};
	
	var CW = options.cardWidth;
	var CH = options.cardHeight;
	var CT = options.cardTop;
	var CR = options.cardRight;
	var CB = options.cardBottom;
	var CL = options.cardLeft;
	var CLT = options.cardListTop;
	var CAW = CW + CR;
	var CAH = CH + CB;

	var undefined;
	var storeDiv;
	var storeShowDiv;
	var boxDiv = [];
	var finishDiv = [];
	var tipDiv;
	var fromDiv;
	var toDiv;
	var hoverDiv;
	var activeDiv;
	var maskDiv;
	
	var data = {
		store: [],
		storeShow: [],
		box: [],
		finish: [
			[],
			[],
			[],
			[]
		]
	};
		
	var $root = $(element).css({
		position: "relative",
		width: 800,
		height: 500,
		background: Img.Bg
	});
		
	function initData() {
		var store = [];

		for(var i = 0; i < 52; i++) {
			store.push({ type: parseInt(i / 13) + 1, val: i % 13 + 1 });
		}
		
		store.sort(function () { return Math.random() > 0.5 ? 1 : -1 });
	
		for(var i = 0; i < 7; i++) {
			var temp = [];
			for(var j = 0; j < i + 1; j++) {
				temp.push(store.shift());
			}
			data.box.push(temp);
		}
		data.store = store;
	}
	
	function initFrame() {
		maskDiv = $("<div/>").css({
			position: "absolute",
			width: "100%",
			height: "100%",
			opacity: 0.2,
			background: "#000",
			"z-index": 20000
		}).hide().appendTo($root);
		
		storeDiv = createDiv(CL, CT, CW, CH, Img.Store).appendTo($root);
		storeShowDiv = createDiv(CL + CAW, CT, CW, CH, Img.Finish).appendTo($root);
			
		for(var i = 0; i < 4; i++) {			
			finishDiv.push(createDiv(CL + CAW * (3 + i), CT, CW, CH).appendTo($root));
			createDiv(0, 0, CW, CH, Img.Finish, CardArea.Finish, i, CardStatus.Empty).appendTo(finishDiv[i]);
		}

		var animateDiv = createDiv(CL + CAW * 2, CT, CW, CH, Img.Hide).appendTo($root);

		for(var i = 0; i < 7; i++) {
			maskDiv.show();
			boxDiv.push(createDiv(CL + CAW * i, CT + CAH, CW, CH).appendTo($root));
			createDiv(0, 0, CW, CH, Img.Box, CardArea.Box, i, CardStatus.Empty).appendTo(boxDiv[i]);

			for(var j = 0, c = data.box[i].length; j < c; j++) {
				if(j == data.box[i].length - 1) {
					createDiv(CAW * (2 - i), -CAH, CW, CH, formatBg(data.box[i][j]), CardArea.Box, i + "-" + j, CardStatus.Show).appendTo(boxDiv[i]).animate({ left: 0, top: 10 * j }, 300 + 100 * j, function() {
						maskDiv.hide();
					});
				} else {
					createDiv(CAW * (2 - i), -CAH, CW, CH, Img.Hide, CardArea.Box, i + "-" + j, CardStatus.Hide).appendTo(boxDiv[i]).animate({ left: 0, top: 10 * j }, 300 + 100 * j, function() {
						maskDiv.hide();
					});
				}
			}
		}
		
		for(var i = 0, c = data.store.length; i < c; i++) {
			maskDiv.show();
			var temp = animateDiv.clone(false).appendTo($root);
			temp.animate({ left: CL, top: CT }, 400 + 10 * i, function() {
				$(this).remove();
				storeDiv.css({
					background: Img.Hide
				});
				animateDiv.remove();
				maskDiv.hide();
			});
		}
	}

	function initEvent() {
		$root.find("div[s='" + CardStatus.Show + "']").live("mousedown", function(event) {
			window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
		}).live("mouseup", function(event) {
			if(fromDiv != undefined) {
				if(fromDiv.attr("a") == $(this).attr("a") && fromDiv.attr("i") == $(this).attr("i")) {
					alert("单击了已选择的牌");
				} else {
					activeDiv.remove();
					activeDiv = undefined;
					toDiv = $(this);
					move(fromDiv, toDiv);
				}
			} else {
				fromDiv = $(this);
				hoverDiv.remove();
				hoverDiv = undefined;
				activeDiv = createDiv($(this).position().left - 10, $(this).position().top - 10, 90, 116, Img.Active).insertBefore($(this));
			}
		}).live("mouseover", function() {
			if(fromDiv != undefined && fromDiv.attr("a") == $(this).attr("a") && fromDiv.attr("i") == $(this).attr("i")) {

			} else {
				hoverDiv = createDiv($(this).position().left - 10, $(this).position().top - 10, 90, 116, Img.Hover).insertBefore($(this));
			}
		}).live("mouseout", function() {
			if(hoverDiv != undefined) {
				hoverDiv.remove();
				hoverDiv = undefined;
			}
		}).live("click", function() {
			return false;
		});
		
		$root.bind("mousemove", function(event) {
			//if(dropFlag && fromDiv) {
//				fromDiv.css({
//					"z-index": 10000,
//					left: event.pageX - dropPos.x + fromDiv.position().left,
//					top: event.pageY - dropPos.y + fromDiv.position().top
//				});
//				hoverDiv.css({
//					"z-index": 10000,
//					left: event.pageX - dropPos.x + hoverDiv.position().left,
//					top: event.pageY - dropPos.y + hoverDiv.position().top
//				});
//			}
//			dropPos = { x: event.pageX, y: event.pageY };
		}).live("click", function() {
			if(activeDiv != undefined) {
				activeDiv.remove();
				activeDiv = undefined;
				
				fromDiv = undefined;
				toDiv = undefined;
			}
		});
		
		$root.find("div[s='" + CardStatus.Empty + "']").bind("click", function(event) {
			if(fromDiv != undefined) {
				activeDiv.remove();
				activeDiv = undefined;
				toDiv =  $(this);
				move(fromDiv, toDiv);
			}
		});
		
		storeDiv.bind("click", function() {
			if(data.store.length > 0) {
				maskDiv.show();
				data.storeShow.push(data.store.shift());
				var temp = createDiv(-CAW, 0, CW, CH, formatBg(data.storeShow[data.storeShow.length - 1]), CardArea.Store, data.storeShow.length - 1, CardStatus.Show).css({
					"z-index": 10000
				}).appendTo(storeShowDiv);
				temp.animate({ left: 0 }, 100, function(){
					temp.css({ "z-index": 0 });
					maskDiv.hide();
				});
			} else {
				data.store = data.storeShow;
				data.storeShow = [];
				storeShowDiv.empty();
			}
		});
	}

	function getToPos(x, y) {
		var intervalTop1 = Math.abs(options.cardTop - y);

		for(var i = 0; i < 7; i++) {
			var left = CL + CAW * i
			var intervalTop2 = Math.abs(CT + CAH + (data.box[i].length - 1) * CLT - y);
			var intervalLeft = Math.abs(left - x);
			if(intervalTop1 < CH / 2) {
				if(i > 2) {
					if(intervalLeft < CW / 2) {
						return { area: CardArea.Finish, index: i - 3 };
						break;
					}
				}
			} else if(intervalTop2 < CH / 2) {
				if(intervalLeft < CW / 2) {
					return { area: CardArea.Box, Index: i };
					break;
				}
			}
		}
		return undefined;
	}
	
	function init() {
		initData();
		initFrame();
		initEvent();
	}
	
	function createDiv(x, y, w, h, b, a, i, s) {
		var len = arguments.length;
		var temp = $("<div/>").css({ position: "absolute" });
		if(len >= 4) {
			temp.css({
				left: x,
				top: y,
				width: w,
				height: h
			});
			
			if(len >= 5) {
			
				temp.css({
					background: b
				});
				
				if(len >= 6) {
					temp.attr({
						a: a
					});
					
					if(len >= 7) {
						temp.attr({
							i: i
						});
						
						if(len >= 8) {
							temp.attr({
								s: s
							});
						}
					}
				}
			}
		}
		return temp;
	}

	function formatBg(card) {
		var path = "url(images/";
		switch(card.type) {
			case CardType.Heart:
				path += "heart";
				break
			case CardType.Spade:
				path += "spade";
				break
			case CardType.Club:
				path += "club";
				break
			default:
				path += "diamond";
				break
		}
		path += "/" + card.val + ".png) no-repeat";
		return path;
	}

	function move(from, to) {
		if(from == undefined || to == undefined) return;
		
		var fromArea = from.attr("a");
		var toArea = to.attr("a");
		
		if(fromArea == CardArea.Store) {
			if(toArea == CardArea.Box) {
				storeToBox(from, to);
			} else if(toArea == CardArea.Finish) {
				storeToFinish(from, to);
			}
		} else if(fromArea == CardArea.Box) {
			if(toArea == CardArea.Box) {
				boxToBox(from, to);
			} else if(toArea == CardArea.Finish) {
				boxToFinish(from, to);
			}
		} else if(fromArea == CardArea.Finish) {
			if(toArea == CardArea.Box) {
				finishToBox(from, to);
			} else if(toArea == CardArea.Finish) {
				finishToFinish(from, to);
			}
		}
		fromDiv = undefined;
		toDiv = undefined;
	}
	
	function boxToFinish(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-')[0];
				return data.box[fromIndex][data.box[fromIndex].length - 1].val == 1;
			},
			callBack: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-')[0];
				data.finish[toIndex].push(data.box[fromIndex].pop());
				
			}
		}, {
			rule: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-')[0];
				return checkLink(data.box[fromIndex][data.box[fromIndex].length - 1], data.finish[toIndex][data.finish[toIndex].length - 1], OrderBy.Asc);
			},
			callBack: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-')[0];
				data.finish[toIndex].push(data.box[fromIndex].pop());
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			fromIndex = fromIndex.split('-')[0];
			var interLeft = to.parent().position().left - from.parent().position().left;
			var interTop = to.parent().position().top - from.parent().position().top;	
			from.css({ "z-index": 10000 });
			from.animate({ left: interLeft, top: interTop }, 100, function() {
				if(data.box[fromIndex].length > 0) {
					hideToShow(from.prev(), fromIndex);
				}
				from.css({
					left: 0,
					top: 0,
					"z-index": 0
				}).attr({
					a: to.attr("a"),
					i: toIndex
				}).insertAfter(to);
				maskDiv.hide();
				checkWin();
			});
		});
	}
	
	function boxToBox(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-');
				return data.box[fromIndex[0]][fromIndex[1]].val == 13;
			},
			callBack: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-');
				data.box[toIndex] = data.box[toIndex].concat(data.box[fromIndex[0]].slice(fromIndex[1], data.box[fromIndex[0]].length));
				data.box[fromIndex[0]].splice(fromIndex[1], data.box[fromIndex[0]].length - fromIndex[1]);
			}
		}, {
			rule: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-');
				toIndex = toIndex.split('-');
				return checkLink(data.box[fromIndex[0]][fromIndex[1]], data.box[toIndex[0]][data.box[toIndex[0]].length - 1], OrderBy.Desc)
			},
			callBack: function(fromIndex, toIndex) {
				fromIndex = fromIndex.split('-');
				toIndex = toIndex.split('-');
				data.box[toIndex[0]] = data.box[toIndex[0]].concat(data.box[fromIndex[0]].slice(fromIndex[1], data.box[fromIndex[0]].length));
				data.box[fromIndex[0]].splice(fromIndex[1], data.box[fromIndex[0]].length - fromIndex[1]);
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			fromIndex = fromIndex.split('-');
			var toArr = toIndex.split('-');
			var interLeft = to.parent().position().left - from.parent().position().left;
			from.nextAll().add(from).each(function(index) {
				
				if(index == 0 && data.box[fromIndex[0]].length > 0) {
					hideToShow(from.prev(), fromIndex[0]);
				}
				var interTop = to.position().top + CLT * index;
				var i;
				if(toArr.length == 2) {
					interTop += CLT;
					i = toArr[0] + "-" + (parseInt(toArr[1]) + index + 1);
				} else {
					i = toIndex + "-" + index;
				}
				
				$(this).css({"z-index": 10000});
				
				$(this).animate({ top:interTop, left: interLeft}, 100, function(){
					$(this).css({
						"z-index": 0,
						left: 0
					}).attr({
						a: to.attr("a"),
						i: i
					}).appendTo(to.parent());
					maskDiv.hide();
				});
			});
		});
	}
	
	function finishToFinish(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				return data.finish[fromIndex][data.finish[fromIndex].length - 1].val == 1;
			},
			callBack: function(fromIndex, toIndex) {
				data.finish[toIndex].push(data.finish[fromIndex].pop());
			}
		}, {
			rule: function(fromIndex, toIndex) {
				return checkLink(data.finish[fromIndex][data.finish[fromIndex].length - 1], data.finish[toIndex][data.finish[toIndex].length - 1], OrderBy.Asc);
			},
			callBack: function(fromIndex, toIndex) {
				data.finish[toIndex].push(data.finish[fromIndex].pop());
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			var interLeft = to.parent().position().left - from.parent().position().left;
			from.css({ "z-index": 10000 });
			from.animate({ left: interLeft }, 100, function() {
				from.css({
					left: 0,
					"z-index": 0
				}).attr({
					a: to.attr("a"),
					i: toIndex
				}).insertAfter(to);
				maskDiv.hide();
				checkWin();
			});
		});
	}
	
	function finishToBox(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				return data.finish[fromIndex][data.finish[fromIndex].length - 1].val == 13;
			},
			callBack: function(fromIndex, toIndex) {
				data.box[toIndex].push(data.finish[fromIndex].pop());			
			}
		}, {
			rule: function(fromIndex, toIndex) {
				toIndex = toIndex.split('-')[0];
				return checkLink(data.finish[fromIndex][data.finish[fromIndex].length - 1], data.box[toIndex][data.box[toIndex].length - 1], OrderBy.Desc)
			},
			callBack: function(fromIndex, toIndex) {
				toIndex = toIndex.split('-')[0];
				data.box[toIndex].push(data.finish[fromIndex].pop());
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			var interLeft = to.parent().position().left - from.parent().position().left;
			var toArr = toIndex.split('-');
			var interTop = CAH;
			var i;
			var top = 0;
			if(toArr.length == 2) {
				top = to.position().top + CLT;
				interTop += to.position().top + CLT;
				i = toArr[0] + "-" + (data.box[toArr[0]].length - 1);
			} else {
				i = toIndex + "-" + (data.box[toIndex].length - 1);
			}
			
			from.css({ "z-index": 10000 });
			from.animate({ left: interLeft, top: interTop }, 100, function() {
				from.css({
					left: 0,
					top: top,
					"z-index": 0
				}).attr({
					a: to.attr("a"),
					i: i
				}).insertAfter(to);
				maskDiv.hide();
			});
		});
	}
	
	function storeToFinish(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				return data.storeShow[data.storeShow.length - 1].val == 1;
			},
			callBack: function(fromIndex, toIndex) {
				data.finish[toIndex].push(data.storeShow.pop());	
			}
		}, {
			rule: function(fromIndex, toIndex) {
				return checkLink(data.storeShow[data.storeShow.length - 1], data.finish[toIndex][data.finish[toIndex].length - 1], OrderBy.Asc);
			},
			callBack: function(fromIndex, toIndex) {
				data.finish[toIndex].push(data.storeShow.pop());
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			var interLeft = to.parent().position().left - from.parent().position().left;
			from.css({ "z-index": 10000 });
			from.animate({ left: interLeft }, 100, function() {
				from.css({
					left: 0,
					"z-index": 0
				}).attr({
					a: to.attr("a"),
					i: toIndex
				}).insertAfter(to);
				maskDiv.hide();
				checkWin();	
			});
		});
	}
	
	function storeToBox(from, to) {
		fromTo(from, to, {
			rule: function(fromIndex, toIndex) {
				return data.storeShow[data.storeShow.length - 1].val == 13;
			},
			callBack: function(fromIndex, toIndex) {
				data.box[toIndex].push(data.storeShow.pop());
			}
		}, {
			rule: function(fromIndex, toIndex) {
				toIndex = toIndex.split('-')[0];
				return checkLink(data.storeShow[data.storeShow.length - 1], data.box[toIndex][data.box[toIndex].length - 1], OrderBy.Desc);
			},
			callBack: function(fromIndex, toIndex) {
				toIndex = toIndex.split('-')[0];
				data.box[toIndex].push(data.storeShow.pop());
			}
		}, function(fromIndex, toIndex) {
			maskDiv.show();
			var interLeft = to.parent().position().left - from.parent().position().left;
			var toArr = toIndex.split('-');
			var interTop = CAH;
			var i;
			var top = 0;
			if(toArr.length == 2) {
				top = to.position().top + CLT;
				interTop += to.position().top + CLT;
				i = toArr[0] + "-" + (data.box[toArr[0]].length - 1);
			} else {
				i = toIndex + "-" + (data.box[toIndex].length - 1);
			}
			
			from.css({ "z-index": 10000 });
			from.animate({ left: interLeft, top: interTop }, 100, function() {
				from.css({
					left: 0,
					top: top,
					"z-index": 0
				}).attr({
					a: to.attr("a"),
					i: i
				}).insertAfter(to);
				maskDiv.hide();
			});
		});
	}
	
	function fromTo(from, to, emptyHnd, noEmptyHnd, animateEx) {
		var isEmpty = to.attr("s") == CardStatus.Empty;
		var fromIndex = from.attr("i");
		var toIndex = to.attr("i");
		var flag = false;
		if(isEmpty) {
			if(emptyHnd.rule(fromIndex, toIndex)) {
				if(typeof emptyHnd.callBack == "function") emptyHnd.callBack(fromIndex, toIndex);
				flag = true;
			} else {
				gameTip("移牌不符合规则");
			}
		} else {
			if(noEmptyHnd.rule(fromIndex, toIndex)) {
				if(typeof noEmptyHnd.callBack == "function") noEmptyHnd.callBack(fromIndex, toIndex);
				flag = true;
			} else {
				gameTip("移牌不符合规则");
			}
		}
		if(flag) {
			if(animateEx && typeof animateEx == "function") {
				animateEx(fromIndex, toIndex);
			}
		}
	}
	
	function gameTip(message) {
		if(tipDiv != undefined) {
			tipDiv.remove();
		}
		tipDiv = $("<div/>").css({
			position: "absolute",
			left: 10,
			top: $root.height() - 94,
			padding: "35px 10px 5px 10px",
			"line-height": "20px",
			width: 192,
			height: 44,
			"z-index": 10000,
			background: Img.Tip
		}).bind("click", function() {
			$(this).hide();
		}).html(message).appendTo($root);
	}
	
	function hideToShow(prev, fromIndex) {
		if(prev.attr("s") == CardStatus.Hide) {
			var temp = data.box[fromIndex][data.box[fromIndex].length - 1];
			prev.css({
				background: formatBg(temp)
			}).attr({
				a: CardArea.Box,
				i: fromIndex + "-" + (data.box[fromIndex].length - 1),
				s: CardStatus.Show
			});
		}
	}
	
	function checkLink(from, to, orderBy) {
		if(orderBy == OrderBy.Asc) {
			if(to.val == from.val - 1) {
				if(to.type == from.type) {
					return true;
				}
			}
		} else if(orderBy == OrderBy.Desc) {
			if(to.val == from.val + 1) {
				if(to.type != from.type && (to.type + from.type) != 5) return true;
			}
		}
		return false;
	}
	
	function checkWin() {
		var flag = true;
		for(var i = 0; i < 4; i++) {
			if(data.finish[i].length < 13) {
				flag = false;
				break;
			}
		}
		if(flag) {
			alert("胜利");
		}
	}
	
	setTimeout(init, 1000);
};

$.solitaire.defaults = {
	cardWidth: 70,
	cardHeight: 96,
	cardTop: 30,
	cardRight: 40,
	cardBottom: 30,
	cardLeft: 30,
	cardListTop: 15
};

})(jQuery);