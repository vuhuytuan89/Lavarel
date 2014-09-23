var megadrop = function ()
{
	var pub = {};
	var self = {};	
	
	pub.init = function ()
	{
		// Add the class hasSubNav to list items if they have a child
		// subNav element.
		$("#megadropdown li").hover (function ()
		{
            var target = $( this );
				target.addClass ("hover");
		});

        $("#megadropdown li").mouseleave(function (){
            var target = $( this );
            target.removeClass("hover");
        });
	}
	return pub;
}();