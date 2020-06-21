document.getElementById("id-main-nav-icon").onclick = function () {
            if (document.getElementById("id-main-main-nav").className === "main-main-nav"){
                if(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[2].getElementsByTagName('a')[0].className==="main-nav-active-link logo"
                    && document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0].innerText ==="News"){
                    document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0].before(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[2]);
                }
                document.getElementById("id-main-main-nav").className+=" responsive";
            }else {
                document.getElementsByTagName('nav')[0].getElementsByTagName('li')[3].before(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0])
                document.getElementById("id-main-main-nav").className = "main-main-nav";
            }
        };


let mediaLink = document.getElementsByTagName('nav')[0].getElementsByTagName('li')[3].getElementsByTagName('a')[0];

let mediaBox = document.getElementsByTagName('nav')[0].getElementsByTagName('li')[3].getElementsByTagName('div')[0];
let mediaSubBox = document.getElementsByTagName('nav')[0].getElementsByTagName('li')[3].getElementsByTagName('div')[0].getElementsByTagName('div')[0];

mediaLink.onmouseover = mediaLink.onmouseout = mediaBox.onmouseout = function () {
    if (mediaBox.style.display === "flex") {
            mediaBox.style.display = "none";
    } else {
            mediaBox.style.display = "flex";
    }
};

