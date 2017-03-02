$(document).ready(function() {

  //Modal initialisation
  $('.modal').modal();
  //TinyMCE initialisation
  if ($(window).height() > 992) {
    tinymce.init({
      selector: 'textarea',
      autoresize_bottom_margin: 125,
      autoresize_on_init: false,
      menubar: false,
      plugins: ['advlist autolink autoresize lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      //From TinyMCE docs
      image_title: true,
      automatic_uploads: true,
      // URL of our upload handler. CHANGE PLS
      images_upload_url: 'postAcceptor.php',
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        // Note: In modern browsers input[type="file"] is functional without 
        // even adding it to the DOM, but that might not be the case in some older
        // or quirky browsers like IE, so you might want to add it to the DOM
        // just in case, and visually hide it. And do not forget do remove it
        // once you do not need it anymore.

        input.onchange = function() {
          var file = this.files[0];

          // Note: Now we need to register the blob in TinyMCEs image blob
          // registry. In the next release this part hopefully won't be
          // necessary, as we are looking to handle it internally.
          // Photo name/id handler
          var id = 'nb' + (new Date()).getTime();
          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
          var blobInfo = blobCache.create(id, file);
          blobCache.add(blobInfo);

          // call the callback and populate the Title field with the file name
          cb(blobInfo.blobUri(), {
            title: file.name
          });
        };
        input.click();
      }
    });
  } else {
    tinymce.init({
      selector: 'textarea',
      autoresize_bottom_margin: 125,
      autoresize_on_init: false,
      menubar: false,
      plugins: ['advlist autolink autoresize lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'styleselect | link image',
      //From TinyMCE docs
      image_title: true,
      automatic_uploads: true,
      // URL of our upload handler. CHANGE PLS
      images_upload_url: 'postAcceptor.php',
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        // Note: In modern browsers input[type="file"] is functional without 
        // even adding it to the DOM, but that might not be the case in some older
        // or quirky browsers like IE, so you might want to add it to the DOM
        // just in case, and visually hide it. And do not forget do remove it
        // once you do not need it anymore.

        input.onchange = function() {
          var file = this.files[0];

          // Note: Now we need to register the blob in TinyMCEs image blob
          // registry. In the next release this part hopefully won't be
          // necessary, as we are looking to handle it internally.
          // Photo name/id handler
          var id = 'nb' + (new Date()).getTime();
          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
          var blobInfo = blobCache.create(id, file);
          blobCache.add(blobInfo);

          // call the callback and populate the Title field with the file name
          cb(blobInfo.blobUri(), {
            title: file.name
          });
        };
        input.click();
      }
    });
  };
});