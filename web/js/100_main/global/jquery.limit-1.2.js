/** @author http://rustyjeans.com/jquery-inputlimiter/demo.htm**/
(function($){$.fn.extend({limit:function(b,c){return this.each(function(){var a,substringFunction,self=$(this)[0],limit=b,element=c;self.addEventListener('focus',function(){a=window.setInterval(substring,100);},false);self.addEventListener('blur',function(){clearInterval(a);substring();},false);eval("function substring(){ var length = self.value.length;if(length > limit){self.value = self.value.substring(0,limit);}"+((typeof element!='undefined')?"if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}}":"}"));substring();});}});})(jQuery);



