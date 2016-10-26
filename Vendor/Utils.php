<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

// ユーティリティクラス
class Utils
{
	//------------------------------//
	//	コンストラクタ				//
	//------------------------------//
	public function Utils()
	{
	}
	
	public static function getYMD($str)
	{
		return substr($str, 0, 10);
	}

	public static function getYMDHN($str)
	{
		return substr($str, 0, 16);
	}
	
	public static function showItem($label, $value)
	{
?>
		<div class="form-group">
			<label for="MemberWorkName1" class="col col-md-3 col-sm-4 control-label"><?php echo __($label); ?></label>
			<div class="col col-md-9 col-sm-8"><div class="show-item"><?php echo h($value); ?></div></div>
		</div>
<?php
	}
	
	public static function getHNSBySec($sec)
	{
		$hour	= floor($sec / 3600);
		$min	= floor(($sec / 60) % 60);
		$sec	= $sec % 60;
		
		$hms = sprintf("%02d:%02d:%02d", $hour, $min, $sec);
		
		return $hms;
	}

}

