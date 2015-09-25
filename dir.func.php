<?php

//读取最外层的内容
function readDirectory($path){
	$handle = opendir($path);
	while(($item=readdir($handle))!==false){
		//去掉.和..
		if($item!='.' && $item!='..'){
			if(is_file($path.'/'.$item)){
				$arr['file'][] = $item;
			}
			if(is_dir($path.'/'.$item)){
				$arr['dir'][] = $item;
			}
		}
	}
	closedir($handle);
	return $arr;
}
/*$path = 'file';
print_r(readDirectory($path));*/


//读取目录大小
function dirSize($path){
	$sum = 0;
	global $sum;                                                  //使$sum变成全局变量
	$handle = opendir($path);
	while(($item=readdir($handle))!==false){
		//去掉.和..
		if($item!='.' && $item!='..'){
			if(is_file($path.'/'.$item)){
				$sum += filesize($path.'/'.$item);
			}
			if(is_dir($path.'/'.$item)){
				$func = __FUNCTION__;
				$func($path.'/'.$item);
			}
		}
	}
	closedir($handle);
	return $sum;
}

//复制目录
function copyFolder($src, $dst){
	if(!file_exists($dst)){
		mkdir($dst, 0777, true);
	}

	$handle = opendir($src);
	while(($item = readdir($handle))!== false){
		if($item!='.' && $item!='..'){
			if(is_file($src.'/'.$item)){
				copy($src.'/'.$item, $dst.'/'.$item);
			}

			if(is_dir($src.'/'.$item)){
				$func = __FUNCTION__;
				$func($src.'/'.$item, $dst.'/'.$item);
			}
		}
	}
	closedir($handle);
	return "复制成功";
}

?>