<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class mobileplugin_strong_a1 {    
    
    public function common(){
        global $_G;       
        $strongset = $_G['cache']['plugin']['strong_a1'];
        
  
        
        
        if($_G['basescript']=='forum' and $_G['gp_mod']=='guide'){            
           $_GET['view'] = !$_GET['view'] ? 'newthread' : $_GET['view']; 
        }
        
    }
    
   	function discuzcode($value){
		global $_G; 
    
		if($value['caller'] == 'discuzcode'){
			$message = $value['param'][0];
			preg_match_all("/\[img(.*?)\](.*?)\[\/img\]/", $message, $matches);
			if(!count($matches[0])) return '';
			$find = $matches[0];
			$replace = array();
			foreach ($matches[2] as $pval) {
				$replace[] = "<img src=".$pval." />";
			}
           
			$_G['discuzcodemessage']  = str_replace($find, $replace, $message);
		}
	}

}


class mobileplugin_strong_a1_forum extends mobileplugin_strong_a1{
    
    public function viewthread_top_mobile_output(){
        global $_G;    
        $strongset = $_G['cache']['plugin']['strong_a1'];
       
        if($strongset['grade_bg']){
            $return = '<style>';
            foreach(explode("\n",$strongset['grade_bg']) as $key=>$val){
                $valarr = explode(',',$val);
                $return .= '.lv_bg_'.$valarr[0].'{background:'.$valarr[1].' !important;}';
            
            
            }
            $return .= '</style>';
            return $return;
        }
        
    }
    
    
}


?>
