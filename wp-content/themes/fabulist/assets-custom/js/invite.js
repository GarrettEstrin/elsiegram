console.log("invite.js loaded");

// Invite page 

let inviteSubmitBtn = document.getElementById('jsInviteSubmit');
let inviteForm = document.getElementById("jsInviteForm");
let email = document.getElementById('jsInviteEmail');
let name = document.getElementById('jsInviteName');
let form = document.getElementById('jsInviteForm');
inviteSubmitBtn.addEventListener('click', function(event) {
    validateInviteForm(event)
});

email.addEventListener('change', function(){
    email.classList.remove('input-error');
    if(!isEmailValid(email.value)){
        email.classList.add('input-error');
    }
})

name.addEventListener('change', function() {
    name.classList.remove('input-error');
    if(name.value.length === 0) {
        name.classList.add('input-error');
    }
})

function validateInviteForm(event) {
    event.preventDefault();

    email.classList.remove('input-error');
    name.classList.remove('input-error');
    if(isEmailValid(email.value) && name.value.length > 0) {
        return submitForm();
    } 
    if(!isEmailValid(email.value)){
        email.classList.add('input-error');
    }

    if(name.value.length === 0) {
        name.classList.add('input-error');
    }
}

function isEmailValid(email) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
      return true;
    }
      
    return false;
}

function submitForm() {
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    xhr.addEventListener("readystatechange", function() {
      if(this.readyState === 4) {
        console.log(JSON.parse(this.responseText));
        let response = JSON.parse(this.responseText);
        if(response.success) {
            logInviteSentEmailAddress(email.value);
            showSuccessMessage();
        } else {
            console.log('there was an error');
            showErrorMessage();
        }
      }
    });
    
    xhr.open("POST", "/wp-admin/admin-ajax.php?" + serialize(form));
    xhr.send();
}

/*!
 * Serialize all form data into a query string
 * (c) 2018 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Node}   form The form to serialize
 * @return {String}      The serialized form data
 */
var serialize = function (form) {

	// Setup our serialized data
	var serialized = [];

	// Loop through each field in the form
	for (var i = 0; i < form.elements.length; i++) {

		var field = form.elements[i];

		// Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
		if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

		// If a multi-select, get all selections
		if (field.type === 'select-multiple') {
			for (var n = 0; n < field.options.length; n++) {
				if (!field.options[n].selected) continue;
				serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
			}
		}

		// Convert field data to a query string
		else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
			serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
		}
	}

	return serialized.join('&');

};

function logInviteSentEmailAddress(emailAddress) {
    let inviteEmailAddressArray = localStorage.inviteEmailAddress;
    if(typeof(inviteEmailAddressArray) == "undefined"){
        inviteEmailAddressArray = [];
    } else {
        inviteEmailAddressArray = JSON.parse(inviteEmailAddressArray);
    }
    inviteEmailAddressArray.push(emailAddress);
    localStorage.inviteEmailAddress = JSON.stringify(inviteEmailAddressArray);
}

function showSuccessMessage() {
    document.getElementById('jsInviteForm').style.display = "none";
    document.getElementById('jsInviteSuccessMessage').style.display = "block";
}

function showErrorMessage() {
    document.getElementById('jsInviteForm').style.display = "none";
    document.getElementById('jsInviteErrorMessage').style.display = "block";
    setTimeout(function(){
        location.reload();
    }, 5000)
}