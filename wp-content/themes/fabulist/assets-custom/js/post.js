let src = document.getElementById("jsPostFile");
let target = document.getElementById("target");
let caption = document.getElementById('jsPostCaption');
let postSubmit = document.getElementById('jsPostSubmit');
let label = document.getElementById("jsInputLabel");
let form = document.getElementById("jsPostForm");

let imageSelected = false;
let captionValid = false;

function showImage(src,target) {
    let fr=new FileReader();
    // when image is loaded, set the src of the image where you want to display it
    fr.onload = function(e) { target.src = this.result; };
    src.addEventListener("change",function() {
        if(src.files[0]){
            // fill fr with image data    
            fr.readAsDataURL(src.files[0]);
            imageSelected = true;
            label.innerText = "Choose Another Image";
            target.style.display = "block";
        } else {
            imageSelected = false;
            target.src = "";
            label.innerText = "Choose An Image";
            target.style.display = "none";
        }
    });
}

function submitPost(event) {
    event.preventDefault();

    if(!imageSelected || !captionValid) {
        console.log("post not valid");
    } else {
        toggleLoading();
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
        if(this.readyState === 4) {
            let response = JSON.parse(this.responseText);
            if(response.success) {
                document.getElementById('content').innerHTML = `
                    <div>
                    <p class="post__success" style="
                        text-align: center;
                        font-size: 40px;
                        line-height: 1;
                        padding: 5px;
                    ">Post was submitted successfully!</p>
                        <p class="home__link" style="
                            text-align: center;
                            font-size: 25px;
                        "><a href="/add-post">Add Another Post</a></p>
                    </div>
                `;
            } else {
                document.getElementById('content').innerHTML = `
                <div>
                    <p class="post__success" style="
                        text-align: center;
                        font-size: 40px;
                        line-height: 1;
                        padding: 5px;
                    ">Oops. Something went wrong.</p>
                        <p class="home__link" style="
                            text-align: center;
                            font-size: 25px;
                        "><a href="/add-post">Try Again</a></p>
                    </div>
                `;
            }
            toggleLoading();
        }
        });

        xhr.open("POST", "/wp-admin/admin-ajax.php?action=submit_elsiegram_post");
        let data = new FormData();
        data.append("caption", caption.value);
        data.append("image", src.files[0]);
        xhr.send(data);
    }
}

function isCaptionValid() {
    if(caption.value.length > 0) {
        captionValid = true;
    }
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

function createLoadingIndicator() {
    let page = document.getElementById('page');
    let containerNode = document.createElement('div');
    containerNode.innerHTML = '<div id="jsPostLoading" class="post__loading" style="display: none"><div class="postLoadingIcon"></div></div>';
    page.prepend(containerNode);
}

function toggleLoading() {
    let loading = document.getElementById("jsPostLoading");
    if(loading.style.display === "none") {
        loading.style.display = "flex";
    } else {
        loading.style.display = "none";
    }
}

//   handle showing image before upload 
showImage(src,target);

caption.addEventListener("change",isCaptionValid);
// handle post submission 
postSubmit.addEventListener('click', function(event) {
    submitPost(event);
});

createLoadingIndicator();