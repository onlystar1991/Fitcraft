var site_GL;$(document).ready(function(){site_GL=new GlobalActions});var GlobalActions=function(){this.init()};GlobalActions.prototype.init=function(){this.site.actions()},GlobalActions.prototype.site={actions:function(){var t=this;$("body").on("click",".slider_wrapper .table span.btn_next",function(){var t=$(this).parents(".active"),i=t.prev();return t.removeClass("active"),i.addClass("active"),!1});var i=$(".slider_wrapper"),e=i.width(),a=i.height();$("#tableStyles").html(".slider_wrapper .table{width: "+e+"px;height: "+a+"px;}  .slider_wrapper .table img{max-width: "+e+"px;max-height: "+a+"px;}"),$(window).resize(function(){var t=$(".slider_wrapper"),i=t.width(),e=t.height();$("#tableStyles").html(".slider_wrapper .table{width: "+i+"px;height: "+e+"px;}  .slider_wrapper .table img{max-width: "+i+"px;max-height: "+e+"px;}")})}};