$('#selectall').click(function(event)
{
	
	if(this.checked)
	{
		$('.checkBoxes').each(function()
		{
			this.checked = true;
		});
	}
	else
	{
		$('.checkBoxes').each(function()
		{
			this.checked = false;
		});
	}

});

var loader = "<div id=load-screen><div id=loading></div></div>";


$("body").prepend(loader);
$("#load-screen").delay(500).fadeOut(250,function()
{
	$(this).remove();
});



function loadUsersOnline() {


	$.get("../admin/includes/functions.php?onlineusers=result", function(data){

		$(".usersonline").text(data);


	});



}


setInterval(function(){

	loadUsersOnline();


},500);

tinymce.init({selector:'textarea'}); 
