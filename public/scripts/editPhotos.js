let addButton = document.getElementById('admin-photo-button-add'),
albumNameForm = document.getElementById('admin-albumname-form'),
albumNameButton = document.getElementById('admin-albumname-form-button'),
albumNameInput = document.getElementById('admin-albumname-form-input');
// addButton.addEventListener('click', callAlbumNameForm);
// albumNameButton.addEventListener('click', addAlbum);

function callAlbumNameForm(e){
    e.preventDefault();
    albumNameForm.style.display='block';
    addButton.style.display='none';
}

function addAlbum(e) {
    e.preventDefault();
    window.location='/admin/photo/album/'+albumNameInput.value;
    albumNameInput.value='';
    //TODO correct spaces
}



// function addLink(event) {
//     event.preventDefault();
//     let linksInscription = addButton.parentNode.previousElementSibling;
//     let tagBeforeWhichInsert = document.getElementsByClassName('form-group row')[linkInputCounter];
//
//     if (linksInscription.innerHTML === 'Links:') {
//         tagBeforeWhichInsert.before(createLinkBox(true));
//         linksInscription.innerHTML = '';
//         linkInput(linkInputCounter-6).focus();
//         linkInputCounter++;
//     } else {
//         tagBeforeWhichInsert.before(createLinkBox());
//         linkInput(linkInputCounter-6).focus();
//         linkInputCounter++;
//     }
// }