<?php

namespace ex_phy_nullify
{
	function init() 
	{
		eval(import_module('itemmain'));
		$itemspkinfo['B'] = '伤害抹消';
	}
	
	function get_ex_phy_nullify_proc_rate(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		return 95;
	}
	
	//注意这个函数返回的必须是一个数组
	function check_physical_nullify(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger'));
		$ex_def_array = \attrbase\get_ex_def_array($pa, $pd, $active);
		if (in_array('B', $ex_def_array))
		{
			$proc_rate = get_ex_phy_nullify_proc_rate($pa, $pd, $active);
			$dice = rand(0,99);
			if ($dice<$proc_rate)
			{
				if ($active)
					$log .= "<span class=\"yellow\">你的攻击完全被{$pd['name']}的装备吸收了！</span><br>";
				else  $log .= "<span class=\"yellow\">{$pa['name']}的攻击完全被你的装备吸收了！</span><br>";
				$pd['physical_nullify_success'] = 1;
			}
			else
			{
				if ($active)
					$log .= "纳尼？{$pd['name']}的装备使攻击无效化的属性竟然失效了！<br>";
				else  $log .= "纳尼？你的装备使攻击无效化的属性竟然失效了！<br>";
			}
		}
		return Array();
	}
	
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		return array_merge(check_physical_nullify($pa, $pd, $active), $chprocess($pa, $pd, $active));
	}
	
	function check_physical_def_attr(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//如果已经抹消成功，不再计算减半
		if ($pd['physical_nullify_success']) return Array();
		return $chprocess($pa, $pd, $active);
	}
	
	function put_charge_success_words(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//如果抹消成功，冲击属性失效
		if ($pd['physical_nullify_success'])
		{
			$pa['physical_charge_success'] = 0;
			return Array();
		}
		return $chprocess($pa, $pd, $active);
	}
	
	function get_physical_dmg(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//抹消成功则只有1点伤害了
		if ($pd['physical_nullify_success']) return 1;
		return $chprocess($pa, $pd, $active);
	}
	
	//战前清空标记
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$pd['physical_nullify_success'] = 0;
		$chprocess($pa, $pd, $active);
	}
}

?>
