const dropAreaInit = (dropArea) => {

    //prevent defaults for drag-and-drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(
        eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        }
    );

    //visual effects
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    function preventDefaults(e) {
        e.preventDefault();
    }
}

const baseName = (path, suffix) =>{
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

export default dropAreaInit;
export {dropAreaInit, baseName};