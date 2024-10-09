// Size 2MB
const CHUNK_SIZE = 1024 * 1024 * 2;

// CSRF TOKEN
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const fileInput = {
    uploadFile: async function (file) {
        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
        let currentChunk = 0;
        
        this.showLoader();

        while (currentChunk < totalChunks) {
            const start = currentChunk * CHUNK_SIZE;
            const end = Math.min(file.size, start + CHUNK_SIZE);

            const chunk = file.slice(start, end);
            const formData = new FormData();
            formData.append('file', chunk);
            formData.append('fileName', file.name);
            formData.append('chunkIndex', currentChunk.toString());
            formData.append('totalChunks', totalChunks.toString());
            formData.append('_token', csrfToken);

            try {
                await fetch('/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                this.updateProgress(currentChunk + 1, totalChunks);
                currentChunk++;
            } catch (error) {
                console.error('Ошибка загрузки, повтор через 5 сек...', error);
                await new Promise(resolve => setTimeout(resolve, 5000));
            }
        }

        this.hideLoader();
    },

    showLoader: function () {
        const loader = document.getElementById('loader');
        loader.classList.remove('hidden');
    },

    hideLoader: function () {
        const loader = document.getElementById('loader');
        loader.classList.add('hidden');
    },

    updateProgress: function (currentChunk, totalChunks) {
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');

        const percentage = (currentChunk / totalChunks) * 100;
        progressBar.style.width = percentage + '%';
        progressPercentage.innerText = Math.round(percentage) + '%';
    },

    fileInputInit: function () {
        document.getElementById('fileInput').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                this.uploadFile(file).then(r => {});
            }
        });
    },

    init: function () {
        this.fileInputInit();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    fileInput.init();
});