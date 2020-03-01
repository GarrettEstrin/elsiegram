let individualPosts = document.getElementsByClassName('individual-post');

for(let i=0, a=individualPosts, c= a.length;i<c;i++){
    a[i].addEventListener('click', function() {
        showIndividualPost(a[i]);
    })
}

function showIndividualPost(post) {
    console.log(post);
    let body = document.getElementsByTagName("body")[0];
    let jsModalBG = document.getElementById('jsPostModalBG');
    let postImg = post.children[0].children[0].children[0].src;
    let html = `
        <div class="post-modal">
            <div id="jsCloseModal" class="post-modal__close"></div>
            <div class="post-modal__flex-container">
                <img src="${postImg}"/>
                <p>Posted 13 days ago</p>
                <p>Post Title</p>
            </div>
            
        </div>
    `;
    let container = document.createElement('div');
    container.innerHTML = html;
    container.classList.add("post-modal-container");
    container.id = "jsPostModal"; 
    container.style.top = window.scrollY + "px";   
    body.appendChild(container);
    body.style.overflow = "hidden";
    document.getElementById('jsCloseModal').addEventListener('click', closeIndividualPost);
    jsModalBG.style.display = "block";
}

function closeIndividualPost() {
    this.removeEventListener('click', closeIndividualPost);
    let postModal = document.getElementById('jsPostModal');
    postModal.parentNode.removeChild(postModal);
    let body = document.getElementsByTagName("body")[0];
    body.style.overflow = "initial";
    document.getElementById('jsPostModalBG').style.display = "none";
}