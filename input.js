function calc (i,plus){
	// Amounts aktualisieren
	var amounts = [];
	$(".amounts").each(function(){
		amounts.push($(this));
	});
	
	// Costs holen
	var costs = [];
	$(".costs").each(function(){
		costs.push($(this));
	});

	if(plus){
		amounts[i].val(parseInt(amounts[i].val())+1);
	}else{
		if(amounts[i].val()>0)
			amounts[i].val(parseInt(amounts[i].val())-1);
	}

	// Summieren
	var sum = 0;
	for(var i=0;i<costs.length;i++)
		sum += parseInt(costs[i].text() * amounts[i].val() * 10); 
	$('#sum').text(sum / 10);
}

$(document).ready(function(){
	var timer = window.setTimeout(function(){
		location.href=location.href;
	},5000);

	//Tasten abfangen
	$(window).keypress(function(event){
		if ((event.keyCode >= 112) && (event.keyCode <= 123)){
			clearTimeout(timer);

			if(event.shiftKey){
				calc(event.keyCode-112,false);
			}else{
				calc(event.keyCode-112,true);
			}
			
			// F1-F12 Shortcuts deaktivieren
			return false;			
		}else if (event.keyCode == 13){
			clearTimeout(timer);
			$('#sub').trigger('click');
		}
	});
	
	$("input.plus").click(function(){
		clearTimeout(timer);
		var i = $(this).attr('id')-1;
		calc(i,true);
	});
	
	$("input.minus").click(function(){
		clearTimeout(timer);
		var i = $(this).attr('id')-1;
		calc(i,false);
	});
});