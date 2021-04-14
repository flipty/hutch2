function tinyMCEColorAdd() {
	var whichColorField = document.getElementById( 'add_tinymce_colors' ).value;
	var colorDiv = '<input type="checkbox" style="margin-top: -16px;" name="vi-settings[tinymce_colors][]" id="vi-settings[tinymce_colors][]" value="'+ whichColorField +'" checked="checked">' +
				 	'<div style="display: inline-block;width: 25px;height: 25px;background: '+ whichColorField +';"></div>';

	var newElement = document.createElement( 'div' );
	newElement.classList.add( 'tinymce_colors' );
	newElement.style.display = 'inline-block';
	newElement.style.marginRight = '10px';
	newElement.innerHTML = colorDiv;

	var addAfterField = document.querySelector( '.tinymce_colors' );
	insertAfter( newElement, addAfterField  );
}

function messagebarColorAdd() {
	var whichColorField = document.getElementById( 'add_messagebar_colors' ).value;
	var colorDiv = '<input type="checkbox" style="margin-top: -16px;" name="vi-settings[messagebar_colors][]" id="vi-settings[messagebar_colors][]" value="'+ whichColorField +'" checked="checked">' +
				 	'<div style="display: inline-block;width: 25px;height: 25px;background: '+ whichColorField +';"></div>';

	var newElement = document.createElement( 'div' );
	newElement.classList.add( 'messagebar_colors' );
	newElement.style.display = 'inline-block';
	newElement.style.marginRight = '10px';
	newElement.innerHTML = colorDiv;

	var addAfterField = document.querySelector( '.messagebar_colors' );
	insertAfter( newElement, addAfterField  );
}

function insertAfter(newElement,targetElement) {
    //target is what you want it to go after. Look for this elements parent.
    var parent = targetElement.parentNode;

    //if the parents lastchild is the targetElement...
    if(parent.lastchild == targetElement) {
        //add the newElement after the target element.
        parent.appendChild(newElement);
        } else {
        // else the target has siblings, insert the new element between the target and it's next sibling.
        parent.insertBefore(newElement, targetElement.nextSibling);
        }
}