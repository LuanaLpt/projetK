import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)


import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const labelsAdd = document.querySelectorAll('.add-images-label');
    const modal = document.getElementById('containerModal');
    const modalImg = document.getElementById('modalImage');

    labelsAdd.forEach(labelAdd => {
        const container = labelAdd.closest('.image-preview-container');
        const fileInput = labelAdd.querySelector('input[type="file"]');

        if (fileInput && container) {
            fileInput.addEventListener('change', (e) => {
                const files = e.target.files;
                if (!files || files.length === 0) return;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (!file.type.startsWith('image/')) continue;

                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const imageUrl = event.target.result;


                        const wrapperDiv = document.createElement('div');
                        wrapperDiv.className = 'relative w-10 h-10';


                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'w-full h-full border border-gray-300 rounded bg-cover bg-center cursor-pointer shadow-sm';
                        previewDiv.style.backgroundImage = `url('${imageUrl}')`;


                        previewDiv.addEventListener('click', () => {
                            if (modal && modalImg) {
                                modalImg.src = imageUrl;
                                modal.classList.remove('hidden');
                            }
                        });


                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-black/70 text-[10px] text-white hover:bg-black transition-colors focus:outline-none';
                        deleteBtn.innerHTML = '✕';

                        deleteBtn.addEventListener('click', (buttonEvent) => {
                            buttonEvent.stopPropagation();
                            wrapperDiv.remove();
                            if (container.querySelectorAll('.relative.w-10').length === 0) {
                                fileInput.value = '';
                            }
                        });

                        wrapperDiv.appendChild(previewDiv);
                        wrapperDiv.appendChild(deleteBtn);
                        container.insertBefore(wrapperDiv, labelAdd);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });


    if (modal) {
        modal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
        }
    })
});
