let addButton = document.getElementById('admin-add-button');
let urlToGetPoster = '/admin/gigs/getgigposter';

let posterLabel = document.getElementById('admin-gigs-drop-label');
let posterInput = document.getElementById('admin-gigs-drop-input');


let formOneNewsId = getId(document.getElementById('admin-gigs-form').action);
let dataId = {
    id: formOneNewsId
};

fetch(urlToGetPoster, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(dataId)
}).then(res => {
    return res.json();
}).then(posterName => {
    if(posterName) {
        let date = document.getElementById('admin-gigs-date').value;
        let directoryOfPoster = '/public/images/gigs/gigs' + date.slice(0, 10) + 'id' + formOneNewsId + '/' + posterName;
        posterLabel.innerHTML=posterName;
        posterLabel.after(createBoxWithImageAndIndicator(directoryOfPoster));
    }
})
  .catch(function (error) {
        console.log(error);
});


posterInput.addEventListener('change', handleFiles);

function handleFiles(){
    let reader = new FileReader();
    reader.readAsDataURL(this.files[0]);
    reader.onloadend = () => {
        if(posterLabel.nextElementSibling){
            posterLabel.nextElementSibling.remove();
        }
        posterLabel.innerHTML=this.files[0].name;
        posterLabel.after(createBoxWithImageAndIndicator(reader.result, this.files[0].name));
    }
}


addButton.addEventListener('click', addLink);

let linkInputCounter = 6;
function addLink(event) {
    event.preventDefault();
    let linksInscription = addButton.parentNode.previousElementSibling;
    let tagBeforeWhichInsert = document.getElementsByClassName('form-group row')[linkInputCounter];

    if (linksInscription.innerHTML === 'Links:') {
        tagBeforeWhichInsert.before(createLinkBox(true));
        linksInscription.innerHTML = '';
        linkInput(linkInputCounter-6).focus();
        linkInputCounter++;
    } else {
        tagBeforeWhichInsert.before(createLinkBox());
        linkInput(linkInputCounter-6).focus();
        linkInputCounter++;
    }
}

function createLinkBox(first) {
    let box = document.createElement('div');
    box.classList.add('form-group');
    box.classList.add('row');
    box.classList.add('admin-links-class');

    let label = document.createElement('label');
    label.classList.add('col-2');
    label.classList.add('col-form-label');
    if (first) {
        label.innerHTML = 'Links:';
    }else{
        label.value = '';
    }

    let boxForInput = document.createElement('div');
    boxForInput.classList.add('col-8');
    boxForInput.classList.add('col-lg-4');
    let input = document.createElement('input');
    input.classList.add('form-control');
    input.type = 'text';
    input.placeholder='link'+(linkInputCounter-5);
    boxForInput.appendChild(input);

    let removeButton = document.createElement('button');
    removeButton.innerHTML='remove';
    removeButton.style.width='70px';
    removeButton.indexOfBox = linkInputCounter-6;
    removeButton.addEventListener('click', removeLink);

    function removeLink(e){
        e.preventDefault();
        for (let i = this.indexOfBox+1; i<document.getElementsByClassName('admin-links-class').length; i++){
            document.getElementsByClassName('admin-links-class')[i].getElementsByTagName('button')[0].indexOfBox=i-1;
            document.getElementsByClassName('admin-links-class')[i].getElementsByTagName('input')[0].placeholder='link'+i;
        }
        document.getElementsByClassName('admin-links-class')[this.indexOfBox].remove();
        linkInputCounter--;
    }

    box.appendChild(label);
    box.appendChild(boxForInput);
    box.appendChild(removeButton);
    return box;
}



let gigSubmit = document.getElementById('admin-gig-submit');
let urlToSaveGig = '/admin/gigs/savegig';
gigSubmit.addEventListener('click', saveGig);

function saveGig(e) {
    e.preventDefault();
    let posterFile = posterInput.files[0];

    let header = new Headers();
    header.append('Accept', 'application/json');

    let fd = new FormData();
    fd.append('date', document.getElementById('admin-gigs-date').value);
    fd.append('country', document.getElementById('admin-gigs-country').value);
    fd.append('city', document.getElementById('admin-gigs-city').value);
    fd.append('address', document.getElementById('admin-gigs-address').value);
    fd.append('description', document.getElementById('admin-gigs-description').value);

    if(posterInput.value) {
        fd.append('poster', posterFile, posterFile.name);
    }else {
        fd.append('poster_label', posterLabel.innerHTML);
    }

    let arrayWithLinksMainBox = document.getElementsByClassName('admin-links-class');
    let arrayWithLinksToSend = {};
    if (arrayWithLinksMainBox.length){
        for (let i=0; i<arrayWithLinksMainBox.length; i++){
            let linkValue = linkInput(i).value;
            arrayWithLinksToSend['link'+i]=linkValue;
        }
        fd.append('links', JSON.stringify(arrayWithLinksToSend));
    }

    fd.append('id', getId(document.getElementById('admin-gigs-form').action));

    let request = new Request(urlToSaveGig, {
        method:'POST',
        headers:header,
        mode:'no-cors',
        body:fd
    });

    fetch(request)
        .then(res => {
                return res.json();
        })
        .then(res=>{
                console.log(res);
        })
        .catch(err=> {
                console.log(err);
            }
        );
}

function linkInput(index) {
    return document.getElementsByClassName('admin-links-class')[index]
        .getElementsByTagName('div')[0]
        .getElementsByTagName('input')[0];
}

function getId(url) {
    for (let i = url.length - 1; i >= 0; i--) {
        if (url[i] === '/') {
            return url.slice(-(url.length-i-1));
        }
    }
}


function createBoxWithImageAndIndicator(result, filename) {

    //box
    let box = document.createElement('div');
    box.classList.add('admin-news-edit-picture-box');

    //indicator
    let indicator = document.createElement('progress');
    indicator.max = 100;
    indicator.value = 0;
    indicator.id = 'progress-bar';

    //delete button
    let delButton = document.createElement('div');
    delButton.classList.add('admin-news-edit-picture-del-button');
    let x = document.createElement('div');
    x.classList.add("admin-news-edit-x");

    //image
    let img = document.createElement('div');
    img.style.background = "url(\'" + result + "\')";
    img.classList.add('admin-news-edit-picture-div');
    img.style.backgroundSize = 'auto 100%';
    img.appendChild(delButton);

    delButton.addEventListener('click', removeSketchTagOfElement);

    function removeSketchTagOfElement() {
        let imagesBoxArray = document.getElementsByClassName('admin-news-edit-picture-box');
        for (let i = 0; i < imagesBoxArray.length; i++) {
            let imageAddress = document.getElementsByClassName('admin-news-edit-picture-box')[i]
                .getElementsByClassName('admin-news-edit-picture-div')[0]
                .style.backgroundImage;

            if (imageAddress === 'url(\"' + result + '\")') {
                imagesBoxArray[i].remove();
            }
        }
        posterInput.value=null;
        posterLabel.innerHTML='Upload files';
    }

    delButton.appendChild(x);
    box.appendChild(indicator);
    box.appendChild(img);
    return box;
}