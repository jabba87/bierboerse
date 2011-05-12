$(document).ready(function(){
	var timer = window.setTimeout(function(){
		location.href=location.href;
	},5000);

	//Tasten abfangen
	$(window).keypress(function(event){
		if ((event.keyCode >= 112) && (event.keyCode <= 123)){
			clearTimeout(timer);
		
			var beers = [];
			$(".beers").each(function(){
				beers.push($(this));
			});

			var i = event.keyCode-112; 
			
			if(!event.shiftKey){
				beers[i].val(parseInt(beers[i].val())+1);
			}else{
				if(beers[i].val()>0)
					beers[i].val(parseInt(beers[i].val())-1);
			}

			var costs = [];
			$(".cost").each(function(){
				costs.push($(this));
			});

			// Summieren
			var sum = 0;
			for(var i=0;i<costs.length;i++)
				sum += parseInt(costs[i].text() * beers[i].val() * 10); 
			$("#sum").text(sum / 10);

			// F1-F12 Shortcuts deaktivieren
			return false;			

		}else if (event.keyCode == 13){
			clearTimeout(timer);
			$('#sub').trigger('click');
		}
	});

});