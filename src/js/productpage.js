let thumbnails = document.querySelector('.thumbnails-container')
.addEventListener('mouseover', e => {
    if (e.target.matches('img')) {
        let imagePreviewContainer = document.querySelector('.img-preview');
        let thumbnail = e.target.src;

        document.querySelectorAll('.thumbnails').forEach(thumbnail => {
            thumbnail.classList.remove('active');
        });
        
        e.target.parentElement.classList.add('active');
        imagePreviewContainer.src = thumbnail;
    }
});