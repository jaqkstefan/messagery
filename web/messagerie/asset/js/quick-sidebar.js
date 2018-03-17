var QuickSidebar=function(){
		var i=function(){
			/*$(".dropdown-quick-sidebar-toggler a, .page-quick-sidebar-toggler, .quick-sidebar-toggler").click(function(i){
				$("body").toggleClass("page-quick-sidebar-open");
			})},*/
			$(".page-quick-sidebar-toggler").click(function(i){
				$(this).removeClass("page-quick-sidebar-open");
				$(".page-quick-sidebar-wrapper").removeClass("page-quick-sidebar-open");
			}),

			$(".dropdown-quick-sidebar-toggler a").click(function(i){
				$(".page-quick-sidebar-toggler").addClass("page-quick-sidebar-open");
				$(".page-quick-sidebar-wrapper").addClass("page-quick-sidebar-open");
			})
		};

		/* elle permet de personnaliser le scroll */
		var a=function(){
			var i=$(".page-quick-sidebar-wrapper");
			var a=i.find(".page-quick-sidebar-chat");
		
			var e=function(){
				var e,t=i.find(".page-quick-sidebar-chat-users");
				e=i.height()-i.find(".nav-tabs").outerHeight(!0),App.destroySlimScroll(t),
				t.attr("data-height",e),App.initSlimScroll(t);
				var r=a.find(".page-quick-sidebar-chat-user-messages"),
				s=e-a.find(".page-quick-sidebar-chat-user-form").outerHeight(!0);
				s-=a.find(".page-quick-sidebar-nav").outerHeight(!0),App.destroySlimScroll(r),r.attr("data-height",s),
				App.initSlimScroll(r)
			};
			e();
			App.addResizeHandler(e);



		};

		return { init:function(){i(),a()} }
	}();
	jQuery(document).ready(function(){QuickSidebar.init()});

/*
jQuery(document).ready(function(){

	// contenu des fonctions 

});
*/