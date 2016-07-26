Bienvenue.Workspace=function()
{
	this.mainPanel=$('.bienvenue-panel-main');
	this.leftNavigationBar=$('.navbar-default.sidebar');
	this.topNavigationBar=$('.topNavigationBar');


}


Bienvenue.Workspace.prototype.loadPanel=function(panelName) {
	var panel=new Bienvenue.Workspace.Panel.Test(this);
	panel.render();
	//panel.afterRender();
};


Bienvenue.Workspace.prototype.setMainContent=function(content) {
	this.mainPanel.html(content);
	this.rebuild();
}



Bienvenue.Workspace.prototype.run=function()
{

	this.loadPanel('Test');



	var node=$('.navbar-default.sidebar').get(0);
	ReactDOM.render(React.createElement(Bienvenue.Workspace.LeftNavigationBar, null), this.leftNavigationBar.get(0));

	var node=$('.topNavigationBar').get(0);
	ReactDOM.render(React.createElement(Bienvenue.Workspace.TopNavigationBar, null), this.topNavigationBar.get(0));




	//toop tip et tooltip on click===========================
	$('.bs-component [data-toggle="popover"]').popover();
	$('.bs-component [data-toggle="tooltip"]').tooltip();
	//============================================




	this.runSummerNode();


};




Bienvenue.Workspace.prototype.initializeRipple=function() {



	var ripple=new Bienvenue.Component.Ripple();
	ripple.initialize();



}


Bienvenue.Workspace.prototype.rebuild=function() {


	$('.bienvenue-datePicker').datepicker({
		language: "fr",
		daysOfWeekHighlighted: "0,6",
		calendarWeeks: true,
		autoclose: true,
		todayHighlight: true
	});

	$.material.init();
	this.initializeRipple();




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



Bienvenue.Workspace.prototype.runSummerNode=function() {


	$(window).bind("load resize", function() {
		topOffset = 50;
		width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		if (width < 768) {
			$('div.navbar-collapse').addClass('collapse');
			topOffset = 100; // 2-row-menu
		} else {
			$('div.navbar-collapse').removeClass('collapse');
		}

		height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
		height = height - topOffset;
		if (height < 1) height = 1;
		if (height > topOffset) {
			$("#page-wrapper").css("min-height", (height) + "px");
		}
	});

	var url = window.location;
	var element = $('ul.nav a').filter(function() {
		return this.href == url || url.href.indexOf(this.href) == 0;
	}).addClass('active').parent().parent().addClass('in').parent();
	if (element.is('li')) {
		element.addClass('active');
	}




}