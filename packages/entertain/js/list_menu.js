hp.set('entertain.list_menu', {
    init: function() {
			$(document).ready(function() {
	   		$('#entertain_sort_order_by').change(function() {
					window.location.href = '?order_by=' + $(this).val() + '&released_within=' + $('#entertain_sort_released_within').val() + '&view=' + $('#entertain_sort_view').val();
	    	});
			});
			
			$(document).ready(function() {
	   		$('#entertain_sort_released_within').change(function() {
					window.location.href = '?released_within=' + $(this).val() + '&order_by=' + $('#entertain_sort_order_by').val() + '&view=' + $('#entertain_sort_view').val();
	    	});
			});
			
			$(document).ready(function() {
	   		$('#entertain_sort_view').change(function() {
					window.location.href = '?released_within=' + $('#entertain_sort_released_within').val() + '&order_by=' + $('#entertain_sort_order_by').val() + '&view=' + $('#entertain_sort_view').val();
	    	});
			});
    }
});

hp.entertain.list_menu.init();