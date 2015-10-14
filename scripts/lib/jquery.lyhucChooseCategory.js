(function($) {
     $.fn.lyhucChooseCategory = function(options) {
	
		var element = this;
		var curLevel = 1 ;
		var id_1,id_2,id_3,id_4;
		var nextbtn;
		var curCid=0,curBid=0,minLevel=0;
		
		var defaults = {
			id:{cid:'cid',bid:'bid'},
			btn:"nextsubmit"
		};
		
		var options = $.extend(defaults, options);

		(function init(){
			$("<div id=\"loadingbar\"><div><img src=\"statics/images/ajax-loader.gif\" /> <span>加载中...</span></div></div>").insertBefore(element);
			$(" <div class=\"clearfix\"></div><Br/><div id=\"tips\"><div>您当前选择的是：<span></span></div></div>").insertAfter(element);
			var leftpx=element.width()/2;
			leftpx-=$("#loadingbar").width()/2;
			
			var toppx=element.height()/2;
			toppx-=$("#loadingbar").height()/2;
			
			$("#loadingbar").css("left",leftpx);
			$("#loadingbar").css("top",toppx);
			$("#loadingbar").hide();
			
			nextbtn=$("#"+options.btn);
			nextbtn.attr("disabled","disabled");
			
			$("#loadingbar").ajaxSend(function(evt, request, settings){
			   $(this).show();
			 });
			 
			$("#loadingbar").ajaxStart(function(){
			   $(this).show();
			 });
			 
			 $("#loadingbar").ajaxStop(function(){
			   $(this).hide();
			 });
			 
			 $("#loadingbar").ajaxSuccess(function(){
			   $(this).hide();
			 });
			 
			
			
		})();
		
		return this.each(function(){
			
			var loadCatOption=function(level,pid){
					nextbtn.attr("disabled","disabled");
	
					//window.open('/api.php?op=get_topinfo&act=ajax_getitemcats&pid='+pid);
					$.getJSON('/TaobaoApi/ItemcatsGetRequest/json/'+pid,function(data) {
						 var firstCityValue=0;
						 var childLenth=0;
						 var loadNext=false;
						 
						  if(data!=null)
						  {	
							   if($("#catid-depth-"+level).length==0){
									$("<div  id=\"catid-depth-"+level+"\" class=\"col-md-3\"></div>").appendTo($("#rootCats"));	
								} 
							   control=$("#catid-depth-"+level);
							   control.empty();
							   
							   var nextLevel=parseInt(level)+1;
							   var next_exists  = $("#catid-depth-"+nextLevel).length;
							   
							   while(next_exists)
							   {
								   $("#catid-depth-"+nextLevel).remove();
								   nextLevel++;
								   next_exists  = $("#catid-depth-"+nextLevel).length;
								   
							   }
							   nextLevel=parseInt(level)+1;
							   
							   
							   
							   $.each(data, function(i,item){
									if(i==0)firstCityValue=item.id;
									$("<div  cid='"+item.cid+"' id='item"+item.cid+"' level='"+nextLevel+"' >"+item.name+"</div>").appendTo(control);
									
									$("#item"+item.cid).click(function(){
																	 curLevel=$(this).attr("level");
																	 curCid=$(this).attr("cid");
																	 curBid=0;
																	 loadCatOption(curLevel,curCid);
																	  //清空选中项
																	 $("div[level='"+curLevel+"']").each(function(){
																		$(this).attr("class","");
																	 });
																	 //增加选中项
																	 $(this).attr("class","over");
																	 
																	 getSelectOptionText();
																  });
									childLenth++;
							 });
							 
						}else
						{
							nextbtn.removeAttr("disabled");
						}
					});
			}
			
			var getSelectOptionText=function()
			{
				var tips_select="";
				for(var i=0;i<curLevel-1;i++)
				{
					
					if(i<curLevel-2)
						tips_select+=($(".over").eq(i).text())+"》";
					else
						tips_select+=($(".over").eq(i).text());
				}
				
				$("#tips span").text(tips_select);
				$("#"+options.id.cid).val(curCid);
				$("#"+options.id.bid).val(curBid);
			}
			
			 $("#loadingbar").ajaxError(function(){
			   $("#loadingbar span").text("加载失败，请正重试，请稍候...");
			   loadCatOption(curLevel,curCid);
			 });
			 
			loadCatOption(curLevel,0);

		});
    };
})(jQuery);

