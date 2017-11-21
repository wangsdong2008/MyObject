<?php
/**
* 基于curl的get访问方式，要求php打开curl扩展
* $url @string 请求地址
* $param_array @array 参数数组
*/


//$obj为分页参数 $cpage为当前页数 $count为最大数量
function showpage2($cPage,$count,$obj,$num=0,$pagesize=0){
	$pagesize = $pagesize>0?$pagesize:C(ADMIN_DEFAULT_PAGENUM);
	$maxPage = getpagenum($count,$pagesize);
	$str = '';
	//开始获取分页参数
	$cs = '';
	//$obj = $c1.split('|');
	if(count($obj) > 0){
		foreach($obj as $key => $value){
			$cs .= $key.'/'.$value.'/';
		}
	}
	$cs = __ACTION__.'/'.$cs;
	$cs = str_replace('/Home','',$cs);
	$cs = str_replace('/home','',$cs);
	switch($num) {
		case 0:
			$str .= '<div id="pagesinfo">共'.$maxPage.'页 每页'.$pagesize.'条 页次：'.$cPage.'/'.$maxPage.'</div>';
			$str .= '<div id="pages"><ul>';
			if($cPage*1 > 1){
				$str .= '<li class="pbutton"><a href="'.$cs.'page/1.html">首页</a></li> ';
				$str .= '<li class="pbutton"><a href="'.$cs.'page/'.($cPage-1).'.html">上一页</a></li> ';
			}
			else{
				$str .= '<li class="pbutton">首页</li> ';
				$str .= '<li class="pbutton">上一页</li> ';
			}
			$str .= '<li class="pagesnow">'.$cPage.'</li> ';
			if($cPage*1 < $maxPage*1){
				$str .= '<li class="pbutton"><a href="'.$cs.'page/'.($cPage+1).'.html">下一页</a> </li> ';
				$str .= '<li class="pbutton"><a href="'.$cs.'page/'.$maxPage.'.html">尾页</a></li> ';
			}
			else{
				$str .= '<li class="pbutton">下一页</li> ';
				$str .= '<li class="pbutton">尾页</li> ';
			}


			$str .= '<li class="opt">';
			$str .= '<select onChange="window.location=this.options[this.selectedIndex].value+\'.html\'">';
			for($i=1;$i<=$maxPage;$i++){
				if($i == $cPage){
					$str .= '<option value="'.$cs.'page/'.$i.'" selected>第'.$i.'页</option>';
				}
				else{
					$str .= '<option value="'.$cs.'page/'.$i.'">第'.$i.'页</option>';
				}
			}
			$str .= '</select>';
			$str .= '</li> ';
			$str .= '';
			$str .= '</ul></div>';
			break;
		case 1:
			if($cPage*1 > 1){
				$str .= '&nbsp;&nbsp;<a href="'.$cs.'page/1.html">&lt;&lt;</a>&nbsp;&nbsp;';
				$str .= '&nbsp;&nbsp;<a href="'.$cs.'page/'.($cPage-1).'.html">&lt;</a>&nbsp;&nbsp;';
			}
			else{
				$str .= '&nbsp;&nbsp;<a href="javascript:;">&lt;&lt;</a>&nbsp;&nbsp;';
				$str .= '&nbsp;&nbsp;<a href="javascript:;">&lt;</a>&nbsp;&nbsp;';
			}

			for($i=1;$i<=$maxPage;$i++){
				if($i == $cPage){
					$str .= '&nbsp;&nbsp;<a href="javascript:;">'.$i.'</a>&nbsp;&nbsp;';
				}
				else{
					$str .= '&nbsp;&nbsp;<a href="'.$cs.'page/'.$i.'.html">'.$i.'</a>&nbsp;&nbsp;';
				}
			}

			if($cPage*1 < $maxPage*1){
				$str .= '&nbsp;&nbsp;<a href="'.$cs.'page/'.($cPage+1).'.html">&gt;</a>&nbsp;&nbsp;';
			}
			else{
				$str .= '&nbsp;&nbsp;<a href="javascript:;">&gt;</a>&nbsp;&nbsp;';
			}

			if($cPage*1 < $maxPage*1){
				$str .= '&nbsp;&nbsp;<a href="'.$cs.'page/'.$maxPage.'.html">&gt;&gt;</a> ';
			}
			else{
				$str .= '&nbsp;&nbsp;<a href="javascript:;">&gt;&gt;</a> ';
			}
			break;

		case 3:
			if($cPage*1 > 1){
				$str .= '<a class="firstpage" onclick="ajax(1)"></a>';
				$str .= '<a class="prepage" onclick="ajax('.($cPage-1).')"></a>';
			}

			if($maxPage*1 != 1){
				$str .= '<a class="pagenumber">第'.$cPage.'页</a>';
			}

			if ($cPage * 1 < $maxPage * 1) {
				$str .= '<a class="nextpage" onclick="ajax('.($cPage+1).')"></a>';
				$str .= '<a class="lastpage" onclick="ajax('.$maxPage.')"></a> ';
			}
			break;

		default:
			if($cPage*1 > 1){
				$str .= '<a href="'.$cs.'page/'.($cPage-1).'.html">&lt;</a>';
			}
			else{
				$str .= '<a href="javascript:;" class="disabled">&lt;</a>';
			}

			if($cPage == 1) {
				$str .= '<a href="javascript:;" class="action">'.$cPage.'</a>';
			} else {
				$str .= '<a href="'.$cs.'page/1.html">1</a>';
			}

			if($cPage > 4) {
				$str .= '<a class="border_none" href="javascript:;">· · ·</a>';
				for($i=$cPage-2;$i<=$cPage;$i++){
					if($i == $cPage){
						$str .= '<a href="javascript:;" class="action">'.$i.'</a>&nbsp;';
					}
					else{
						$str .= '<a href="'.$cs.'page/'.$i.'.html">'.$i.'</a>';
					}
				}
			} else {
				for($i=2;$i<=$cPage;$i++){
					if($i == $cPage){
						$str .= '<a href="javascript:;" class="action">'.$i.'</a>';
					}
					else{
						$str .= '<a href="'.$cs.'page/'.$i.'.html">'.$i.'</a>';
					}
				}
			}

			if($maxPage-$cPage < 3) {
				for($i=$cPage+1;$i<=$maxPage;$i++){
					$str .= '<a href="'.$cs.'page/'.$i.'.html">'.$i.'</a>';
				}
			} else {
				for($i=$cPage+1;$i<=$cPage+2;$i++){
					$str .= '<a href="'.$cs.'page/'.$i.'.html">'.$i.'</a>';
				}
				$str .= '<a class="border_none" href="javascript:;">· · ·</a>';
				$str .= '<a href="'.$cs.'page/'.$maxPage.'.html">'.$maxPage.'</a>';
			}

			if($cPage*1 < $maxPage*1){
				$str .= '<a href="'.$cs.'page/'.($cPage+1).'.html">&gt;</a>';
			}
			else{
				$str .= '<a href="javascript:;" class="disabled">&gt;</a>';
			}
			$str .= '<span class="gotopage">跳至</span>';
			$str .= '<input type="text" id="gotopage" fale="'.$cs.'page/" value="'.$cPage.'" max="'.$maxPage.'" min="1" />';
			$str .= '<span class="page">页</span><input class="turnpage" type="button" name="" id="" onclick="pagejump('.$maxPage.')" value="跳转" />';

	}
	return $str;
}

?>