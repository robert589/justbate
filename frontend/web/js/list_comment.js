$('#retrieveChildComment').on('pjax:error', function (event) {
						    alert('Failed to load the page');
						    event.preventDefault();
						});