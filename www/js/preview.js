// use strict mode, prevents to use undeclared variables
"use strict";

function loadPreview() {
    let preview = document.getElementById('preview_client_image');
    // preview.style.height = '200px';
    preview.style.width = '200px';
    preview.src = URL.createObjectURL(event.target.files[0]);
};
