
		function selectAll() {
        var items = document.getElementsByName('checkboxes[]');
        for (var i = 0; i < items.length; i++) {
            if (items[i].type == 'checkbox')
                items[i].checked = true;
            else{
            	 items[i].checked = false;
            }
        }
        
    }
   