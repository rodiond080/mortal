import {processFile, checkFileMatch, createSketch2,createSketchWithFile,createSketchWithDBData, audioFileExtensions, createRadio} from "./moduls/createSketch.js";
import dropAreaInit from "./moduls/dropAreaInit.js";
let id = basename(window.location.href, '?'),
    dropArea = document.getElementById('admin-audio-edit-area'),
    nameInput = document.getElementById('admin-audioalbum-name'),
    dropInput = document.getElementById('admin-audio-edit-input'),
    imagesBox = document.getElementById('admin-audio-edit-trackbox'),
    posterLabel = document.getElementById('admin-audioalbum-poster-label'),
    posterInput = document.getElementById('admin-audioalbum-poster-input'),
    posterBox = document.getElementById('admin-audioalbum-poster-box'),
    saveButton = document.getElementById('admin-audio-button-save'),
    fileTypePattern = /audio.*/,
    fileExtensions = audioFileExtensions,
    urlToGetAudioalbumData='/admin/audioalbums/getaudioalbum',
    urlToSaveAudioalbumData='/admin/audioalbums/saveaudioalbum',
    bootstrapColumnsForSketch = ["col-6", "col-sm-4", "col-md-3", "col-lg-2", "col-xl-1"]
;

window.addEventListener('DOMContentLoaded', init);
dropAreaInit(dropArea);
dropArea.addEventListener('drop', handleFilesDrop);
dropInput.addEventListener('change', handleFilesUpload);
saveButton.addEventListener('click', saveFiles);
posterInput.addEventListener('change', processPoster);
// window.addEventListener('resize', () => {
//     We execute the same script as before
    // let vh = window.innerHeight * 0.01;
    // document.documentElement.style.setProperty('--vh', `${vh}px`);
// });
let poster = [];

function processPoster(e){
    e.preventDefault();

    let reader = new FileReader();
    reader.readAsDataURL(posterInput.files[0]);

    reader.onloadend=function () {
        let imageAddress = 'url(\''+reader.result+'\')';
        let imageName = posterInput.files[0].name;
        let closerIcon = document.createElement('div');
        closerIcon.addEventListener('click', function () {
                this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                poster.splice(poster.indexOf(posterInput.files[0]), 1);
                posterLabel.innerHTML='Upload image';
            });

        if(document.getElementById('admin-audioalbum-poster-box').firstChild){
            posterBox.removeChild(document.getElementsByClassName('admin-sketch-width')[0]);
        }

        createSketch2(posterBox, imageAddress, imageName, closerIcon, false, ['col-12']);
   }
   poster.push(posterInput.files[0]);
   posterLabel.innerHTML=basename(posterInput.value, '');
   posterBox.style.display='block';

}

let newFilesToUpload = [];
function handleFilesDrop(e){
    let dt = e.dataTransfer;
    let files = dt.files;
    files = [...files];
    processFiles(files);
}


function handleFilesUpload() {
    let files = [...this.files];
    processFiles(files);

}

function processFiles(files){
    files.forEach(file => {
        if(checkFileMatch(file, fileTypePattern, fileExtensions)) {
            newFilesToUpload.push(file);
            processFile(file)
                .then(res=>{
                    createSketchWithFile(imagesBox, res, file, newFilesToUpload,
                        bootstrapColumnsForSketch);
                })
        }
    });
}

function init() {
    if(id==='new'){return;}
    let dataId = {id: id};

    fetch(urlToGetAudioalbumData, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(dataId)
    }).then(res => {
            return res.json();
        }
    ).then(function(res)  {
        if(res.audio_albums_poster) {
            let closerIcon = document.createElement('div');
            closerIcon.addEventListener('click', function () {
                this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                poster.splice(poster.indexOf(posterInput.files[0]), 1);
                posterLabel.innerHTML = 'Upload image';
            });


            createSketch2(posterBox,
                'url(\'' + '/public/images/audio/' + res.audio_albums_name + '/' + res.audio_albums_poster + '\')',
                res.audio_albums_poster, closerIcon, false, ['col12']);
            posterBox.style.display = 'block';
            posterLabel.innerHTML = res.audio_albums_poster;
        }
            nameInput.value = res.audio_albums_name;
            let imageAddress = '/public/audio/' + res.audio_albums_name;
            res.images.forEach(image => {
                createSketchWithDBData(imagesBox, image.mp3_name, imageAddress,
                    bootstrapColumnsForSketch);
            });



    })
        .catch(function (error) {
            console.log(error)
        });

}


function saveFiles(e) {
    e.preventDefault();

    if(!nameInput.value){
        alert("You need to insert a name");
        return;
    }

    let header = new Headers();
    header.append('Accept', 'application/json');

    //
    let fd = new FormData();
    fd.append('audioalbum_id', id);
    fd.append('audioalbum_name', nameInput.value);
    if(poster.length>0) {
        fd.append('audioalbum_poster', poster[0], poster[0].name);
    }else if(posterLabel.value==='Upload image'){
        fd.append('audioalbum_poster', 'delete');
    }


    // all file names
    let allFileNamesToSave = getListOfAllFiles(imagesBox);
    fd.append('all_file_names', JSON.stringify(allFileNamesToSave));

    //new files
    for (let i = 0; i <newFilesToUpload.length; i++) {
        let myFile = newFilesToUpload[i];
        fd.append('audioalbum_track' + i, myFile, myFile.name);
    }

    let request = new Request(urlToSaveAudioalbumData, {
        method:'POST',
        headers:header,
        mode:'cors',
        body:fd
    });


    // TODO read about corses

    fetch(request)
        .then(res => {
            return res.json();
        })
        .then(res=>{
            if(res.exists){
                alert("The album with such name already exists. Choose another name please");
            }else {
                if(id==='new'){
                    window.location.replace('/admin/audioalbums/index/'+res.id);
                    alert("Done!");
                }else {
                    // alert("Done!");
                    console.log(res)
                }
            }
        })
        .catch(err=> {
            console.log(err);
            }
        );

        newFilesToUpload=[];
}

function getListOfAllFiles(imagesBox) {
    let listOfAllFiles=[];
    let listOfTagsWithNames = imagesBox.getElementsByClassName('admin-sketch-name');

    for(let i = 0; i<listOfTagsWithNames.length; i++){
        listOfAllFiles[i]=listOfTagsWithNames[i].innerHTML;
    }

    return  listOfAllFiles;
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



















// function previewFile(file) {
//     createSketch(imagesBox, file, overallTrackFiles,
//         "col-6", "col-sm-4", "col-md-3", "col-lg-2", "col-xl-1"
//     );
    // let reader = new FileReader();
    // reader.readAsDataURL(file);
    // reader.onloadend = function() {
    //     let allPictureTags = document.getElementById('admin-audio-edit-trackbox');
    //     let bootStrapWrapper = document.createElement('div');
    //     bootStrapWrapper.classList.add('col-6');
    //     bootStrapWrapper.classList.add('col-sm-6');
    //     bootStrapWrapper.classList.add('col-md-4');
    //     bootStrapWrapper.classList.add('col-lg-2');
    //     // bootStrapWrapper.classList.add('col-xl-1');
    //     let itemBox = document.createElement('div');
    //     itemBox.classList.add('admin-audio-edit-item-box');
    //     // let imageName = 'url(\'/public/images/front/megafon.png\')';
    //     // itemBox.style.backgroundImage=imageName;
    //     let item = document.createElement('div');
    //     item.classList.add('admin-audio-edit-item');
    //     let itemContent = document.createElement('div');
    //     itemContent.classList.add('admin-audio-edit-content');
    //
    //     let delButton = document.createElement('div');
    //     delButton.classList.add('admin-audio-edit-closer');
    //     let x = document.createElement('div');
    //     x.classList.add("admin-news-edit-x");
    //
    //     x.addEventListener('click', function () {
    //             this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
    //         }
    //     );
    //
    //     delButton.appendChild(x);
    //     itemContent.appendChild(delButton);
    //     item.appendChild(itemContent);
    //     itemBox.appendChild(item);
    //     bootStrapWrapper.appendChild(itemBox);
    //     allPictureTags.appendChild(bootStrapWrapper);
    //
    // }
// }



















// let Person = function (name) {
//     this.name=name;
// };
// Person.prototype.greet = function(){
//     console.log('Hello, my name is '+ this.name);
// }
//
// Person.prototype.age = 4;
//
// let Developer = function(name, skills){
//     Person.apply(this, arguments);
//     this.skills = skills || [];
// };
//
//
// Developer.prototype=Object.create(Person.prototype);
// Developer.prototype.constructor=Developer;//TODO Why?
//
//
// let dev = new Developer('DBAdmen', 'MySQL');
// console.log(dev.name);
// console.log(dev.skills);
// dev.greet();
// console.log(Person.prototype.isPrototypeOf(Developer.prototype));
