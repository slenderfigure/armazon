function validateExtension(ext) {
    let allowed   = ['jpg','jpeg', 'png'];
    let validated = false;

    allowed.forEach(i => {
        if (i == ext) { validated = true; }
    });
    return validated;
}

function getFileSize(size) {
    switch (true) {
        case (size > 1024 && size < 1048576):
            size = (size /= 1024).toFixed(2) + 'KB';
            break;
        case (size >= 1048576):
            size = (size /= 1048576).toFixed(2) + 'MB';
            break;
        default:
            size += 'bytes';
            break;
    }
    return size;
}

function createPreviewer(path, name, type, size, button = null) {
    let previewer = document.createElement('div');
    let overlay   = new DocOverlay();

    previewer.className = 'avatar-previewer';
    previewer.innerHTML =  `
    <i class="close-box material-icons">&#xe5cd;</i>
    <div class="img-wrapper">
        <img id="img-preview" src="${path}" alt="${name}"
        draggable="false">
    </div>

    <div class="img-info">
        <h4>Image Details:</h4>
        <ul>
            <li><p>Name: <span>${name}</span></p></li>
            <li><p>Type: <span style="text-transform: 
            uppercase;">${type}</span></p></li>
            <li><p>Size: <span>${size}</span></p></li>
        </ul>
    </div>

    <button class="btn" type="submit" name="update-avatar"
    value="update" form="avatarForm">Update</button>`;

    overlay.showOverlay(previewer, () => button.value = '');
}

function updateAvatar(button) {
    let avatar = Array.from(button.files)[0];
    let path   = window.URL.createObjectURL(avatar);
    let name   = avatar.name;
    let type   = avatar.type.replace('image/', '');
    let size   = getFileSize(avatar.size);

    if (!validateExtension(type)) { return; }

    else if (avatar.size > 5000000) { return; }

    createPreviewer(path, name, type, size, button);
}


// Event: Update Avatar
let updateBtn = document.querySelector('input[name="avatar"]')
.addEventListener('change', e => updateAvatar(e.target));