import   Dropzone from 'dropzone'
//import $ from 'jquery';


  new Dropzone('.dropzone', {
    url: '/'
});

console.log($('.dropzone').data('course'));

Dropzone.autoDiscover= false;