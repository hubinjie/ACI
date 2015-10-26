define(function() {
	
	return {
		ReverseChecked:	function (name)
		{
			var checkboxs=document.getElementsByName(name);
			for (var i=0;i<checkboxs.length;i++) {
			  var e=checkboxs[i];
			  e.checked=!e.checked;
			} 
		},
		GetCheckboxValue:function(objname){
					var chk_value =[];    
					$('input[name="'+objname+'"]:checked').each(function(){    
					   chk_value.push($(this).val());    
					});
					return chk_value; 	
		},
		GoUrl:function(url,mins)
		{
			setTimeout(function(){window.location.href=url;},mins*1000);
		},
		Countdown:function(options){
			
			var defaults = {
				id:{d:'',h:'',n:'',s:''},
				diff:60
			};
			
			var options = $.extend(defaults, options);

			window.setInterval(function(){
			var day=0,
				hour=0,
				minute=0,
				second=0;//时间默认值        
			if(options.diff > 0){
				day = Math.floor(options.diff / (60 * 60 * 24));
				hour = Math.floor(options.diff / (60 * 60)) - (day * 24);
				minute = Math.floor(options.diff / 60) - (day * 24 * 60) - (hour * 60);
				second = Math.floor(options.diff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
			}
			if (minute <= 9) minute = '0' + minute;
			if (second <= 9) second = '0' + second;
			$('#'+options.id.d).html(day+"天");
			$('#'+options.id.h).html('<s id="h"></s>'+hour+'时');
			$('#'+options.id.n).html('<s></s>'+minute+'分');
			$('#'+options.id.s).html('<s></s>'+second+'秒');
			options.diff--;
			}, 1000);
		}
	}
});