var searchInputDelay=false;Array.prototype.in_array=function(p_val){for(var i=0,l=this.length;i<l;i++){if(this[i]==p_val){return true;}}
return false;};function showError(msg)
{$.notify(msg,{status:'error'});}
function showWarning(msg)
{$.notify(msg,{status:'warning'});}
function showSuccess(msg,position)
{var pos='top-right';if(typeof position!='undefined'){if(position==5)
pos='bottom-right';}
$.notify(msg,{status:'success',pos:pos});}
function ending(numeric,type)
{if(typeof type=='undefined')
type='0';return GetStringEndingNumeric(parseInt(numeric),type);}
function GetStringEndingNumeric(Numeric,type)
{var Ending={'0':{1:'',2:'а',3:'ов'},'3':{1:'е',2:'я',3:'й'},'8':{1:'',2:'о',3:'о'},'days':{1:'день',2:'дня',3:'дней'},'month':{1:'месяц',2:'месяца',3:'месяцев'}};var str='';switch(Numeric){case 11:case 12:case 13:case 14:str=Ending[type][3];break;}
if(!str){var LastTen=Numeric%10;switch(LastTen){case 1:str=Ending[type][1];break;case 2:case 3:case 4:str=Ending[type][2];break;case 5:case 6:case 7:case 8:case 9:case 0:str=Ending[type][3];break;}}
return str;}
function stristr(haystack,needle,bool)
{var pos=0;haystack+='';pos=haystack.toLowerCase().indexOf((needle+'').toLowerCase());if(pos==-1){return false;}
else{if(bool){return haystack.substr(0,pos);}
else{return haystack.slice(pos);}}}
jQuery.fn.extend({loader:function(status){if(status)
$(this).prepend('<div class="loader"><div class="loader-background color-flip"></div><img class="loader-icon spinning-cog" src="/design/images/icons/loader.svg"></div>');else
$(this).find('.loader').remove();}});$(function(){$('body').tooltip({selector:'[data-toggle=tooltip]'});$('.page').on('click','input[type=text][readonly=readonly],textarea[readonly=readonly]',function(){$(this).select();});$('[data-toggle="scroll"]').on('click',function(event){var $anchor=$(this);$('html, body').stop().animate({scrollTop:$($anchor.attr('href')).offset().top- 85},200);event.preventDefault();});$('[data-toggle="sidebar"], #m_helper').click(function(){$('.wrapper').toggleClass('sidebar-on')});$('.nav-sidebar').metisMenu();$('.page').on('click','[data-toggle="widget-promo-code"]',function(event){event.preventDefault();$(this).closest('.widget').toggleClass("widget-promo-code");});$('.paper img').on('click',function(event){event.preventDefault();var src=$(this).attr('src');var alt=$(this).attr('alt');$('#imgModalBlank').attr('href',src);$('#imgModalImg').attr({src:src,alt:alt});$('#imgModal').modal('show');});$('#send_confirm_email').click(function(){var link=$(this);$.post($(this).attr('href'),function(data){var status=$.parseJSON(data);if(status.error){showError(status.msg);}
else{showSuccess(status.msg);}
link.replaceWith(link.text());});return false;});$('#send_confirm_newemail').click(function(){var link=$(this);$.post($(this).attr('href'),function(data){var status=$.parseJSON(data);if(status.error){showError(status.msg);}
else{showSuccess(status.msg);}
link.replaceWith(link.text());});return false;});$('.js-bottombar-bossfeed-close').click(function(){var link=$(this);$.post($(this).data('href'),function(data){if(!data.error){link.closest('.bottombar-bossfeed').remove();$('.wrapper.bottombar-on').removeClass('bottombar-on');}},'json');return false;});var loader=$('#pageLoader'),loaderIcon=loader.find('.loader-icon');loaderIcon.removeClass('spinning-cog').addClass('shrinking-cog');loader.delay(500).fadeOut(function(){loader.remove();});});