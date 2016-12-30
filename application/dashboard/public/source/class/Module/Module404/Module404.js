Bienvenue.Module.Module404=function(workspace, url)
{
	this.__construct(workspace, url);
};



Bienvenue.Module.Module404.prototype.run=function() {
	this.workspace.setMainContent(
		'<div class="alert alert-danger">'+
			'Module does not exist'+
		'</div>'
	);
};




