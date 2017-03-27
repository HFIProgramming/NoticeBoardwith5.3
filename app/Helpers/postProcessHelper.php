<?php

if (!function_exists('postProcess') && true) {

	/**
	 * temporary solution for processing post before editor is implemented
	 * This method is from NoticeBoard 2.0
	 * @TODO 在做完tinymce的兼容之后，删掉这个helper函数
	 *
	 * @param
	 * @return
	 */
	function postProcess($str, $attributes = array()) {
			$attrs = '';
			foreach ($attributes as $attribute=>$value) {
				$attrs .= " {$attribute}=\"{$value}\"";
			}

			$str=str_replace('  ','&nbsp;'.' ',$str);
		 	$str=str_replace('<','&lt;',$str);
		  	$str=str_replace('>','&gt;',$str);
		  	$str = nl2br($str);
			
			$str = str_replace("[img-src]","<img style='max-width:100%;' class='scroll-load-image' src='/assets/images/blank.png' data-url='",$str);
			$str = str_replace("[img-end]","'>",$str);
			
			$str = ' '.$str;
			$str = preg_replace('`([^"=\'>])((http|https|ftp|ftps)://[^\s< ]+[^\s<\.)])`i', '$1<a href="$2" rel="external nofollow" '.$attrs.'>$2</a>', $str);
			$str = substr($str, 1);
			
			return $str;
		}
}
