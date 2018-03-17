var app = angular.module('myApp', ['ui.router']);

app.config(['$stateProvider', function($stateProvider){
	$stateProvider
    .state('pdf', {
      url: '/pdf',
      templateUrl: "cahier_des_chargesPdf.php",
      controller: 'pdf'
    });
	/*.state('pagination', {
		url:'/pagination-form',
		templateUrl:'pagination.php',
		controller:'pagination'
	})*/


}]);


var membres = 
	[	
		{ id:1,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar6_002.jpg",
		username:"stefanprince", lastSeen:"03:14 AM", status:"admin"},
		{ id:2,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar4.jpg",
		username:"stef2", lastSeen:"03:14 AM", status:"super user"},
		{ id:3,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar7.jpg",
		username:"stef3", lastSeen:"03:14 AM", status:""},
		{ id:4,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar10.jpg",
		username:"stef4", lastSeen:"03:14 AM", status:""},
		{ id:5,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar11.jpg",
		username:"stef5", lastSeen:"03:14 AM", status:""},
		{ id:6,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar2.jpg",
		username:"stef6", lastSeen:"03:14 AM", status:""},
		{ id:7,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar3_002.jpg",
		username:"stef7", lastSeen:"03:14 AM", status:""},
		{ id:8,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar1_003.jpg",
		username:"stef8", lastSeen:"03:14 AM", status:""},

	];

var discussions=[
	{
		id:1,
		messages:[
			{
				id:1, contenu: "mon premier message", date:"12:54",
				emetteur:{ id:1,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar6_002.jpg",
		username:"stefanprince", lastSeen:"03:14 AM"},
			recepteur:{ id:2,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar4.jpg",
				username:"stef2", lastSeen:"03:14 AM"},

			},
			{
				id:2, contenu: "mon deuxieme message",date:"02:54",
				emetteur:{ id:2,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar4.jpg",
		username:"stef2", lastSeen:"03:14 AM"},
				recepteur:{ id:1,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar6_002.jpg",
				username:"stefanprince", lastSeen:"03:14 AM"},

			},
			{
				id:3, contenu: "mon troisieme message", date:"10:54",
				emetteur:{ id:2,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar4.jpg",
		username:"stef2", lastSeen:"03:14 AM"},
				recepteur:{ id:1,avatar:"Metronic%20Admin%20Theme%20%231%20_%20Admin%20Dashboard_files/avatar6_002.jpg",
				username:"stefanprince", lastSeen:"03:14 AM"},
			}
		] 

	}
]

var messages = [];


app.controller('messagerie', ['$scope', function($scope, $http,$state){
	$scope.membreCur = membres[0];
	$scope.discussions = discussions;
	var destinataire = {};

	var findDiscussion = function(destinateur, destinataire){
		for($i = 0; $i<discussions.length; $i++){
			var message = discussions[$i].messages[0];
			if( message.emetteur.id == destinateur.id && message.recepteur.id == destinataire.id){
				return discussions[$i];
			}
			else if(message.emetteur.id == destinataire.id && message.recepteur.id == destinateur.id){
				return discussions[$i];
			}
			else;
		}
		return null;
	}

	var getMembre = function(id){
		for($i=0; $i<membres.length; $i++){
			if(membres[$i].id == id)
				return membres[$i];
		}
		return null;
	}

	var a=function(){
		var i=$(".page-quick-sidebar-wrapper");
		var a=i.find(".page-quick-sidebar-chat");
		i.find(".page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list").click(function(){
			a.removeClass("page-quick-sidebar-content-item-shown")
		});
		i.find("#quick_sidebar_tab_1 .page-quick-sidebar-chat-users .media-list > .media").click(function(){
			a.addClass("page-quick-sidebar-content-item-shown");
			$('.membres').removeClass('active');
		});

		$scope.writeTo = function(id){
			destinataire = getMembre(id);
			var discus = findDiscussion($scope.membreCur, destinataire);
			if(discus)
				$scope.messages = discus.messages;
			else
				$scope.messages = [];
			$('.nav.nav-tabs .discussion').addClass('active');
			$('#quick_sidebar_tab_1.page-quick-sidebar-chat').addClass('active');
			a.addClass("page-quick-sidebar-content-item-shown");

			$('.nav.nav-tabs .membres').removeClass('active');
			$('#quick_sidebar_tab_2.page-quick-sidebar-chat').removeClass('active');
			
		};

		$('.nav.nav-tabs li a').click(function(){
			if(a.hasClass('page-quick-sidebar-content-item-shown')){
				a.removeClass("page-quick-sidebar-content-item-shown");// on annule l'action sur effectuée precedement
			}
		})
		$scope.send = function(){
			var newMessage = {};
			var e=a.find(".page-quick-sidebar-chat-user-messages");
			if($scope.message.length !==0){
				var s = function(i, date, message, destinateur, destinataire){
					newMessage = {
						id:4, contenu: message , date:date,
						emetteur:{ id:destinateur.id, avatar: destinateur.avatar, username: destinateur.username, 
							lastSeen:destinateur.lastSeen, status: destinateur.status},
						recepteur:{ id:destinataire.id,avatar:destinataire.avatar,
							username:destinataire.username, lastSeen:destinataire.lastSeen, status:destinataire.status},
					};

 					/* le preobleme viens du  remplissage de message */

					messages.push(newMessage);
					var l = discussions.length +1;
					var discus = findDiscussion(destinateur, destinataire);
					if(discus){
							discus.messages.push(newMessage);
					}
					else{
							discussions.push({id: l, messages: [newMessage]});	
					}		
					$scope.discussions = discussions;
					console.log('destinataire --'+ destinataire.id+'<---> destinateur'+ destinateur.id);
					//$scope.writeTo(destinataire.id);
					var s="";/*
					return s+='<div class="post '+i+'">',
						s+='<img class="avatar" alt="" src="{{destinateur.avatar}}"/>',
						s+='<div class="message">',s+='<span class="arrow"></span>',
						s+='<a href="#" class="name">'+destinateur.username+'</a>&nbsp;',
						s+='<span class="datetime">'+date+"</span>",s+='<span class="body">',
						s+=message,s+="</span>",s+="</div>",s+="</div>";*/
				};
				var date=new Date;
				var c=s('out', date.getHours()+":"+date.getMinutes(), $scope.message, $scope.membreCur, destinataire);
				e.append(c);
				e.slimScroll({scrollTo:"1000000px"});/* on scroll de 1000000px ( suffisament pour ateindre la fin du de la discussion et lire le dernier message)    */
				$scope.message ="";
				setTimeout(function(){
					var date=new Date; 
					var a=s('in', date.getHours()+":"+date.getMinutes(), "Lorem ipsum doloriam nibh...", destinataire, $scope.membreCur);
					a=$(a),e.append(a),e.slimScroll({scrollTo:"1000000px"})
				},1000)
			}
		};
		/* si l'on est sur le champ de saisi et que l'on presse sur la touche entrée alors appele la fonction t()*/
		a.find(".page-quick-sidebar-chat-user-form .form-control").keypress(function(i){
			return 13==i.which ? ($scope.send(),!1) : void 0
		}) 
	};
	a();
	$scope.membres = membres;

}]);

