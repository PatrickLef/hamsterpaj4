/*
    Package:
	hp.util
    
    Collection of utility functions for JavaScript.
*/

hp.set('util', {
    // Borrowed from MooTools $random
    random: function(min, max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
    }
});