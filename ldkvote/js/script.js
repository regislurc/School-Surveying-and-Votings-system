$("#inputSID").keyup(function(e){
	ckey = e.which;
	if(ckey == 8 || ckey==47 ){
		$(this).trigger('keypress')
	}
})
$("#inputSID").keypress(function(){
	if($(this).val().length+2 > 2 ){
		$("#sidhelp").hide(300);
	}else{
		$("#sidhelp").show(300);
	}
});
$("#voteForm").on('submit', function(){
	// Getting votes;

	cats = $(".catcard");

	for(n=0; n<cats.length; n++){
		
		current_cat = $(cats[n]);
		catname = current_cat.find('.card-title').text();
		log($(current_cat))
		
		//Voted in this category

	}

	// /$("#ComfirmVote").modal("show");
	return false;
})
function log(data){
	console.log(data)
}