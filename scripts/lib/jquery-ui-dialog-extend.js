$.extend({
		 _htmlDataArr:new Array(),
		 _findHTML:function(url){
			var hd_len= $._htmlDataArr.length;
				 for(var i=0;i<hd_len;i++)
				 {
					 if($._htmlDataArr[i][0]==url){
						return $._htmlDataArr[i][1];
					}
				 } 
			return null;
		},
		extGrowl:function(tips,options){
			 var options=$.extend({header:"系统提示"}, options);
			if(window.top.location==window.location)
			{
					$.jGrowl(tips,options);	
			}else
			{
				window.top.$.jGrowl(tips,options);	
			}
		},
		selectorDialogFrame:function(selector){
					return $("#extDialogIFrame").contents().find(selector);
		},
		DF:function(selector){return $.selectorDialogFrame(selector)},//获取iframe内容 $.DF
		extDialogFrame:function(url,options){
			 var options=$.extend({modal:true,resizable:true,buttons: {"确定": function () {},"取消":function(){$(this).dialog('close');}},title:'对话框'}, options);
			 if (typeof(options.ok) == "function") {
			   options.buttons["确定"]=options.ok;
			}   
			if (typeof(options.cancel) == "function") {
			   options.buttons["取消"]=options.cancel;
			}   
			if(options.buttons==null) 
			{
					$( "#dialog" ).html('<iframe id="extDialogIFrame" name="extDialogIFrame" src="'+url+'" width="'+(options.width-15)+'"  height="'+(options.height-70)+'" frameborder="0" allowtransparency="true"  marginheight="0" marginwidth="0" ></iframe>').dialog(options);
			}else
				$( "#dialog" ).html('<iframe id="extDialogIFrame" name="extDialogIFrame" src="'+url+'" width="'+(options.width-25)+'"  height="'+(options.height-110)+'" frameborder="0" allowtransparency="true"  marginheight="0" marginwidth="0" ></iframe>').dialog(options);
		},
		extDialogAjaxGet:function(url,options){
			 var options=$.extend({modal:true,resizable:true,callback:null,cache:true,buttons: {"确定": function () {},"取消":function(){$(this).dialog('close');}},title:'对话框'}, options);
			if (typeof(options.ok) == "function") {
			   options.buttons["确定"]=options.ok;
			}   
			if (typeof(options.cancel) == "function") {
			   options.buttons["取消"]=options.cancel;
			}   
			
			$("#dialog" ).html("正在获取中，请务关闭窗口").dialog(options);  
			 //如果存在，则不访问url
			 var _get_html= null;//= $._findHTML(url);
			 if(_get_html!=null&&options.cache){
				  
				  $( "#dialog" ).html(_get_html).dialog(options);
			}else{
				$.get(url,function(html){
						_new_get_arr= new Array();
						_new_get_arr[0]=url;
						_new_get_arr[1]=html;
						$._htmlDataArr.push(_new_get_arr);
						if(typeof(options.callback)=="function")
							options.callback(html,options);
						else	
				  			$("#dialog").html(html).dialog(options);
				});
			}
	},extDialogAjaxPost:function(url,data,options){
			
			
			 var options=$.extend({modal:true,resizable:true,callback:null,buttons: {"确定": function () {},"取消":function(){$(this).dialog('close');}},title:'对话框'}, options);
			if (typeof(options.ok) == "function") {
			   options.buttons["确定"]=options.ok;
			}   
			if (typeof(options.cancel) == "function") {
			   options.buttons["取消"]=options.cancel;
			} 
			
			$("#dialog" ).html("正在获取中，请务关闭窗口").dialog(options);  
			
			
			$.post(url,data,function(html){
					if(typeof(options.callback)=="function")
						options.callback(html,options);
					else
				  		$("#dialog" ).html(html).dialog(options);
			});
			
	},
	});
