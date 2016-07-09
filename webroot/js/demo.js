/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */
 
$(function (event)
{
	/*
	$('.btn').click(function(event)
	{
		event.preventDefault();
		return false;
	});
	*/
	
	$('.btn-primary').prop('disabled', true);
	$('.btn-danger').attr("onclick", 'alert("デモモードの為、削除できません");');
	
	$('.btn-primary[value="+ 追加"]').prop('disabled', false);
	$('.btn-primary[value="追加"]').prop('disabled', false);
	$('.btn-primary[value="検索"]').prop('disabled', false);
	$('.btn-add').prop('disabled', false);
	$('.btn[value="ログイン"]').prop('disabled', false);
	
	if(location.href.indexOf('admin') > 0)
	{
		$("#UserUsername").val("root");
		$("#UserPassword").val("pass");
	}
	else
	{
		var day = ((new Date()).getDay()+1);
		
		$("#MemberUsername").val("20001");
		$("#MemberPassword").val("pass");
	}
});

