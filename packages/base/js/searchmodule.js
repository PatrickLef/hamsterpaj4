hp.set('packages.searchmodule', {
    init: function() {
	$(document).ready(function() {
	    hp.packages.searchmodule.ready();
	})
    },
    
    ready: function() {
	var self = this;
	
	this.search = $('#ui_multisearch');
	this.default_text = this.search.val();
	
	this.search.focus(function() {
	    if ( self.search.val() === self.default_text ) {
		self.search.val('');
	    }
	}).blur(function() {
	    if ( self.search.val() === '' ) {
		self.search.val(self.default_text);
	    }
	});
    }
});

hp.packages.searchmodule.init();