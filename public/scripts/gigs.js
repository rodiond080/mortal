let links = document.getElementsByClassName('photo-item-link');
let pointerLinkLeft = document.getElementsByClassName('photo-pointer')[0].getElementsByTagName('a')[0];
let pointerLinkRight = document.getElementsByClassName('photo-pointer')[1].getElementsByTagName('a')[0];

for(let i = 0; i<links.length; i++){
    links[i].addEventListener('click', showImage);
}

function showImage(e){
    e.preventDefault();
    let link = this.href;
    let overlay = document.getElementById('overlay');
    let img = document.getElementsByClassName('photo-item-large-img')[0];
    let closer = document.getElementsByClassName('photo-item-closer-x')[0];
    let pointerLinkLeft = document.getElementsByClassName('photo-pointer')[0].getElementsByTagName('a')[0];
    let pointerLinkRight = document.getElementsByClassName('photo-pointer')[1].getElementsByTagName('a')[0];


    let linkAddresses = [];
    for (let i=0; i<links.length; i++){
        linkAddresses.push(links[i].href);
    }

    if(links.length-1===linkAddresses.indexOf(link)){
        pointerLinkRight.style.display='none';
    }else {
        pointerLinkRight.style.display='block';
    }

    if(0===linkAddresses.indexOf(link)){
        pointerLinkLeft.style.display='none';
    }else {
        pointerLinkLeft.style.display='block';
    }

    pointerLinkLeft.addEventListener('click', function (e) {
        e.preventDefault();
        let event = new Event('click');
        links[linkAddresses.indexOf(link)-1].dispatchEvent(event);
    });

    pointerLinkRight.addEventListener('click', function (e) {
        e.preventDefault();
        let event = new Event('click');
        links[linkAddresses.indexOf(link)+1].dispatchEvent(event);
    });
    
    // if(this===links[0]){
    //     pointerLinkLeft.style.display='none';
    // }else {
    //     pointerLinkLeft.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         let linkAddresses = [];
    //         for (let i=0; i<links.length; i++){
    //             linkAddresses.push(links[i].href);
    //         }
    //
    //         img.src=links[linkAddresses.indexOf(link)-1].href;
    //         if((linkAddresses.indexOf(link)-1)===0){
    //             pointerLinkLeft.style.display='none';
    //         }
    //     })
    // }



    //TODO indexOf(), findIndex()

    // console.log(poinerLinkLeft);
    //actions
    img.src=link;
    overlay.style.display='flex';
    closer.addEventListener('click' , closeOverlay);
    function closeOverlay() {
        overlay.style.display='none';
    }



    // let delButton = document.createElement('div');
    // delButton.classList.add('admin-news-edit-picture-del-button');
    // let x = document.createElement('div');
    // x.classList.add("admin-news-edit-x");

}