Bienvenue.Component.Tree=function()
{




}


Bienvenue.Component.Tree.prototype.renderDemo=function(selector) {
	// inline data demo
	$(selector).jstree({
		'core' : {
			'data' : [
				{ "text" : "Root node", "children" : [
					{ "text" : "Child node 1" },
					{ "text" : "Child node 2" }
				]}
			]
		}
	});
}



Bienvenue.Component.Tree.prototype.renderAjaxDemo=function(selector) {
	// inline data demo
	$(selector).jstree({
		'core' : {
			'data' : {
				'url' : function (node) {
					return node.id === '#' ?
						'source/class/Component/Tree/ajaxdemo-root.json' : 'source/class/Component/Tree/ajaxdemo-children.json';
				},
				'data' : function (node) {
					return { 'id' : node.id };
				}
			}
		},

		"types" : {
			"#" : {
				"max_children" : 1,
				"max_depth" : 4,
				"valid_children" : ["root"]
			},
			"root" : {
				"icon" : "type-root",
				"valid_children" : ["default"]
			},
			"default" : {
				"valid_children" : ["default","file"]
			},
			"file" : {
				"icon" : "type-file",
				"valid_children" : []
			}
		},
		"plugins" : [
			"contextmenu", "dnd", "search",
			"state", "types", "wholerow"
		]



	});
}


