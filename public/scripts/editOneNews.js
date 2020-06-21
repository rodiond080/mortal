import {createSketch2, processFile, createRadio, checkFileMatch, createSketchWithFile, createSketchWithDBData, audioFileExtensions} from "./moduls/createSketch.js";
import {dropAreaInit, baseName} from "./moduls/dropAreaInit.js";
// import createSketch2 from "./moduls/createSketch";
let id = baseName(window.location.href, '?'),
    dropArea = document.getElementById('admin-onenews-edit-area'),
        dateInput = document.getElementById('admin-news-date'),
        headingInput = document.getElementById('admin-onenews-heading'),
        descriptionInput = document.getElementById('admin-onenews-description'),
    dropInput = document.getElementById('admin-onenews-imginput-input'),
    imagesBox = document.getElementById('admin-onenews-box'),
    saveButton = document.getElementById('admin-onenews-savebutton'),
    fileTypePattern = /image.*/,
    fileExtensions = ['.jpg','.png'],
    urlToGetOneNewsData='/admin/news/getonenews',
    urlToSaveOneNewsData='/admin/news/saveonenews',
    bootstrapColumnsForSketch = ["col-6", "col-sm-4", "col-md-3", "col-lg-2", "col-xl-1"],
    dateOfNews = dateInput.value
;

window.addEventListener('DOMContentLoaded', init);
dropAreaInit(dropArea);
dropArea.addEventListener('drop', handleFilesDrop);
dropInput.addEventListener('change', handleFilesUpload);
saveButton.addEventListener('click', saveOneNews);

function saveOneNews(e) {
    e.preventDefault();
    //check if the date was changed if yes, then correct images , no - nothing.
    //on the server change names
    if(!headingInput.value){
        alert("You need to insert a heading");
        return;
    }

    let header = new Headers();
    header.append('Accept', 'application/json');

    let fd = new FormData();
    fd.append('news_id', id);
    fd.append('news_date', dateInput.value);
    fd.append('news_heading', headingInput.value);
    fd.append('news_content', descriptionInput.value);
    if(getListOfAllFiles(imagesBox).length>0) {
        fd.append('news_filenames', JSON.stringify(getListOfAllFiles(imagesBox)));
    }
    if(imagesBox.getElementsByClassName('admin-sketch-radio').length>0) {
        fd.append('news_images_cover', getSelectedRadio(imagesBox));
    }

    if(newFilesToUpload.length>0){
        for (let i = 0; i <newFilesToUpload.length; i++) {
            let myFile = newFilesToUpload[i];
            fd.append('news_image' + i, myFile, myFile.name);
        }
    }

    let request = new Request(urlToSaveOneNewsData, {
        method:'POST',
        headers:header,
        mode:'cors',
        body:fd
    });

    fetch(request)
        .then(res => {
            return res.json();
        })
        .then(res=>{
                if(id==='new'){
                    window.location.replace('/admin/news/edit/'+res.id);
                    alert("Done!");
                }else{
                    // alert("Done!");
                    console.log(res)
                }
        })
        .catch(err=> {
                console.log(err);
            }
        );

    newFilesToUpload=[];



    // let header2 = new Headers();
    // header.append('Accept', 'application/json');
    //
    // let dataId = {id: id};
    //
    // let request2 = new Request(urlToGetOneNewsData, {
    //     method:'POST',
    //     headers:header,
    //     mode:'no-cors',
    //     body:JSON.stringify(dataId)
    // });
    //
    //
    // fetch(request2).then(res => {
    //         return res.json();
    //     }
    // ).then(function(res){
    //     if(res.empty){
    //         // console.log('empty-'+res)
    //     }else {
    //         // console.log('done-'+res)
    //     }})
    //     .catch(function (error) {
    //         console.log(error)
    //     });

}

function getSelectedRadio(imageBox){
    let listOfRadio = imagesBox.getElementsByClassName('admin-sketch-radio');
    let selectedItem = null;
    for(let i = 0; i<listOfRadio.length; i++){
        if(listOfRadio[i].checked){
            selectedItem=listOfRadio[i];
        }
    }
    if(selectedItem==null){
        return selectedItem;
    }else {
        return document.getElementById(selectedItem.id).previousSibling.innerHTML;
    }

}


let newFilesToUpload = [];

function handleFilesDrop(e){
    let dt = e.dataTransfer;
    let files = dt.files;
    files = [...files];
    createSketch(files);
}

function handleFilesUpload() {
    let files = [...this.files];
    createSketch(files);
}

function createSketch(files){
    files.forEach(file => {
        if (checkFileMatch(file, fileTypePattern, fileExtensions)) {
            processFile(file)
                .then(blob => {
                    newFilesToUpload.push(file);

                    descriptionInput.value=
                        descriptionInput.value.slice(0, descriptionInput.selectionStart)
                        +createImgTag(file)
                        +descriptionInput.value.slice(descriptionInput.selectionEnd);


                    let closerIcon = document.createElement('div');
                    closerIcon.addEventListener('click', function () {
                        this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                        newFilesToUpload.splice(newFilesToUpload.indexOf(file), 1);
                        descriptionInput.value=descriptionInput.value.replace(createImgTag(file),'');
                    });

                    descriptionInput.focus();

                    return [
                        createSketch2(imagesBox, 'url(\''+blob+'\')', file.name, closerIcon, false, bootstrapColumnsForSketch),
                        getListOfAllFiles(imagesBox).length
                    ];
                })
                .then(res => {
                    let imageBox = res[0];
                    let overAllArrLength = res[1];
                    createRadio(imageBox, overAllArrLength);
                })
        }
    });
}

function createImgTag(file) {
    return "<img src=\"/public/images/news/news"+dateOfNews.slice(0,10)+'id'+id+"/"+file.name+"\" class='admin-onenews-img'>";
}

function getListOfAllFiles(imagesBox) {
    let listOfAllFiles=[];
    let listOfTagsWithNames = imagesBox.getElementsByClassName('admin-sketch-name');
    for(let i = 0; i<listOfTagsWithNames.length; i++){
        listOfAllFiles[i]=listOfTagsWithNames[i].innerHTML;
    }
    return  listOfAllFiles;
}


function init(e) {
    e.preventDefault();
    if(id==='new'){return;}

    let header = new Headers();
    header.append('Accept', 'application/json');

    let dataId = {id: id};

    let request = new Request(urlToGetOneNewsData, {
        method:'POST',
        headers:header,
        mode:'no-cors',
        body:JSON.stringify(dataId)
    });


    fetch(request).then(res => {
            return res.json();
        }
    ).then(function(res){
        if(res.empty){
            console.log(res)
        }else {
        // console.log(res[0].news_cover)
        // console.log(res[0].news_images_address)
        let index = 0;
        res.forEach(image=>{
            let isCover = image.news_cover;
            let imgName = image.news_images_address;
            let imageAddress = '/public/images/news/news'+dateInput.value.slice(0,10)+'id'+id+'/'+imgName;

            createSketchWithDBData(imagesBox, imgName, imageAddress, bootstrapColumnsForSketch);
            createRadio(imagesBox, index, isCover)
            index++;
        });
    }})
        .catch(function (error) {
            console.log(error)
        });

}



