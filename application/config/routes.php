<?php
return [

    //MainController
    ''=>[
        'controller' => 'main',
        'action' => 'index'
    ],
//TODO why do we need tags nav and footer
//    'news'=>[
//        'controller' => 'mainNews',
//        'action' => 'news'
//    ],

    'news/index/{page:\d+}'=>[
        'controller' => 'mainNews',
        'action' => 'news'
    ],

    'gigs'=>[
        'controller' => 'mainGigs',
        'action' => 'gigs'
    ],

    'gigs/year/{page:\d+}'=>[
        'controller' => 'mainGigs',
        'action' => 'gigs'
    ],

    //media
    'media/photo'=>[
        'controller' => 'mainPhoto',
        'action' => 'photo'
    ],

    'media/audio'=>[
        'controller' => 'mainAudio',
        'action' => 'audio'
    ],

    'media/video'=>[
        'controller' => 'mainVideo',
        'action' => 'video'
    ],

    'contact'=>[
        'controller' => 'mainContact',
        'action' => 'contact'
    ],

    //AdminController
    'admin'=>[
        'controller' => 'adminNews',
        'action' => 'login'
    ],

    //not yet completed
    //Entrance
    'admin/news/index/\d+'=>[
        'controller' => 'adminNews',
        'action' => 'editNews'
    ],

    'admin/news/new'=>[
        'controller' => 'adminNews',
        'action' => 'createNewOneNews'
    ],
    //TODO how to redefine methods in php?

    //NEWS
    'admin/news/edit/{id:\d+}'=>[
        'controller' => 'adminNews',
        'action' => 'editOneNews'
    ],

    'admin/news/delete/\d+'=>[
        'controller' => 'adminNews',
        'action' => 'deleteNews'
    ],

    //fetch queries for one news
    //save one news
    'admin/news/saveonenews'=>[
        'controller' => 'adminNews',
        'action' => 'saveNews'
    ],

    //get pictures for one news
    'admin/news/getonenews'=>[
        'controller' => 'adminNews',
        'action' => 'getOneNewsPictures'
    ],

    //GIGS
    'admin/gigs/index/\d+'=>[
        'controller' => 'adminGigs',
        'action' => 'editGigs'
    ],

    'admin/gigs/edit/{id:\d+}'=>[
        'controller' => 'adminGigs',
        'action' => 'editGig'
    ],

    'admin/gigs/delete/\d+'=>[
        'controller' => 'adminGigs',
        'action' => 'deleteGig'
    ],

    'admin/gigs/savegig'=>[
        'controller' => 'adminGigs',
        'action' => 'saveGig'
    ],

    'admin/gigs/getgigposter'=>[
        'controller' => 'adminGigs',
        'action' => 'getGigPoster'
    ],



    //MEDIA
    //PHOTO
    'admin/photoalbums'=>[
        'controller' => 'adminPhoto',
        'action' => 'photoAlbums'
    ],

    'admin/photoalbums/new'=>[
        'controller' => 'adminPhoto',
        'action' => 'createNewPhotoAlbum'
    ],

    'admin/photoalbums/index/\d+'=>[
        'controller' => 'adminPhoto',
        'action' => 'editPhotoAlbum'
    ],

    //PHOTO(for fetch)
    'admin/photoalbums/savephotoalbum'=>[
        'controller' => 'adminPhoto',
        'action' => 'savePhotoAlbum'
    ],

    'admin/photoalbums/getphotoalbum'=>[
        'controller' => 'adminPhoto',
        'action' => 'getPhotoAlbum'
    ],


    //AUDIO
    'admin/audioalbums'=>[
        'controller' => 'adminAudio',
        'action' => 'audioAlbums'
    ],

    'admin/audioalbums/new'=>[
        'controller' => 'adminAudio',
        'action' => 'createNewAudioAlbum'
    ],

    'admin/audioalbums/index/\d+'=>[
        'controller' => 'adminAudio',
        'action' => 'editAudioAlbum'
    ],

    //AUDIO(for fetch)
    'admin/audioalbums/saveaudioalbum'=>[
        'controller' => 'adminAudio',
        'action' => 'saveAudioAlbum'
    ],

    'admin/audioalbums/getaudioalbum'=>[
        'controller' => 'adminAudio',
        'action' => 'getAudioAlbum'
    ],


];



//    'admin/audioalbums'=>[
//        'controller' => 'adminAudio',
//        'action' => 'audio'
//    ],

//    'admin/audio/album/[^\/?*:;{}\\\]+'=>[
//        'controller' => 'adminAudio',
//        'action' => 'editAudioAlbum'
//    ],
//
//    'admin/audio/album/save'=>[
//        'controller' => 'adminPhoto',
//        'action' => 'saveAudioAlbum'
//    ],



//    'admin/photo/album/\w+'=>[
//        'controller' => 'adminPhoto',
//        'action' => 'editPhotoAlbum'
//    ],

//
//    'admin/photo/album/[^\/?*:;{}\\\]+'=>[
//        'controller' => 'adminPhoto',
//        'action' => 'editPhotoAlbum'
//    ],
//
//    'admin/photo/album/save'=>[
//        'controller' => 'adminPhoto',
//        'action' => 'savePhotoAlbum'
//    ],
