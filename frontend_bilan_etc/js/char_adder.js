var addCharButton = $('#add-char-button');
var customCharContainer = $('#custom-char-container');

var newCharTemplate = '<div class="custom-char-instance"> \
							<label>Label</label><input class="form-control new-char" type="text"> \
							<label>Valeur</label><input class="form-control new-char" type="text"> \
							<i class="fa fa-times new-char-remove"></i> \
						</div>';

addCharButton.click(function() {
	customCharContainer.append(newCharTemplate);
	renumerate();
});

function removeCustomChar(index) {
	customCharContainer.children().get(index).remove();
	renumerate();
};

function renumerate() {
	customCharContainer.children().each(function(index, element) {
		$(element).find('label').attr('for', 'new-char-'+index);
		$(element).find('input').attr('id', 'new-char-'+index);
		$(element).find('name').attr('name', 'new-char-'+index);
		$(element).find('.new-char-remove').attr('onclick', 'removeCustomChar('+index+');');
	});	
}
