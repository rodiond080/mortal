import {checkFileMatch, createSketchWithFile, createSketchWithDBData, audioFileExtensions} from "./moduls/createSketch.js";
import dropAreaInit from "./moduls/dropAreaInit.js";
document.addEventListener('DOMContentLoaded', init);
let formOneNewsDate = document.getElementById('admin-news-edit-date');
let oldDate=formOneNewsDate;

function init() {
    let formOneNewsDescription = document.getElementById('admin-news-edit-description');
    let galleryOfPictures = document.getElementById('gallery');
    let dropArea = document.getElementById('admin-drop-area');
    let dropInput = document.getElementById('admin-drop-input');
    let newsForm = document.getElementById('admin-edit-one-news-button');
    let urlToSaveOneNews = '/admin/news/savenews';
    let urlToGetNewsPictures = '/admin/news/getonenewspictures';

    //visual effects
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    ['dragenter', 'dragleave'].forEach(eventName => {
        dropArea.addEventListener(eventName, inputIndicator, false);
    });

    ['drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, inputIndicator, false);
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(
        eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        }
    );

    let formOneNewsId = getId(document.getElementById('admin-news-form').action);

    let dataId = {
        id: formOneNewsId
    };

    let currentData;

    fetch(urlToGetNewsPictures, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(dataId)
    }).then(res => {
            return res.json();
        }
    ).then(function(res)  {
        currentData = res;
        res.forEach(function(item){
            let imgAddress = item.news_images_address;
            let numberToInsert = item.news_images_position;
            let date = document.getElementById('admin-news-edit-date').value;
            let img = '<img src=\"' + '/public/images/news/news'+ date.slice(0,10)+'id'+formOneNewsId +'/' +imgAddress + '\">';
            // formOneNewsDescription.value = getTextWithValueAtPosition(formOneNewsDescription.value, img, numberToInsert);
            galleryOfPictures.appendChild(createBoxWithImageAndIndicator('/public/images/news/news'+ date.slice(0,10)+'id'+formOneNewsId +'/' +imgAddress));
        });
    })
        .catch(function (error) {
            console.log(error)
        });

    function getId(url) {
        for (let i = url.length - 1; i >= 0; i--) {
            if (url[i] === '/') {
                return url.slice(-(url.length-i-1));
            }
        }
    }

    function getTextWithValueAtPosition(text, value, position) {
        let firstPart = text.slice(0, position);
        let secondPart = firstPart === text ? '' : text.slice(-(text.length - position));
        return firstPart + value + secondPart;
    }
    dropInput.addEventListener('drop', handleFiles);

    let overallFiles = [];

    function handleFiles(event) {
        let dt = event.dataTransfer;
        let files = dt.files;
        files = [...files];
        files.forEach(file => {
            overallFiles.push(file)
        });
        files.forEach(previewFile);
    }

    newsForm.addEventListener('click', uploadFile);

    function uploadFile(event) {
        event.preventDefault();

        let header = new Headers();
        header.append('Accept', 'application/json');

        let fd = new FormData();
        fd.append('date', document.getElementById('admin-news-edit-date').value);
        fd.append('heading', document.getElementById('admin-news-edit-heading').value);
        fd.append('description', document.getElementById('admin-news-edit-description').value);

        //new files
        let fileNamesOfDroppedFiles = [];
        for (let i = 0; i < overallFiles.length; i++) {
            let myFile = overallFiles[i];
            fd.append('picture' + i, myFile, myFile.name);
            fileNamesOfDroppedFiles.push(myFile.name);
        }

        //all files
        let fileNamesOfAllFiles = [];
        let droppedFilesCounter = fileNamesOfDroppedFiles.length;
        let allSketches = document.getElementsByClassName('admin-news-edit-picture-box');
        for (let i = 0; i < allSketches.length; i++) {

            let sketchName = allSketches[i]
                .getElementsByClassName('admin-news-edit-picture-div')[0]
                .style.backgroundImage;



            let regExp = /url\("data:image\//;
            if (sketchName.match(regExp)) {
                fileNamesOfAllFiles.push(fileNamesOfDroppedFiles[fileNamesOfDroppedFiles.length - droppedFilesCounter]);
                droppedFilesCounter--;
            }else{
                fileNamesOfAllFiles.push(getId(sketchName).replace("\")", ''));
            }
        }

        let associativeArrayOfImages = [];
        for(let i=0; i<allSketches.length; i++){
            let imgTagWillBeInserted = "<img src=\"/public/images/news/news"+oldDate.value.slice(0,10)+'id'+formOneNewsId+"/"+fileNamesOfAllFiles[i]+"\">";
            associativeArrayOfImages[i]= [fileNamesOfAllFiles[i], formOneNewsDescription.value.indexOf(imgTagWillBeInserted)];
        }

        // // TODO !!dates!!

        fd.append('images_array', JSON.stringify(associativeArrayOfImages));
        fd.append('id', formOneNewsId);


        let request = new Request(urlToSaveOneNews, {
            method:'POST',
            headers:header,
            mode:'no-cors',
            body:fd
        });


        //TODO read about corses

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

        overallFiles=[];


    }

function previewFile(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function() {
        let galleryOfPictures = document.getElementById('gallery');
        galleryOfPictures.appendChild(createBoxWithImageAndIndicator(reader.result, file.name));
        let formOneNewsDescriptionValue = document.getElementById('admin-news-edit-description').value;
        let imgTagWillBeInserted = "<img src=\"/public/images/news/news"+formOneNewsDate.value.slice(0,10)+'id'+formOneNewsId+"/"+file.name+"\">";

        formOneNewsDescription.focus();
        if(formOneNewsDescription.selectionStart===formOneNewsDescription.selectionEnd){
            formOneNewsDescription.value = getTextWithValueAtPosition(formOneNewsDescriptionValue, imgTagWillBeInserted, formOneNewsDescription.selectionStart);
        }else{
            //TODO !!
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
                let formOneNewsDescriptionValue = document.getElementById('admin-news-edit-description').value;

                let tagToDeleteSketch = '<img src=\"';
                if (filename) {
                    tagToDeleteSketch += ('/public/images/news/news' + formOneNewsDate.value.slice(0, 10)+ 'id'+formOneNewsId+ '/' + filename + '\">');
                } else {
                    tagToDeleteSketch += (result + '\">');
                }
                formOneNewsDescriptionValue = formOneNewsDescriptionValue.replace(tagToDeleteSketch, '');
                formOneNewsDescription.value = formOneNewsDescriptionValue;
            }
        }

    }
        delButton.appendChild(x);
        box.appendChild(indicator);
        box.appendChild(img);

        return box;

}

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    function inputIndicator() {
        if (dropInput.style.display === 'block') {
            dropInput.style.display = 'none';
        } else {
            dropInput.style.display = 'block';
        }
    }

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
}


