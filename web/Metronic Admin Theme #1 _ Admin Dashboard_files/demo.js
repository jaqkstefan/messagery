var Demo=function(){var e=function(){var e=$(".theme-panel");$("body").hasClass("page-boxed")===!1&&$(".layout-option",e).val("fluid"),$(".sidebar-option",e).val("default"),$(".page-header-option",e).val("fixed"),$(".page-footer-option",e).val("default"),$(".sidebar-pos-option").attr("disabled")===!1&&$(".sidebar-pos-option",e).val(App.isRTL()?"right":"left");var a=function(){$("body").removeClass("page-boxed").removeClass("page-footer-fixed").removeClass("page-sidebar-fixed").removeClass("page-header-fixed").removeClass("page-sidebar-reversed"),$(".page-header > .page-header-inner").removeClass("container"),1===$(".page-container").parent(".container").size()&&$(".page-container").insertAfter("body > .clearfix"),1===$(".page-footer > .container").size()?$(".page-footer").html($(".page-footer > .container").html()):1===$(".page-footer").parent(".container").size()&&($(".page-footer").insertAfter(".page-container"),$(".scroll-to-top").insertAfter(".page-footer")),$(".top-menu > .navbar-nav > li.dropdown").removeClass("dropdown-dark"),$("body > .container").remove()},o="",t=function(){var t=$(".layout-option",e).val(),i=$(".sidebar-option",e).val(),r=$(".page-header-option",e).val(),d=$(".page-footer-option",e).val(),s=$(".sidebar-pos-option",e).val(),n=$(".sidebar-style-option",e).val(),p=$(".sidebar-menu-option",e).val(),l=$(".page-header-top-dropdown-style-option",e).val();if("fixed"==i&&"default"==r&&(alert("Default Header with Fixed Sidebar option is not supported. Proceed with Fixed Header with Fixed Sidebar."),$(".page-header-option",e).val("fixed"),$(".sidebar-option",e).val("fixed"),i="fixed",r="fixed"),a(),"boxed"===t){$("body").addClass("page-boxed"),$(".page-header > .page-header-inner").addClass("container");$("body > .page-wrapper > .clearfix").after('<div class="container"></div>');$(".page-container").appendTo("body > .page-wrapper > .container"),"fixed"===d?$(".page-footer").html('<div class="container">'+$(".page-footer").html()+"</div>"):$(".page-footer").appendTo("body > .page-wrapper > .container")}o!=t&&App.runResizeHandlers(),o=t,"fixed"===r?($("body").addClass("page-header-fixed"),$(".page-header").removeClass("navbar-static-top").addClass("navbar-fixed-top")):($("body").removeClass("page-header-fixed"),$(".page-header").removeClass("navbar-fixed-top").addClass("navbar-static-top")),$("body").hasClass("page-full-width")===!1&&("fixed"===i?($("body").addClass("page-sidebar-fixed"),$("page-sidebar-menu").addClass("page-sidebar-menu-fixed"),$("page-sidebar-menu").removeClass("page-sidebar-menu-default"),Layout.initFixedSidebarHoverEffect()):($("body").removeClass("page-sidebar-fixed"),$("page-sidebar-menu").addClass("page-sidebar-menu-default"),$("page-sidebar-menu").removeClass("page-sidebar-menu-fixed"),$(".page-sidebar-menu").unbind("mouseenter").unbind("mouseleave"))),"dark"===l?$(".top-menu > .navbar-nav > li.dropdown").addClass("dropdown-dark"):$(".top-menu > .navbar-nav > li.dropdown").removeClass("dropdown-dark"),"fixed"===d?$("body").addClass("page-footer-fixed"):$("body").removeClass("page-footer-fixed"),"light"===n?$(".page-sidebar-menu").addClass("page-sidebar-menu-light"):$(".page-sidebar-menu").removeClass("page-sidebar-menu-light"),"hover"===p?"fixed"==i?($(".sidebar-menu-option",e).val("accordion"),alert("Hover Sidebar Menu is not compatible with Fixed Sidebar Mode. Select Default Sidebar Mode Instead.")):$(".page-sidebar-menu").addClass("page-sidebar-menu-hover-submenu"):$(".page-sidebar-menu").removeClass("page-sidebar-menu-hover-submenu"),App.isRTL()?"left"===s?($("body").addClass("page-sidebar-reversed"),$("#frontend-link").tooltip("destroy").tooltip({placement:"right"})):($("body").removeClass("page-sidebar-reversed"),$("#frontend-link").tooltip("destroy").tooltip({placement:"left"})):"right"===s?($("body").addClass("page-sidebar-reversed"),$("#frontend-link").tooltip("destroy").tooltip({placement:"left"})):($("body").removeClass("page-sidebar-reversed"),$("#frontend-link").tooltip("destroy").tooltip({placement:"right"})),Layout.fixContentHeight(),Layout.initFixedSidebar()},i=function(e){var a=App.isRTL()?e+"-rtl":e;$("#style_color").attr("href",Layout.getLayoutCssPath()+"themes/"+a+".min.css"),"light2"==e?$(".page-logo img").attr("src",Layout.getLayoutImgPath()+"logo-invert.png"):$(".page-logo img").attr("src",Layout.getLayoutImgPath()+"logo.png")};$(".toggler",e).click(function(){$(".toggler").hide(),$(".toggler-close").show(),$(".theme-panel > .theme-options").show()}),$(".toggler-close",e).click(function(){$(".toggler").show(),$(".toggler-close").hide(),$(".theme-panel > .theme-options").hide()}),$(".theme-colors > ul > li",e).click(function(){var a=$(this).attr("data-style");i(a),$("ul > li",e).removeClass("current"),$(this).addClass("current")}),$("body").hasClass("page-boxed")&&$(".layout-option",e).val("boxed"),$("body").hasClass("page-sidebar-fixed")&&$(".sidebar-option",e).val("fixed"),$("body").hasClass("page-header-fixed")&&$(".page-header-option",e).val("fixed"),$("body").hasClass("page-footer-fixed")&&$(".page-footer-option",e).val("fixed"),$("body").hasClass("page-sidebar-reversed")&&$(".sidebar-pos-option",e).val("right"),$(".page-sidebar-menu").hasClass("page-sidebar-menu-light")&&$(".sidebar-style-option",e).val("light"),$(".page-sidebar-menu").hasClass("page-sidebar-menu-hover-submenu")&&$(".sidebar-menu-option",e).val("hover");$(".sidebar-option",e).val(),$(".page-header-option",e).val(),$(".page-footer-option",e).val(),$(".sidebar-pos-option",e).val(),$(".sidebar-style-option",e).val(),$(".sidebar-menu-option",e).val();$(".layout-option, .page-header-option, .page-header-top-dropdown-style-option, .sidebar-option, .page-footer-option, .sidebar-pos-option, .sidebar-style-option, .sidebar-menu-option",e).change(t)},a=function(e){var a="rounded"===e?"components-rounded":"components";a=App.isRTL()?a+"-rtl":a,$("#style_components").attr("href",App.getGlobalCssPath()+a+".min.css"),"undefined"!=typeof Cookies&&Cookies.set("layout-style-option",e)};return{init:function(){e(),$(".theme-panel .layout-style-option").change(function(){a($(this).val())}),"undefined"!=typeof Cookies&&"rounded"===Cookies.get("layout-style-option")&&(a(Cookies.get("layout-style-option")),$(".theme-panel .layout-style-option").val(Cookies.get("layout-style-option")))}}}();App.isAngularJsApp()===!1&&jQuery(document).ready(function(){Demo.init()});