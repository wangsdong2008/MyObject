<?php
/* exif_imagetype -- 判断一个图像的类型
*说明：函数功能是把一个图像裁剪为任意大小的图像，图像不变形
* 参数说明：输入 需要处理图片的 文件名，生成新图片的保存文件名，生成新图片的宽，生成新图片的高
*/
// 获得任意大小图像，不足地方拉伸，不产生变形，不留下空白
function my_image_resize($Image,$newpath,$Dw=450,$Dh=450,$Type=1){
  IF(!File_Exists($Image)){
      Return False;
  }
  //如果需要生成缩略图,则将原图拷贝一下重新给$Image赋值
  IF($Type != 1){
      Copy($Image,$newpath);
      $Image=$newpath;
  }
  //取得文件的类型,根据不同的类型建立不同的对象
  $ImgInfo=GetImageSize($Image);
  Switch($ImgInfo[2]){
  Case 1:
     $Img = @ImageCreateFromGIF($Image);
     Break;
  Case 2:
	$Img = @ImageCreateFromJPEG($Image);
	Break;
  Case 3:
	$Img = @ImageCreateFromPNG($Image);
	Break;
  }
  //如果对象没有创建成功,则说明非图片文件
  IF(Empty($Img)){
  //如果是生成缩略图的时候出错,则需要删掉已经复制的文件
  IF($Type!=1){Unlink($Image);}
     Return False;
  }
  //如果是执行调整尺寸操作则
  IF($Type==1){
  $w=ImagesX($Img);
  $h=ImagesY($Img);
  $width = $w;
  $height = $h;
  IF($width>$Dw){
   $Par=$Dw/$width;
   $width=$Dw;
   $height=$height*$Par;
   IF($height>$Dh){
   $Par=$Dh/$height;
   $height=$Dh;
   $width=$width*$Par;
   }
  }ElseIF($height>$Dh){
   $Par=$Dh/$height;
   $height=$Dh;
   $width=$width*$Par;
   IF($width>$Dw){
   $Par=$Dw/$width;
   $width=$Dw;
   $height=$height*$Par;
   }
  }Else{
   $width=$width;
   $height=$height;
  }
  $nImg = ImageCreateTrueColor($width,$height);   //新建一个真彩色画布
  ImageCopyReSampled($nImg,$Img,0,0,0,0,$width,$height,$w,$h);//重采样拷贝部分图像并调整大小
  ImageJpeg ($nImg,$Image);     //以JPEG格式将图像输出到浏览器或文件
  Return True;
  //如果是执行生成缩略图操作则
  }Else{
  $w=ImagesX($Img);
  $h=ImagesY($Img);
  $width = $w;
  $height = $h;
  $nImg = ImageCreateTrueColor($Dw,$Dh);
  IF($h/$w>$Dh/$Dw){ //高比较大
   $width=$Dw;
   $height=$h*$Dw/$w;
   $IntNH=$height-$Dh;
   ImageCopyReSampled($nImg, $Img, 0, -$IntNH/1.8, 0, 0, $Dw, $height, $w, $h);
  }Else{   //宽比较大
   $height=$Dh;
   $width=$w*$Dh/$h;
   $IntNW=$width-$Dw;
   ImageCopyReSampled($nImg, $Img, -$IntNW/1.8, 0, 0, 0, $width, $Dh, $w, $h);
  }
  ImageJpeg ($nImg,$Image);
  Return True;
  }
}
?>