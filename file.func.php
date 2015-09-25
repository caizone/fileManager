<?php

//转化文件大小
function transfer($size){
	$arr = array('B', 'KB', 'MB', 'GB', 'TB');
	$i = 0;
	while($size>=1024){
		$size/=1024;
		$i++;
	}
	return round($size, 2).$arr[$i];
}

//创建文件
function createFile($filename){
	//验证是否包含非法字符
	$patter = "/[\/,\*,<>,\?,\|,:]/";
	if(!preg_match($patter,basename($filename))){
		//验证文件名是否重复
		if(!file_exists($filename)){
			if(touch($filename)){
				return "文件创建成功";
			}else{
				return "文件创建失败";
			}
		}else{
			return "文件名重复";
		}
	}else{
		return "文件名非法";
	}
}

//重命名文件
function renameFile($oldname, $newname){
	//检测文件名是否合法
	if(checkFile($newname)){
		//检测是否同名
		$path = dirname($oldname);
		if(!file_exists($path.'/'.$newname)){
			if(rename($oldname, $path.'/'.$newname)){
				return "重命名成功";
			}else{
				return "重命名失败";
			}
		}
		else{
			return "文件名重复";
		}
	}
	else{
		return "非法文件名";
	}
}

//检测文件名是否合法
function checkFile($filename){
	$patter = "/[\/,\*,<>,\?,\|,:]/";
	if(preg_match($patter,$filename)){
		return false;
	}else{
		return true;
	}
}

//删除文件
function delFile($filename){
	if(unlink($filename)){
		$mes = "文件删除成功";
	}
	else{
		$mes = "文件删除失败";
	}
	return $mes;
}

//下载文件
function downFile($filename){
	header("content-disposition:attachment;filename=".basename($filename));
	header("content-length:".filesize($filename));
	readfile($filename);
}

?>