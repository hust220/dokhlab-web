$(document).ready(function() {
		$('#newGmMem').draggable( {
			connectToSortable: '#gmSort',
			helper: 'clone',
			revert: 'invalid'
		});
		$('#gmSort').sortable( {
			cursor: 'crosshair',
			containment: 'parent',
			revert: true
		});
		$('#jcSort').sortable( {
			cursor: 'crosshair',
			containment: 'parent',
			revert: true
		});
		$( "ul, li" ).disableSelection();
		$('#accordion').accordion({
			active: false,
			autoHeight: false,
			collapsible: true
		});
		$('#accordion').disableSelection();
});
