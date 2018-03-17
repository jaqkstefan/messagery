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
				/*var CSStransforms = anime({
				  targets: '.dropdown-quick-sidebar-toggler',
				  scale: 2,
				  rotate: '.5turn'
				});*/
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
			/* click sur une discussion */
			/*
			i.find(".page-quick-sidebar-chat-users .media-list > .media").click(function(){
				a.addClass("page-quick-sidebar-content-item-shown")
			});
			*/
			i.find(".page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list").click(function(){
				a.removeClass("page-quick-sidebar-content-item-shown")
			});
			i.find("#quick_sidebar_tab_1 .page-quick-sidebar-chat-users .media-list > .media").click(function(){
				a.addClass("page-quick-sidebar-content-item-shown");
				$('.membres').removeClass('active');
			});

			i.find("#quick_sidebar_tab_2 .page-quick-sidebar-chat-users .media-list > .media").click(function(){
				$('.nav.nav-tabs .discussion').addClass('active');
				$('#quick_sidebar_tab_1.page-quick-sidebar-chat').addClass('active');
				a.addClass("page-quick-sidebar-content-item-shown");

				$('.nav.nav-tabs .membres').removeClass('active');
				$('#quick_sidebar_tab_2.page-quick-sidebar-chat').removeClass('active');
				
			});
			$('.nav.nav-tabs li a').click(function(){
				if(a.hasClass('page-quick-sidebar-content-item-shown')){
					a.removeClass("page-quick-sidebar-content-item-shown");// on annule l'action sur effectuée precedement
				}
			})
			var t=function(i){
				i.preventDefault();
				var e=a.find(".page-quick-sidebar-chat-user-messages");
				var t=a.find(".page-quick-sidebar-chat-user-form .form-control");
				var r=t.val();
				if(0!==r.length){
					var s = function(i,a,e,t,r){
						var s="";
						return s+='<div class="post '+i+'">',
							s+='<img class="avatar" alt="" src="Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar6_002.jpg"/>',
							s+='<div class="message">',s+='<span class="arrow"></span>',
							s+='<a href="#" class="name">'+e+'</a>&nbsp;',
							s+='<span class="datetime">'+a+"</span>",s+='<span class="body">',
							s+=r,s+="</span>",s+="</div>",s+="</div>"
						};
					var n=new Date;
					var c=s("out",n.getHours()+":"+n.getMinutes(),"Bob Nilson","avatar3",r);
					/*c=$(c),*/
					e.append(c);
					e.slimScroll({scrollTo:"1000000px"});/* on scroll de 1000000px ( suffisament pour ateindre la fin du de la discussion et lire le dernier message)    */
					t.val("");
					setTimeout(function(){
						var i=new Date; 
						var a=s("in",i.getHours()+":"+i.getMinutes(),"Ella Wong","avatar2","Lorem ipsum doloriam nibh...");
						a=$(a),e.append(a),e.slimScroll({scrollTo:"1000000px"})
					},3e3)
				}
			};
			a.find(".page-quick-sidebar-chat-user-form .btn").click(t);// appelle de la finction t() avec un click
			/* si l'on est sur le champ de saisi et que l'on presse sur la touche entrée alors appele la fonction t()*/
			a.find(".page-quick-sidebar-chat-user-form .form-control").keypress(function(i){
				return 13==i.which ? (t(i),!1) : void 0
			}) 
		};

		return { init:function(){i(),a()} }
	}();
	jQuery(document).ready(function(){QuickSidebar.init()});

/*
jQuery(document).ready(function(){

	// contenu des fonctions 

});
*/