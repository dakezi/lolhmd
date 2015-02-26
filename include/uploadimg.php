<?php

  class upfile {
     public $filepath = "uploadimgs/"; //上传文件存放文件夹

     public $filesize = 5242880; //允许上传的大小

     //如果要修改允许上传文件的类型  请搜索 【 switch ($upfiletype) { //文件类型  】

     public $reimagesize = array (
      false, //是否生成缩略图
      160, //缩略图宽
      120,//缩略图高
      "" //缩略图存放文件夹 如果为空和当前要生成缩略图的文件在同一目录 文件前缀r_
     ); //是否生成缩略图 array(生成或不生成，缩略图宽,缩略图高,存放文件夹); 注意：存放文件夹后跟 '/'

     public $india = false; //是否打水印 true打 false不打

     public $indiaimage = ""; //水印图片地址为空则不打图片水印 如果有文字水印建议不要开启图片水印

     public $indiaimagex = 100; //图片距离图片左边距离

     public $indiaimagey = 10; //图片距离图片上面距离

     public $indiatext = "lolhmd"; //水印文字

     public $fontsize = 6; //水印文字大小,1最小6最大

     public $indiatextx = 10; //文字距离图片左边距离

     public $indiatexty = 10; //文字距离图片上面距离

     public $r = 250; //图片颜色三原色 $r红

     public $g = 250; //$g绿

     public $b = 250; //$b蓝

     public $indiapath = ""; //加了水印的图片保存路径,如果为空就直接替代原来的图片

     //开始上传处理
     function uploadfile($upfile,&$filename) { //$filename可获取上传后的文件名，可用来判断上传是否成功
      if ($upfile == "") {
       die("uploadfile:参数不足");
      }
      if (!file_exists($this->filepath)) {
       mkdir($this->filepath);
      }
      $upfiletype = $upfile['type'];
      $upfilesize = $upfile['size'];
      $upfiletmpname = $upfile['tmp_name'];
      $upfilename = $upfile['name'];
      $upfileerror = $upfile['error'];
      if ($upfilesize > $this->filesize) {
       return false; //文件过大
      }
      switch ($upfiletype) { //文件类型
       case 'image/jpeg' :
        $type = 'jpg';
        break;
       case 'image/pjpeg' :
        $type = 'jpg';
        break;
       case 'image/png' :
        $type = 'png';
        break;
       case 'image/gif' :
        $type = 'gif';
        break;
      }
      if (!isset ($type)) {
       return false; //不支持此类型
      }
      if (!is_uploaded_file($upfiletmpname) or !is_file($upfiletmpname)) {
       return false;
       ; //文件不是经过正规上传的;
      }
      if ($this->upfileerror != 0) {
       return false; //其他错误
      }
      if ($this->upfileerror == 0) {
       if (!file_exists($upfiletmpname)) {
        return false; //临时文件不存在
       } else {
        date_default_timezone_set("Asia/Hong_Kong");
        $filename = date("ymdhis", time() + 3600 * 8).'_'.rand(1000,9999); //图片已当前时间命名
        $filename = $this->filepath . $filename . "." . $type;
        if (!move_uploaded_file($upfiletmpname, $filename)) {
         return false; //文件在移动中丢失
        } else {
         if ($this->india == true) {
          $this->goindia($filename, $type,true);
         } else {
          if ($this->reimagesize[0] == true) {
           $this->goreimagesize($filename, $type);
          } else {
           return true; //上传成功!
           unlink($upfiletmpname);
          }
         }
        }

       }
      }

     }
     //添加水印处理
     function goindia($filename, $filetype,$reimage=false) {
      if (!file_exists($filename)) {
       $this->reerror(7); //要添加水印的文件不存在
      } else {
       if ($filetype == "jpg") {
        $im = imagecreatefromjpeg($filename);
       } else
        if ($filetype == "gif") {
         $im = imagecreatefromgif($filename);
        } else
         if ($filetype == "png") {
          $im = imagecreatefrompng($filename);
         }
       if ($this->indiatext != "") { //如果水印文字不为空
        $textcolor = imagecolorallocate($im, $this->r, $this->g, $this->b); //设置文字颜色
        imagestring($im, $this->fontsize, $this->indiatextx, $this->indiatexty, $this->indiatext, $textcolor); //将文字写入图片
       }
       if ($this->indiaimage != "") {//如果水印图片不为空
        $indiaimagetype = getimagesize($this->indiaimage);
        $logow = $indiaimagetype[0]; //得到水印图片的宽
        $logoh = $indiaimagetype[1]; //得到水印图片的高
        switch ($indiaimagetype[2]) { //判断水印图片的格式
         case 1 :
          $indiaimagetype = "gif";
          $logo = imagecreatefromgif($this->indiaimage);
          break;
         case 2 :
          $indiaimagetype = "jpg";
          $logo = imagecreatefromjpeg($this->indiaimage);
          break;
         case 3 :
          $indiaimagetype = "png";
          $logo = imagecreatefrompng($this->indiaimage);
          break;
        }
        imagealphablending($im, true); //打开混色模式
        imagecopy($im, $logo, $this->indiaimagex, $this->indiaimagey, 0, 0, $logow, $logoh);
        imagedestroy($im);
        imagedestroy($logo);
       }
      }
      if ($this->indiapath == "") { //如果水印存放地址不为空
       if ($filetype == "jpg") {
        imagejpeg($im, $filename);
       } else
        if ($filetype == "gif") {
         imagegif($im, $filename);
        } else
         if ($filetype == "png") {
          imagepng($im, $filename);
         }
       if($reimage == true){
        $this->goreimagesize($filename,$filetype);
       }else{
        return true; //添加水印成功
       }
      } else {
       if (!file_exists($this->indiapath)) {
        mkdir($this->indiapath);
        return false; //请重新上传
       } else {
        $indianame = basename($filename);
        $indianame = $this->indiapath . $indianame;
        if ($filetype == "jpg") {
         imagejpeg($im, $indianame);
        } else
         if ($filetype == "gif") {
          imagegif($im, $indianame);
         } else
          if ($filetype == "png") {
           imagepng($im, $indianame);
          }
        if($reimage == true){
         $this->goreimagesize($indianame,$filetype);
         echo $indianame;
        }else{
         return true; //添加水印成功
        }
       }
      }
     }
     function goreimagesize($filename, $filetype) {
      if (!file_exists($filename)) {
       return false; //要生成缩略图的图片不存在
      } else {
       if ($filetype == 'jpg') {
        $reimage = imagecreatefromjpeg($filename);
       }
       elseif ($filetype == 'png') {
        $reimage = imagecreatefrompng($filename);
       } else
        if ($filetype == 'gif') {
         $reimage = imagecreatefromgif($filename);
        }
       if (isset ($reimage)) {
        $srcimagetype = getimagesize($filename);
        $srcimagetypew = $srcimagetype[0]; //得到原始图片宽度
        $srcimagetypeh = $srcimagetype[1]; //得到原始图片高度
        $reim = imagecreatetruecolor($this->reimagesize[1], $this->reimagesize[2]);
        imagecopyresized($reim, $reimage, 0, 0, 0, 0, $this->reimagesize[1], $this->reimagesize[2], $srcimagetypew, $srcimagetypeh);
        $reimagepath = $this->reimagesize[3];
        if ($reimagepath != "") { //如果存放水印地址不为空
         if (!file_exists($reimagepath)) {
          mkdir($reimagepath);
         } else {
          $reimagename = basename($filename);
          $reimagename = $reimagepath . "r_" . $reimagename;
          if ($filetype == "gif")
           imagegif($reim, $reimagename);
          else
           if ($filetype == "jpg")
            imagejpeg($reim, $reimagename);
           else
            if ($filetype == "png")
             imagepng($reim, $reimagename);
          return true;
         }
        } else {
         $filename = basename($filename);
         if($this->indiapath == ""){
          $filename = $this->filepath."r_" . $filename;
         }else{
          $filename = $this->indiapath."r_" . $filename;
         }
         if ($filetype == "gif")
          imagegif($reim, $filename);
         else
          if ($filetype == "jpg")
           imagejpeg($reim, $filename);
          else
           if ($filetype == "png")
            imagepng($reim, $filename);
         return true;
        }

       }
      }
     }

    }
    /*if ($_POST["submit"]) {
     $file = $_FILES['uploadfile'];
     $upfile = new upfile();
     echo $upfile->uploadfile($file,$filename);
     echo $filename;
    }*/
    ?>



