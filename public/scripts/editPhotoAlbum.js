import {createRadio,  checkFileMatch, createSketchWithFile, createSketchWithDBData, processFile} from "./moduls/createSketch.js";
import dropAreaInit from "./moduls/dropAreaInit.js";
let id = basename(window.location.href, '?'),
    dropArea = document.getElementById('admin-photo-edit-area'),
    nameInput = document.getElementById('admin-photoalbum-name'),
    dropInput = document.getElementById('admin-photo-edit-input'),
    imagesBox = document.getElementById('admin-photo-edit-imagesbox'),
    saveButton = document.getElementById('admin-photo-button-save'),
    dropLabel = document.getElementById('admin-photo-edit-label'),
    fileTypePattern = /image.*/,
    fileExtensions = ['.jpg', '.png'],
    urlToGetPhotoalbumData='/admin/photoalbums/getphotoalbum',
    urlToSavePhotoalbumData='/admin/photoalbums/savephotoalbum',
    bootstrapColumnsForSketch = ["col-6", "col-sm-4", "col-md-3", "col-lg-2", "col-xl-1"]
;

window.addEventListener('DOMContentLoaded', init);
dropAreaInit(dropArea);
dropArea.addEventListener('drop', handleFilesDrop);
dropInput.addEventListener('change', handleFilesUpload);
saveButton.addEventListener('click', savePhotoAlbum);

let newFilesToUpload = [];

function handleFilesDrop(e){
    let dt = e.dataTransfer;
    let files = dt.files;
    files = [...files];
    makeSketches(files);
}

function handleFilesUpload() {
    let files = [...this.files];
    makeSketches(files);
}

const makeSketches = (files) =>{
    files.forEach(file => {
        if(checkFileMatch(file, fileTypePattern, fileExtensions)) {
            newFilesToUpload.push(file);
            processFile(file)
                .then(res=>{
                    return [createSketchWithFile(imagesBox, res, file, newFilesToUpload,
                        bootstrapColumnsForSketch), getListOfAllFiles(imagesBox).length];
                })
                .then(res=>{
                    let imageBox = res[0];
                    let overAllArrLength = res[1];
                    createRadio(imageBox, overAllArrLength);
                })
        }
    });
}


async function init() {
    if (id === 'new') {
        return;
    }

    let header = new Headers();
    header.append('Accept', 'application/json');

    let dataId = {
        id: id
    };

    let request = new Request(urlToGetPhotoalbumData, {
        method: 'POST',
        headers: header,
        mode: 'no-cors',
        body: JSON.stringify(dataId)
    });

    let response = await fetch(request);
    let res = await response.json();
    nameInput.value = res.photo_albums_name;

    let x = 0;
    res.images.forEach(image => {
        let imageAddress = '/public/images/photo/' + res.photo_albums_name + '/' + image.img_name;
        let cover = image.is_cover;
        createSketchWithDBData(imagesBox, image.img_name, imageAddress, bootstrapColumnsForSketch);
        createRadio(
            document.getElementsByClassName('admin-sketch-width')[x],
            document.getElementsByClassName('admin-sketch-width').length,
            cover
        );
        x++;
    });
}
    // console.log(imagesBox)
    // fetch(request).then(res => {
    //         return res.json();
    //     }
    // ).then(res=> {
    //     nameInput.value = res.photo_albums_name;
    //     res.images.forEach(image=>{
    //         let imageAddress = '/public/images/photo/' + res.photo_albums_name + '/'+image.img_name;
    //             // console.log(imagesBox)
    //             createSketchWithDBData(imagesBox, image.img_name, imageAddress, bootstrapColumnsForSketch);
    //     });
    // }).catch(
    //     function (error) {
    //         console.log(error)
    //     });




// let promise = Promise.resolve(function () {
//     return [createSketchWithDBData(imagesBox, image.img_name,imageAddress,
//         bootstrapColumnsForSketch), newFilesToUpload.length];

// });
// promise.then(res=>{
//     console.log(res)
// })

// processFile(file)
//     .then(res=>{
//         return [createSketchWithFile(imagesBox, res, file, newFilesToUpload,
//             bootstrapColumnsForSketch), newFilesToUpload.length];
//     })
//     .then(res=>{
//         let imageBox = res[0];
//         let overAllArrLength = res[1];
//         createRadio(imageBox, overAllArrLength);
//     })

// createSketchWithDBData(imagesBox, image.img_name, imageAddress+image.img_name,
//     bootstrapColumnsForSketch);
// });



function savePhotoAlbum(e) {
    e.preventDefault();
    if(!nameInput.value){
        alert("You need to insert a name");
        return;
    }

    let header = new Headers();
    header.append('Accept', 'application/json');
    //
    let fd = new FormData();
    fd.append('photoalbum_id', id);
    fd.append('photoalbum_name', nameInput.value);
    fd.append('photoalbum_cover', getSelectedRadio(imagesBox));
    // console.log(getSelectedRadio(imagesBox))

    // all file names
    let allFileNamesToSave = getListOfAllFiles(imagesBox);
    fd.append('all_file_names', JSON.stringify(allFileNamesToSave));

    //new files
    for (let i = 0; i <newFilesToUpload.length; i++) {
        let myFile = newFilesToUpload[i];
        fd.append('photo' + i, myFile, myFile.name);
    }


    let request = new Request(urlToSavePhotoalbumData, {
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

            if(res.exists){
                alert("The album with such name already exists. Choose another name please");
            }else {
                if(id==='new'){
                    window.location.replace('/admin/photoalbums/index/'+res.id);
                    alert("Done!");
                }else {
                    alert("Done!");
                }
            }
        })
        .catch(err=> {
                console.log(err);
            }
        );

        newFilesToUpload = [];
}


function getListOfAllFiles(imagesBox) {
    let listOfAllFiles=[];
    let listOfTagsWithNames = imagesBox.getElementsByClassName('admin-sketch-name');
    for(let i = 0; i<listOfTagsWithNames.length; i++){
        listOfAllFiles[i]=listOfTagsWithNames[i].innerHTML;
    }
    return  listOfAllFiles;
}

function getSelectedRadio(imageBox) {
    let listOfRadio = imagesBox.getElementsByClassName('admin-sketch-radio');
    let selectedItem = '';
    for(let i = 0; i<listOfRadio.length; i++){
        if(listOfRadio[i].checked){
            selectedItem=listOfRadio[i];
        }
    }
    return document.getElementById(selectedItem.id).previousSibling.innerHTML;
}

function basename(path, suffix){
    let p = path.split( /[\/\\]/ ), name = p[p.length-1];
    let regExpSuffix = '';
    for(let i = 0; i<suffix.length; i++){
        if('/?*:;{}\\'.includes(suffix[i])){
            regExpSuffix+='\\'+suffix[i];
        }else {
            regExpSuffix+=suffix[i];
        }
    }
    return (name.replace(new RegExp(regExpSuffix+'$'),''));
}

