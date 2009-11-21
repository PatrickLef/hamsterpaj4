hp.set('packages.livesearch', {
    timer: {},
    
    init: function() {
	$(document).ready(function() {
	    hp.packages.livesearch.ready();
	});
    },
    
    ready: function() {
	var self = this;
	
	$('.livesearch').each(function() {
	    new hp.packages.livesearch.SearchBox(this);
	});
    },
    
    /*
	Class:
	    SearchBox
	
	A class for searchboxes using /livesearch as gateway.
    */
    
    SearchBox: hp.Class({
	init: function(box) {
	    var self = this;
	    
	    this.box = $(box);
	    this.input = this.box.find('.searchquery');
	    this.suggestions = this.box.find('.suggestions');
	    
	    this.box.submit(function() {
		return self.go_to();
	    });
	    
	    this.input.bind('keypress keydown', function(event) {
		if ( event.keyCode == 38 || event.keyCode == 40 )
		    event.preventDefault();
	    });
	    
	    this.input.keyup(function(event) {
		if ( event.keyCode == 38 ) {
		    self.change(-1); // up
		    return false;
		} else if ( event.keyCode == 40 ) {
		    self.change(1); // down
		    return false;
		}
		
		var inputString = self.input.val();
		clearTimeout(self.timer);
		
		if( inputString.length == 0 )
		    self.suggestions.fadeOut(); // Hide the suggestions box
		else {
		    self.timer = setTimeout(function() {
			self.search(inputString);
		    }, 500);
		}
		return true;
	    });
	},
	
	search: function(inputString, parent) {
	    var self = this;
	    $.post('/livesearch/ajax', {queryString: inputString}, function(data) {		
		self.suggestions.fadeIn(); // Show the suggestions box
		self.suggestions.html(data); // Fill the suggestions box
	    });
	},
	
	go_to: function(event) {
	    var active = this.get_active();
	    if ( ! active.length )
		return true;
	    window.location = active.attr('href');
	    return false;
	},
	
	change: function(delta) {
	    var items = this.get_items();
	    var active = this.get_active();
	    var length = items.length;
	    
	    if ( length === 0 )
		return false;
	    
	    if ( ! active.length ) {
		this.set_active((delta === -1) ? length - 1 : 0);
	    } else {
		var index = items.index(active) + delta;
		
		if ( index <= -1 )
		    this.set_active(false);
		else if ( index >= length )
		    this.set_active(false);
		else
		    this.set_active(index);
	    }
	    return true;
	},
	
	set_active: function(index) {
	    this.items.removeClass('active');
	    if ( false !== index )
		$(this.items[index]).addClass('active');
	},
	
	get_items: function() {
	    this.items = this.suggestions.find('a');
	    return this.items;
	},
	
	get_active: function() {
	    this.active = this.suggestions.find('.active');
	    return this.active;
	}
    })
});

hp.packages.livesearch.init();