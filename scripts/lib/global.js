var TS = {};
TS.data = {}, 
TS.createFnQueue=function(a){
	var b=[];
	return{
		add:
		function(c){
		if($.isFunction(c)){
			b.push(c)
			}
		},
		exec:
		function(e){
			if(a!==false){
				while(b.length>0)
				{
					b.shift()(e)
				}
			}else{
				var c=b.length;
				for(var d=0;d<c;d++){
					if(b[d](e)===false)
					{return false}
				}
			}
		},
		clear:function(){
			b.length=0}
	}
};
TS.fn = {}, function() {
    String.prototype.Trim = function() {
        var d = this;
        d = d.replace(/^\s\s*/, "");
        var b = /\s/, c = d.length;
        while (b.test(d.charAt(--c))) ;
        return d.slice(0, c + 1);
	};
	Date.prototype.addDay=function   (num)
	{
	this.setDate(this.getDate()+num);
	return   this;
	};
	
	Date.prototype.addMonth=function   (num)
	{
	var   tempDate=this.getDate();
	this.setMonth(this.getMonth()+num);
	if(tempDate!=this.getDate())   this.setDate(0);
	return   this;
	}
	;
	Date.prototype.addYear=function   (num)
	{
	var   tempDate=this.getDate();
	this.setYear(this.getYear()+num);
	if(tempDate!=this.getDate())   this.setDate(0);
	return   this;
	} ;
	var a = window.TS || {};
	a = {"SETUP": function()
							 {
								window.TS = a;
							}, 
			"Config": {},
			"Common": {
				
			}},
	a.Config ={"URL":"/"},
	a.Common = {
		"Array":{
			"GetCheckedValue":function(objname){
					var chk_value =[];    
					$('input[name="'+objname+'"]:checked').each(function(){    
					   chk_value.push($(this).val());    
					});
					return chk_value; 	
				}
		},
		"Verify": {
						"TestRegExp": function(b, c) {
							return b = new RegExp(b), b.test(c);
						},
						"IsEmpty": function(b) {
							return typeof b != "string" ? !1 : b.Trim() != "" ? !1 : !0;
						},
						"IsNumber": function(b) {
							return typeof b == "undefined" ? !1 : isNaN(b.toString()) ? !1 : !0;
						},
						"IsLetter": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^[A-Za-z]+$/;
							return this.TestRegExp(c, b);
						},
						"IsLowerCase": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^[a-z]+$/;
							return this.TestRegExp(c, b);
						},
						"IsUpperCase": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^[A-Z]+$/;
							return this.TestRegExp(c, b);
						},
						"IsChar": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^\w+$/;
							return this.TestRegExp(c, b);
						},
						"IsCharUnderline": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^(\w*)(\_+)(\w*)$/;
							return this.TestRegExp(c, b);
						},
						"IsTelephone": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^(\((\d{2,5})\)|\d{2,5})?(\s*)(-?)(\s*)(\d{5,9})$/;
							return this.TestRegExp(c, b);
						},
						"IsPhone": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^(\+86)?1[3,4,5,8](\d{9})$/;
							return this.TestRegExp(c, b);
						},
						"IsPassword": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^[a-zA-Z0-9~!.,={}<>;:@#$%^&*()_+]+$/;
							return this.TestRegExp(c, b);
						},
						"IsEmail": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^\w+((-\w+)|(.\w+))*@[A-Za-z0-9]+((.|-)[A-Za-z0-9]+)*.[A-Za-z0-9]+$/;
							return this.TestRegExp(c, b);
						},
						"IsIdentityCode": function(b) {
							if (typeof b == "undefined") return !1;
							var c = /^[1-9](\d{5})(([1-9]\d)|([1,2](\d{3})))(0[1-9]|1[0,2])(0[1-9]|[1,2]\d|3[0,1])(\d{3})([0-9Xx]+)$/;
							return this.TestRegExp(c, b);
						}
			 },
			  "Cookie":  {
							"Get":
								function(b){
									var c=new RegExp("(^|;|\\s+)"+b+"=([^;]*)(;|$)");
									var a=document.cookie.match(c);
									return(!a?"":unescape(a[2]))
								},
							"Add":
								function(c,b,g,a,f){
									var e=c+"="+escape(b)+"; path="+(g||"/")+(f?("; domain="+f):"");
									if(a>0){var h=new Date();
									h.setTime(h.getTime()+a*1000);e+=";expires="+h.toGMTString()
									}
									document.cookie=e
								},
							"Del":function(a,b){
									document.cookie=a+"=;path=/;"+(b?("domain="+b+";"):"")+"expires="+(new Date(0)).toGMTString()
								}
						},
			 "CheckType": {
							"IsArray": function(b) {
								return b && typeof b == "object" && typeof b.length == "number" && typeof b.splice == "function";
							}
						},
			 "EncodeContent": function(b) {
							return encodeURI(b).replace(/&/g, "%26").replace(/\+/g, "%2B").replace(/\s/g, "%20").replace(/#/g, "%23");
						},
			 "getQueryString": function(b) {
							var c = new RegExp("(^|&)" + b + "=([^&]*)(&|$)", "i"), d = window.location.search.substr(1).match(c);
							return d != null ? unescape(d[2]) : null;
						},
			 "Event": function() {
										function c(d) {
											b.pageX = d.clientX + $(window).scrollLeft(), b.pageY = d.clientY + $(window).scrollTop();
										}
										var b = {
											"pageX": 0,
											"pageY": 0,
											"Set": function() {
												var d = arguments;
												if (d.length == 0) return d = null, this;
												if (d.length == 1 && typeof d[0] == "object") {
													for (var e in d[0]) this[e] = d[0][e];
													return d = null, this;
												}
												if (d.length == 2) return opt[d[0]] = d[1], d = null, this;
											}
										};
										return function(d) {
											return typeof d != "undefined" && (d = d || event, c(d)), b;
										};
							}
	},
	a.Page={
		"UI":{
				"ReverseChecked":function(name)
				{
					$("input[name='"+name+"']").each(function() {
						if (this.checked) {
							this.checked = false;
						}
						else {
							this.checked = true;
						}
					});
				},
				"UploadOneImage":function(inputId,w,h,iscallback,istopic){
						if(!w) w=screen.width-4;
						if(!h) h=screen.height-95;
						if(!iscallback)iscallback=0;
						
						$.extDialogFrame("/adminpanel/attachments/upload_file/"+inputId+"/"+iscallback+"/"+istopic,{model:true,width:w,height:h,title:'请上传图片',buttons:null});
				}
		}
	},
	a.SETUP();
}();


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

jQuery(function($){
        $.datepicker.regional['zh-CN'] = {
                closeText: '关闭',
                prevText: '<上月',
                nextText: '下月>',
                currentText: '今天',
                monthNames: ['一月','二月','三月','四月','五月','六月',
                '七月','八月','九月','十月','十一月','十二月'],
                monthNamesShort: ['一','二','三','四','五','六',
                '七','八','九','十','十一','十二'],
                dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
                dayNamesMin: ['日','一','二','三','四','五','六'],
                weekHeader: '周',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'};
        $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
		

});