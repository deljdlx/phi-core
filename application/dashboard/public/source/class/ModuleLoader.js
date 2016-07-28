Bienvenue.ModuleLoader=function(name, workspace)
{

	this.name=name;
	this.moduleURLRoot='source/class/Module';
	this.workspace=workspace;
};


Bienvenue.ModuleLoader.prototype.load=function(callback) {

	this.workspace.ajax({
		url : this.moduleURLRoot+'/'+this.name+'/descriptor.json',
		success: function(data) {

			var scriptURL=this.moduleURLRoot+'/'+this.name+'/'+data.scripts[0];
			this.workspace.getScript(scriptURL, function() {
				this.module=new Bienvenue.Module[data.name](this.workspace);
				this.module.render();
			}.bind(this));
		}.bind(this)
	});

};

