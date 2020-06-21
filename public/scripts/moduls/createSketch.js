// const createSketch = (boxId, file, overAllFiles,  ...bootstrapColumns) => {
//
//     let reader = new FileReader();
//     reader.readAsDataURL(file);
//
//     reader.onloadend = function() {
//         let allPictureTags = boxId;
//         let imageAddress = isAudio(file)?'url(\'/public/images/admin/tape2.png\')':'url(\''+reader.result+'\')';
//
//         //bootstrap
//         let bootStrapWrapper = document.createElement('div');
//         bootStrapWrapper.classList.add('admin-sketch-width');
//         bootstrapColumns.forEach(boostrapClass=>{
//             bootStrapWrapper.classList.add(boostrapClass);
//         });
//
//         //wrapper(in order to make a square)
//         let wrapper = document.createElement('div');
//         wrapper.classList.add('admin-sketch-wrapper');
//
//         //content
//         let content = document.createElement('div');
//         content.classList.add('admin-sketch-content');
//         // console.log(file.type);
//         // console.log(file.type);
//         // console.log(/image.*/.test(file.type));
//         // console.log(/audio.*/.test(file.type));
//         // console.log(/\.jpg$/.test(file.name));
//         // console.log('ondrop' in content);
//         // e.dataTransfer.dropEffect = 'copy';
//         content.style.backgroundImage=imageAddress;
//
//         //1name
//         let name = document.createElement('div');
//         name.classList.add('admin-sketch-name');
//         name.innerHTML=file.name;
//
//         //2progress and a button to close
//         let progressAndCloser = document.createElement('div');
//         progressAndCloser.classList.add('admin-sketch-progress-and-closer');
//         //progress
//         let progressBarBox = document.createElement('div');
//         progressBarBox.classList.add('admin-sketch-progress');
//         let progressIndicator = document.createElement('div');
//         progressIndicator.classList.add('admin-sketch-indicator');
//         progressBarBox.appendChild(progressIndicator);
//         //closer
//         let closerBox = document.createElement('div');
//         closerBox.classList.add('admin-sketch-closer');
//         let closerIcon = document.createElement('div');
//         closerIcon.classList.add('admin-sketch-x');
//         closerIcon.addEventListener('click', function () {
//                 this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
//                 overAllFiles.splice(overAllFiles.indexOf(file), 1);
//             }
//         );
//         closerBox.appendChild(closerIcon);
//         progressAndCloser.appendChild(progressBarBox);
//         progressAndCloser.appendChild(closerBox);
//
//         //3title
//         let title = document.createElement('div');
//         title.classList.add('admin-sketch-title');
//         if(isAudio(file)){
//             title.innerHTML=file.name;
//         }
//
//         content.appendChild(name);
//         content.appendChild(progressAndCloser);
//         content.appendChild(title);
//         wrapper.appendChild(content);
//         bootStrapWrapper.appendChild(wrapper);
//         allPictureTags.appendChild(bootStrapWrapper);
//     }
// }


// const createSketchWithFile = (boxId, file, overAllFiles,  bootstrapColumns)=>{
//     let reader = new FileReader();
//     reader.readAsDataURL(file);
//     //TODO try readAsArrayBuffer(file)
//     let isAudio = (isAudioMime(file)&&isAudioExt(file.name));
//
//     reader.onloadend = function() {
//         let imageAddress = isAudio ?'url(\'/public/images/admin/tape2.png\')':'url(\''+reader.result+'\')';
//         let imageName = file.name;
//         let closerIcon = document.createElement('div');
//         closerIcon.addEventListener('click', function () {
//                 this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
//                 overAllFiles.splice(overAllFiles.indexOf(file), 1);
//             }
//         );
//         createSketch2(boxId, imageAddress, imageName, closerIcon, isAudio, bootstrapColumns);
//     }
// }


// const createSketchWithDBData = (boxId, imageName, imageAddress,  bootstrapColumns) =>{
//     let closerIcon = document.createElement('div');
//     let isAudio = isAudioExt(imageName);
//
//     if(isAudio) {
//         imageAddress = 'url(\'/public/images/admin/tape2.png\')';
//     }else {
//         imageAddress='url(\''+imageAddress+'\')';
//     }
//     // }else {
//     // imageAddress='url(\''+imageAddress+'/'+imageName+'\')';
//     // imageAddress=imageAddress;
//     // }
//
//     closerIcon.addEventListener('click', function () {
//             this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
//         }
//     );
//
//     return createSketch2(boxId, imageAddress, imageName, closerIcon, isAudio, bootstrapColumns);
// }

const createSketchWithFile = (boxId, blob, file, overAllFiles,  bootstrapColumns)=>{
    //TODO try readAsArrayBuffer(file)

    let isAudio = (isAudioMime(file)&&isAudioExt(file.name));
        let imageAddress = isAudio ?'url(\'/public/images/admin/tape2.png\')':'url(\''+blob+'\')';
        let imageName = file.name;
        let closerIcon = document.createElement('div');
        closerIcon.addEventListener('click', function () {
                this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
                overAllFiles.splice(overAllFiles.indexOf(file), 1);
                console.log(overAllFiles);
            }
        );

        return createSketch2(boxId, imageAddress, imageName, closerIcon, isAudio, bootstrapColumns);
}

const createSketchWithDBData = (boxId, imageName, imageAddress,  bootstrapColumns) =>{
    let closerIcon = document.createElement('div');
    let isAudio = isAudioExt(imageName);
    // console.log(boxId)
    if(isAudio) {
        imageAddress = 'url(\'/public/images/admin/tape2.png\')';
    }else {
        imageAddress='url(\''+imageAddress+'\')';
    }

    closerIcon.addEventListener('click', function () {
            this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
        }
    );

    return createSketch2(boxId, imageAddress, imageName, closerIcon, isAudio, bootstrapColumns);
}


const createSketch2 =  (boxId, imageAddress, imageName, closerIcon, isAudio, bootstrapColumns) => {

        //bootstrap
        let bootStrapWrapper = document.createElement('div');
        bootStrapWrapper.classList.add('admin-sketch-width');
        bootstrapColumns.forEach(boostrapClass => {
            bootStrapWrapper.classList.add(boostrapClass);
        });

        //wrapper(in order to make a square)
        let wrapper = document.createElement('div');
        wrapper.classList.add('admin-sketch-wrapper');

        //content
        let content = document.createElement('div');
        content.classList.add('admin-sketch-content');
        content.style.backgroundImage = imageAddress;

        //1name
        let name = document.createElement('div');
        name.classList.add('admin-sketch-name');
        name.innerHTML = imageName;

        //2progress and a button to close
        let progressAndCloser = document.createElement('div');
        progressAndCloser.classList.add('admin-sketch-progress-and-closer');
        //progress
        let progressBarBox = document.createElement('div');
        progressBarBox.classList.add('admin-sketch-progress');
        let progressIndicator = document.createElement('div');
        progressIndicator.classList.add('admin-sketch-indicator');
        progressBarBox.appendChild(progressIndicator);
        //closer
        let closerBox = document.createElement('div');
        closerBox.classList.add('admin-sketch-closer');
        // let closerIcon = document.createElement('div');
        closerIcon.classList.add('admin-sketch-x');
        // closerIcon.addEventListener('click', function () {
        //         this.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
        //         overAllFiles.splice(overAllFiles.indexOf(file), 1);
        //     }
        // );
        closerBox.appendChild(closerIcon);
        progressAndCloser.appendChild(progressBarBox);
        progressAndCloser.appendChild(closerBox);

        //3title
        let title = document.createElement('div');
        title.classList.add('admin-sketch-title');
        title.innerHTML = imageName;
        if (isAudio) {
            title.style.display = 'block';
        }else {
            title.style.display = 'none';
        }

        content.appendChild(name);
        content.appendChild(progressAndCloser);
        content.appendChild(title);
        wrapper.appendChild(content);
        bootStrapWrapper.appendChild(wrapper);
        boxId.appendChild(bootStrapWrapper);

        return boxId;
    }

const createRadio = (imagesBox, index, cover) =>{
    let idName = 'admin-sketch-radio'+index;
    let indexOfLastSketch = imagesBox.getElementsByClassName('admin-sketch-title').length-1;
    let lastTitle = imagesBox.getElementsByClassName('admin-sketch-title')[indexOfLastSketch];
    let radioInput = document.createElement('input');
    radioInput.classList.add('admin-sketch-radio')
    radioInput.type='radio';
    radioInput.name='news-cover';
    radioInput.id=idName
    radioInput.checked=(cover==1)?true:false;

    let label = document.createElement('Label');
    label.setAttribute('for', idName);
    label.innerHTML='cover';

    lastTitle.after(radioInput);
    radioInput.after(label);
}

function checkFileMatch(file, fileTypePattern, fileExtensions) {
    let result = false;
    let subResult=false;
    fileExtensions.forEach(ext=>{
        if(new RegExp(ext+'$').test(file.name)){
            result=true;
        }
    });

    if(fileTypePattern.test(file.type)){
        subResult=true;
    }

    return (result && subResult);
}

function isAudioExt(imageName){
    let isAudio = false;
    audioFileExtensions.forEach(audioFileExtension=>{
        if(new RegExp(audioFileExtension+'$').test(imageName)){
            isAudio=true;
        }
    });
    return isAudio;
}

function isAudioMime(file) {
    return /audio.*/.test(file.type);
}

async function processFileWithRes(file){
    processFile(file).then(res=>{
        return res;
    })
}

async function processFile(file){
    let result = await readFileAsync(file);
    return result;
}

function readFileAsync(file) {
    return new Promise((res, rej)=>{
        let reader = new FileReader();
        reader.onload=()=>{
            res(reader.result);
        }
        reader.onerror = rej;
        reader.readAsDataURL(file);
    })
}

const audioFileExtensions = ['.mp3', '.wav', '.ogg', '.aac', '.flac'];

export default createSketch2;
export { processFile, checkFileMatch, createSketch2,createSketchWithFile,createSketchWithDBData, audioFileExtensions, createRadio};