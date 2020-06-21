// $(document).ready(
//     function () {
//         $('form').submit(function (event) {
//             let json;
//             event.preventDefault();
//             $.ajax({
//                 type:$(this).attr('method'),
//                 url:$(this).attr('action'),
//                 data: new FormData(this),
//                 contentType: false,
//                 cache: false,
//                 processData: false,
//                 success: function (result) {
//                     json = jQuery.parseJSON(result);
//                     if (json.url){
//                         window.location.href = json.url;
//                     }else {
//                         alert(json.status + ' - ' + json.message);
//                     }
//                 }
//             })
//         });
//
//         $('#sidebarCollapse').on('click', function () {
//             $('#sidebar').toggleClass('active');
//         });
//
//
//         document.getElementById("id-main-nav-icon").onclick = function () {
//             if (document.getElementById("id-main-main-nav").className === "main-main-nav"){
//
//                 if(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[2].getElementsByTagName('a')[0].className==="main-nav-active-link logo"
//                     && document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0].innerText ==="About"){
//                     document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0].before(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[2]);
//                 }
//                 document.getElementById("id-main-main-nav").className+=" responsive";
//             }else {
//                 document.getElementsByTagName('nav')[0].getElementsByTagName('li')[3].before(document.getElementsByTagName('nav')[0].getElementsByTagName('li')[0])
//                 document.getElementById("id-main-main-nav").className = "main-main-nav";
//             }
//         };
//
//     }
// );


