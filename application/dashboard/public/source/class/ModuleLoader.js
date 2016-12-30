Bienvenue.ModuleLoader=function(workspace)
{
	this.errorModuleName='Module404';

	this.moduleURLRoot='source/class/Module';
	this.moduleDescriptorFileName='descriptor.json';
	this.workspace=workspace;
	this.modules={};
};


Bienvenue.ModuleLoader.prototype.load=function(name, callback) {

	if(typeof(this.modules[name])!='undefined') {
		return this.modules[name].run();
	}

	var moduleURL=this.moduleURLRoot+'/'+name;
	var descriptorURL=this.moduleURLRoot+'/'+name+'/'+this.moduleDescriptorFileName;

	this.workspace.log('Loading descriptor "'+descriptorURL+'"');

	this.workspace.ajax({
		url : descriptorURL,
		success: function(data) {


			var scriptURL=this.moduleURLRoot+'/'+name+'/'+data.scripts[0];
			this.workspace.getScript(scriptURL, function() {

				this.workspace.log('Script "'+scriptURL+'" loaded');

				if(typeof(Bienvenue.Module[data.name])=='undefined') {
					//throw new Exception('Module '+data.name+'does not exist');
					this.load(this.errorModuleName);
					return false;
				}

				inherit(Bienvenue.Module[data.name], Bienvenue.Module);

				var module=new Bienvenue.Module[data.name](this.workspace, moduleURL);
				this.modules[name]=module;

				this.workspace.log('Running module "'+name+'"');

				this.run(name);
			}.bind(this));
		}.bind(this),
		error: function() {
			this.load(this.errorModuleName);
		}.bind(this)

	});
};



Bienvenue.ModuleLoader.prototype.run=function(name) {
	return this.modules[name].run();
};

