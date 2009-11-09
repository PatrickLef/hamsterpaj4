hp.set('packages.steve', {
    hide_timeout: 0,
    
    init: function() {
	$(document).ready(function() {
	    hp.packages.steve.initSteve($('#steve'));
	});
    },
    
    initSteve: function(steve) {
	var self = this;
	
	this.comments_length = this.comments.length - 1;
	this.create_box();
	
	steve.click(function() {
	    self.set_random();
	    
	    self.show_box(function() {
		clearTimeout(self.hide_timeout);
		self.hide_timeout = setTimeout(function() {
		    self.hide_box();
		}, 3500);
	    });
	});
    },
    
    create_box: function() {
	this.box = $('<div id="steve_say" />').css('top', -500).appendTo(document.body);
    },
    
    set_random: function() {
        this.box.text('Steve hälsar: ' + this.comments[hp.util.random(0, this.comments_length)]);
    },
    
    show_box: function(callback) {
	this.box.css({
	    left: $(window).width() / 2 - this.box.width() / 2,
	    opacity: 1
	});
	this.box.animate({
	    top: $(window).height() / 2 - this.box.height() / 2
	}, callback);
    },
    
    hide_box: function() {
	this.box.animate({
	    top: -500,
	    opacity: 0
	}, function() {
	    $(this).css({
		top: -500
	    });
	});
    },
    
    comments: [
    	'Hamsterpaj startades i Oktober 2003',
	'Mitt namn är Steve, och jag är importerad från den gamla webbsiten megadomain',
	'Hamsterpaj består av över tjugo tusen rader programkod',
	'.... . .- ...- . -. /  .. ... /  .- /  .--. .-.. .- -.-. . /  --- -. /  . .- .-. - .... ',
	'Hamsterpajs första server stog på en balkong, hade en överklockad processor på 700mhz och hela 384mb i RAM.',
	'Vår fina webbsite har bott i Göteborg, USA, Holland och Östersund',
	'Namnet hamsterpaj kommer från ordet MUSTERAPI som stog skrivet på tavlan när klass 1A började på Portalens Gymnasium under hösten 2003',
	'Adolf Hitler hade bara en pungkula',
	'I Norge heter han inte stålmannen, han heter Metallgutten!',
	'Det visade sig att dom på nåt vänster hade rostat Lennart och lagt honom i en liten brun kruka som dom skulle gräva ner',
	'När Gun ringde lite senare lät hon lite som en pnenumatisk borrannordning',
	'Jag har haft baksug i mitt köksavlopp, så nu är tapeten brun',
	'Rökare är också människor, fast inte lika länge',
	'Vad är volymen av en pizza om radien är z och höjden a? Svar: Pi z z a',
	'Du måste låta henne slappna av, komma i rätt stämning, först då kan... (Henrik under arbetet)',
	'I Ungern är snorkråkor fika.',
	'2001 försökte Honda lansera bilen Honda Fitta i Sverige. Så småningom bytte de namn till Honda Jazz.',
	'Alzheimers - nya vänner varje dag!',
	'Jag försov mig den dagen det delades ut hjärnor',		
	'Sett på vodkaflaskan: Bäst före: Dagen efter',
	'En del lejon parar sig upp till 50 gånger om dagen',
	'Råttor kan inte kräkas',
	'Fladdermusen är det enda däggdjur som kan flyga',
	'Geparden är det enda kattdjuret som inte kan gömma sina klor',
	'Lössen kan hoppa 350 gånger sin kroppslängd',
	'En termitsdrottning kan leva i 50 år och avla fram 30000 tusen termiter varje dag',
	'Om en guldfisk hålls i ett mörkt rum så blir den vit',
	'Den genomsnittliga husflugan lever endast i två veckor',
	'Isbjörnens päls är egentligen inte vit utan transparent',
	'En ekorre äter 40000 tallkottar varje år',
	'Sniglar kan sova i fem år',
	'En blåvals hjärta slår endast 9 gånger per minut',
	'Kolibrin är den enda fågeln som kan flyga baklänges',
	'Fiskfjäll används i läppstift',
	'Färska ägg flyter inte i vatten men det gör gamla ägg',
	'En mulåsna flyter på kvicksand men det gör inte en åsna',
	'Man kan göra 11 omeletter på ett stutsägg',
	'Den senaste gången det snöade i Saharaöknen var den 18 februari 1979',
	'Ingen vet var Mozart är begraven',
	'Charles Lindbergh hade endast 4 smörgåsar med sig när han flög över Atlanten',
	'Det finns över 300 olika typer av honung',
	'Beethoven blötte sitt hår innan han skulle komponera musik',
	'Hjärnskador börjar uppstå redan vid kroppstemperaturer på 40,5 grader',
	'Anne Boleyn hade tre bröst',
	'Brandlarmet uppfanns 1969',
	'Adolf Hitlers mamma blev övertygad av sin husläkare att inte göra abort',
	'Nästan 25% av jordens befolkning lever i Kina',
	'När månen står som högst så väger du något mindre',
	'Världshistoriens kortaste krig utspelades år 1896 mellan Zanzibar och Storbritannien och varade i hela 38 minuter',
	'Om man skulle rada upp alla röda blodkroppar som du har i kroppen så skulle ledet räcka 2,5 varv runt jorden',
	'När man nyser så avstannar alla kroppsfunktioner t.o.m. hjärtat',
	'En nyfödd har 300 st ben i kroppen men en vuxen bara 206 st',
	'Hjärnskador börjar uppstå redan vid kroppstemperaturer på 40,5 grader',
	'Joar: Ligger inte Sarajevo i lappland?',
	'Lef-91: Varför är det så svårt att få upp saker ibland?',
	'Felstvaningarna är en del av skärmen med Hamsterpaj'
    ]
});

hp.packages.steve.init();