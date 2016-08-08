Bienvenue.Workspace=function()
{
	this.mainPanel=$('.bienvenue-panel-main');
	this.leftNavigationBar=$('.navbar-default.sidebar');
	this.topNavigationBar=$('.topNavigationBar');
	this.rippleManager=new Bienvenue.Component.Ripple();
	this.loadedModules={};
}


Bienvenue.Workspace.prototype.log=function(message, type) {
	log(message, type);
};



Bienvenue.Workspace.prototype.loadModule=function(name) {

	var module=new Bienvenue.ModuleLoader(this);
	module.load(name);
};



Bienvenue.Workspace.prototype.setMainContent=function(content) {
	this.mainPanel.html(content);
	this.rebuild();
}



Bienvenue.Workspace.prototype.run=function() {

	this.initialize();


	this.initializeTopMenu();
	this.initializeLeftMenu();


	//this.loadModule('RichEdit')
	//this.loadModule('Test')
	this.loadModule('Blank')



};


Bienvenue.Workspace.prototype.rebuild=function() {
	$.material.init();

	this.initializeTooltip();
	this.initializeDatePicker();
	this.initializeRipple();
	this.initializeSliders();
};





Bienvenue.Workspace.prototype.initializeLeftMenu=function() {
	var node=$('.navbar-default.sidebar').get(0);
	ReactDOM.render(
		React.createElement(Bienvenue.Workspace.LeftNavigationBar, null),
		this.leftNavigationBar.get(0)
	);
};


Bienvenue.Workspace.prototype.initializeTopMenu=function() {
	var node=$('.topNavigationBar').get(0);
	ReactDOM.render(
		React.createElement(Bienvenue.Workspace.TopNavigationBar, null),
		this.topNavigationBar.get(0)
	);
};



Bienvenue.Workspace.prototype.initializeSummerNote=function(selector) {
	if($(selector).length) {
		$(selector).summernote({
			lang: 'fr-FR',
			height: '500',                 // set editor height
		});
		return true;
	}
	else {
		return false;
	}
}







Bienvenue.Workspace.prototype.initialize=function() {
	$(window).bind("load resize", function() {
		var topOffset = 50;
		var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		if (width < 768) {
			$('div.navbar-collapse').addClass('collapse');
			topOffset = 100; // 2-row-menu
		} else {
			$('div.navbar-collapse').removeClass('collapse');
		}

		var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
		height = height - topOffset;
		if (height < 1) height = 1;
		if (height > topOffset) {
			$("#page-wrapper").css("min-height", (height) + "px");
		}
	});


	/*
	 var url = window.location;
	 var element = $('ul.nav a').filter(function() {
	 return this.href == url || url.href.indexOf(this.href) == 0;
	 }).addClass('active').parent().parent().addClass('in').parent();
	 if (element.is('li')) {
	 element.addClass('active');
	 }
	 */


};










Bienvenue.Workspace.prototype.initializeSliders=function() {

	if($(".slider.shor").length) {
		$(".slider.shor").noUiSlider({
			start: 50,
			connect: "lower",
			range: {
				min: 0,
				max: 100
			}
		});
	}


	if($(".slider.svert").length) {
		$(".slider.svert").noUiSlider({
			orientation: "vertical",
			start: 50,
			connect: "lower",
			range: {
				min: 0,
				max: 100
			}
		});
	}
}







Bienvenue.Workspace.prototype.initializeDatePicker=function() {
	$('.bienvenue-datePicker').datepicker({
		language: "fr",
		daysOfWeekHighlighted: "0,6",
		calendarWeeks: true,
		autoclose: true,
		todayHighlight: true
	});
}

Bienvenue.Workspace.prototype.initializeRipple=function() {
	this.rippleManager.initialize('.customRipple');
}

Bienvenue.Workspace.prototype.initializeTooltip=function() {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
};






Bienvenue.Workspace.prototype.ajax=function(options) {

	options.cache=false;

	return $.ajax(options);
};




Bienvenue.Workspace.prototype.getScript=function(url, callback) {
	return getScript.apply(this, [url, callback]);
};






