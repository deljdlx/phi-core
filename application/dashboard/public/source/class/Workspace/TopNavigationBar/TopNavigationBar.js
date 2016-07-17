Bienvenue.Workspace.TopNavigationBar = React.createClass({

	//displayName: 'TodoApp',

	getInitialState: function getInitialState() {
		return {
			html:''
		};
	},


	/*
	 onChange: function onChange(e) {
	 this.setState({ text: e.target.value });
	 },
	 */


	componentDidMount: function() {

		$.get('source/class/Workspace/TopNavigationBar/nav-top.php').done(function(data) {
			this.setState({
				html: data
			});
		}.bind(this));
	},



	render: function render() {

		//var md = new Remarkable();
		return React.createElement("div", {
			className: "content",
			dangerouslySetInnerHTML: { __html: this.state.html }
		})
	}
});

