let src = document.getElementById("jsPostFile");
let target = document.getElementById("target");
let caption = document.getElementById('jsPostCaption');
let postSubmit = document.getElementById('jsPostSubmit');
let label = document.getElementById("jsInputLabel");
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

function submitPost() {
    if(!imageSelected && !captionValid) {
        console.log("post not valid");
    } else {
        console.log("submittingPost");
        console.log(src.files[0], caption.value);
    }
}

function isCaptionValid() {
    if(caption.value.length > 0) {
        captionValid = true;
    }
}

//   handle showing image before upload 
showImage(src,target);
// handle post submission 
postSubmit.addEventListener('click', submitPost);