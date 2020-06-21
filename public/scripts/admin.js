let mediaLinks = document.getElementById('admin-links-media');
let media = document.getElementById('admin-link-media');
media.addEventListener('click', showMediaLinks);
function showMediaLinks(e) {
    e.preventDefault();
    // let checkBoxMediaOpen = document.getElementById('mediaOpen');
    if(mediaLinks.style.marginTop==='0px'){
        mediaLinks.style.marginTop='-196px';
        // checkBoxMediaOpen.checked=false;
    }else {
        mediaLinks.style.marginTop='0px';
        // checkBoxMediaOpen.checked=true;
    }
}

