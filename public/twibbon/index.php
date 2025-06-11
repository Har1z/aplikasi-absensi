<?php
    header("Cross-Origin-Opener-Policy: same-origin");
    header("Cross-Origin-Embedder-Policy: require-corp");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twibbon Maker - Frame WebM ke Video MP4</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --accent: #ff8a00;
            --success: #4CAF50;
            --dark: #1a1a2e;
            --light: #f8f9fa;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--light);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin: 20px 0;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .app-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .app-container {
                grid-template-columns: 1fr;
            }
        }
        
        .upload-section {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            font-size: 1.8rem;
            color: var(--accent);
        }
        
        .upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            min-height: 180px;
            justify-content: center;
        }
        
        .upload-area:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
        }
        
        .upload-icon {
            font-size: 3rem;
            opacity: 0.7;
        }
        
        .preview-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .preview-container {
            position: relative;
            width: 100%;
            background: #000;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 9/16;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        canvas {
            width: 100%;
            height: 100%;
            display: block;
        }
        
        .photo-controls {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .control-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .control-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        label {
            font-weight: 500;
            min-width: 80px;
        }
        
        input[type="range"] {
            flex: 1;
            height: 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.2);
            outline: none;
            -webkit-appearance: none;
        }
        
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--accent);
            cursor: pointer;
        }
        
        .btn {
            background: linear-gradient(to right, var(--accent), #da1b60);
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(218, 27, 96, 0.4);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(218, 27, 96, 0.6);
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        .btn:disabled {
            background: #555;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn i {
            font-size: 1.3rem;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: none;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .output-section {
            margin-top: 30px;
            display: none;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            text-align: center;
        }
        
        .progress-container {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #00c9ff, #92fe9d);
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .instructions {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .instructions h3 {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .steps {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        
        .step {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 20px;
            flex: 1;
            min-width: 250px;
            max-width: 300px;
        }
        
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: var(--accent);
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 10px;
            font-weight: bold;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            opacity: 0.8;
            font-size: 0.9rem;
            margin-top: auto;
        }
        
        .note {
            background: rgba(255, 217, 0, 0.15);
            border-left: 4px solid var(--accent);
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin: 15px 0;
            text-align: left;
            font-size: 0.9rem;
        }
        
        .drag-instruction {
            margin-top: 10px;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        #outputVideo {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            background: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-photo-video"></i> Twibbon MPLS 2025</h1>
            <!-- <p class="subtitle">Buat twibbon dengan frame WebM, atur posisi dan zoom foto, hasilkan video MP4</p> -->
        </header>
        
        <div class="app-container">
            <div class="upload-section">
                <h2 class="section-title"><i class="fas fa-cloud-upload-alt"></i> Unggah File</h2>
                
                <div class="upload-area" id="photoUpload">
                    <i class="fas fa-image upload-icon"></i>
                    <h3>Foto Anda</h3>
                    <p>Seret & lepas foto atau klik untuk memilih</p>
                    <p class="note">Format: JPG, PNG, atau WebP</p>
                </div>
                
                <div class="note">
                    <i class="fas fa-info-circle"></i> Setelah mengunggah foto, Anda dapat mengatur posisi dan zoom di area preview
                </div>
            </div>
            
            <div class="preview-section">
                <h2 class="section-title"><i class="fas fa-sliders-h"></i> Pengaturan & Preview</h2>
                
                <div class="preview-container">
                    <canvas id="previewCanvas"></canvas>
                </div>
                <p class="drag-instruction"><i class="fas fa-hand-point-up"></i> Seret foto di atas untuk mengatur posisinya</p>
                
                <div class="photo-controls">
                    <div class="control-group">
                        <div class="control-row">
                            <label for="zoomSlider">Zoom Foto:</label>
                            <input type="range" id="zoomSlider" min="0.1" max="3" step="0.05" value="1">
                            <span id="zoomValue">100%</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <div class="control-row">
                            <label for="opacitySlider">Transparansi Frame:</label>
                            <input type="range" id="opacitySlider" min="0" max="1" step="0.05" value="1">
                            <span id="opacityValue">100%</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <div class="control-row">
                            <button class="btn btn-secondary" id="resetBtn">
                                <i class="fas fa-redo"></i> Reset Posisi
                            </button>
                            <button class="btn" id="generateBtn" disabled>
                                <i class="fas fa-cogs"></i> Hasilkan Video
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="progress-container" id="progressContainer" style="display: none;">
                    <div class="progress-bar" id="progressBar"></div>
                </div>
                
                <div class="output-section" id="outputSection">
                    <h2 class="section-title"><i class="fas fa-file-video"></i> Video Siap!</h2>
                    <video id="outputVideo" controls></video>
                    <a class="btn" id="downloadBtn">
                        <i class="fas fa-download"></i> Unduh Video
                    </a>
                </div>
            </div>
        </div>
        
        <div class="instructions">
            <h3><i class="fas fa-info-circle"></i> Cara Menggunakan</h3>
            <div class="steps">
                <!-- <div class="step">
                    <span class="step-number">1</span> Unggah frame WebM dengan area transparan untuk foto
                </div> -->
                <div class="step">
                    <span class="step-number">2</span> Unggah foto yang ingin Anda gunakan
                </div>
                <div class="step">
                    <span class="step-number">3</span> Atur posisi dan zoom foto dengan drag & drop atau slider
                </div>
                <div class="step">
                    <span class="step-number">4</span> Hasilkan video dan unduh hasilnya
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>© 2023 Twibbon Maker Pro | Semua pemrosesan dilakukan di perangkat Anda</p>
    </footer>
    
    <!-- Load FFmpeg for MP4 conversion -->
    <script src="https://unpkg.com/@ffmpeg/ffmpeg@0.11.0/dist/ffmpeg.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg@0.12.15/dist/umd/ffmpeg.min.js"></script> -->

    
    <script>
        // Elemen DOM
        const frameUpload = document.getElementById('frameUpload');
        const photoUpload = document.getElementById('photoUpload');
        const generateBtn = document.getElementById('generateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const previewCanvas = document.getElementById('previewCanvas');
        const ctx = previewCanvas.getContext('2d');
        const zoomSlider = document.getElementById('zoomSlider');
        const zoomValue = document.getElementById('zoomValue');
        const opacitySlider = document.getElementById('opacitySlider');
        const opacityValue = document.getElementById('opacityValue');
        const progressBar = document.getElementById('progressBar');
        const progressContainer = document.getElementById('progressContainer');
        const outputSection = document.getElementById('outputSection');
        const outputVideo = document.getElementById('outputVideo');
        const downloadBtn = document.getElementById('downloadBtn');
        
        // State aplikasi
        let isConverting = false;
        let webmFrame = null;
        let userPhoto = null;
        let frameVideo = document.createElement('video');
        let framePreview = new Image();
        let photoTransform = {
            x: 0,
            y: 0,
            scale: 1,
            originalWidth: 0,
            originalHeight: 0,
            isDragging: false,
            dragStartX: 0,
            dragStartY: 0
        };
        let frameOpacity = 1;
        let mediaRecorder = null;
        let recordedChunks = [];
        let ffmpeg = null;
        
        // Inisialisasi FFmpeg jika diperlukan
        async function initFFmpeg() {
            if (!ffmpeg) {
                const { createFFmpeg } = FFmpeg;
                ffmpeg = createFFmpeg({ 
                    log: true ,
                    corePath: 'https://unpkg.com/@ffmpeg/core@0.11.0/dist/ffmpeg-core.js',
                });
                await ffmpeg.load();
            }
        }
        
        // Fungsi untuk menangani upload file
        function setupUpload(element, type) {
            element.addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = type === 'video' ? 'video/webm' : 'image/*';
                
                input.onchange = e => {
                    const file = e.target.files[0];
                    if (file) {
                        handleFile(file, type);
                    }
                };
                
                input.click();
            });
            
            // Handle drag and drop
            element.addEventListener('dragover', e => {
                e.preventDefault();
                element.style.background = 'rgba(255, 255, 255, 0.15)';
            });
            
            element.addEventListener('dragleave', () => {
                element.style.background = '';
            });
            
            element.addEventListener('drop', e => {
                e.preventDefault();
                element.style.background = '';
                
                const file = e.dataTransfer.files[0];
                if (file) {
                    const fileType = type === 'video' ? 
                        file.type === 'video/webm' : 
                        file.type.startsWith('image/');
                    
                    if (fileType) {
                        handleFile(file, type);
                    } else {
                        alert(`Silakan unggah file ${type === 'video' ? 'WebM' : 'gambar'}`);
                    }
                }
            });
        }
        
        // Memproses file yang diunggah
        function handleFile(file, type) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (type === 'video') {
                    webmFrame = 'e.target.result';
                    frameVideo.src = webmFrame;
                    frameVideo.loop = true;
                    frameVideo.muted = true;
                    
                    frameVideo.onloadedmetadata = () => {
                        previewCanvas.width = frameVideo.videoWidth;
                        previewCanvas.height = frameVideo.videoHeight;
                        frameVideo.play();
                        drawPreview();
                    };
                    
                    frameUpload.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #4CAF50; font-size: 2.5rem;"></i>
                        <h3>Frame WebM Terunggah</h3>
                        <p>${file.name}</p>
                        <p>${Math.round(file.size / 1024)} KB</p>
                    `;
                } else {
                    userPhoto = new Image();
                    userPhoto.src = e.target.result;
                    
                    userPhoto.onload = () => {
                        // Simpan dimensi asli foto
                        photoTransform.originalWidth = userPhoto.width;
                        photoTransform.originalHeight = userPhoto.height;
                        
                        // Set posisi awal ke tengah
                        photoTransform.x = (previewCanvas.width - userPhoto.width) / 2;
                        photoTransform.y = (previewCanvas.height - userPhoto.height) / 2;
                        
                        drawPreview();
                    };
                    
                    photoUpload.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #4CAF50; font-size: 2.5rem;"></i>
                        <h3>Foto Terunggah</h3>
                        <img src="${e.target.result}" style="max-width: 100px; max-height: 100px; border-radius: 5px; margin: 10px 0;">
                        <p>${file.name}</p>
                    `;
                }
                
                // Aktifkan tombol generate jika kedua file sudah diunggah
                if (webmFrame && userPhoto) {
                    generateBtn.disabled = false;
                }
            };
            
            reader.readAsDataURL(file);
        }
        
        // Menggambar preview di canvas dengan transformasi
        function drawPreview() {
            if (!userPhoto || !frameVideo) return;
            
            // ctx.clearRect(0, 0, previewCanvas.width, previewCanvas.height);
            
            // Gambar foto pengguna dengan transformasi
            const scaledWidth = photoTransform.originalWidth * photoTransform.scale;
            const scaledHeight = photoTransform.originalHeight * photoTransform.scale;
            
            ctx.drawImage(
                userPhoto, 
                photoTransform.x, 
                photoTransform.y, 
                scaledWidth, 
                scaledHeight
            );
            
            // Gambar frame WebM di atas foto dengan transparansi
            ctx.globalAlpha = frameOpacity;
            ctx.drawImage(isConverting ? frameVideo : framePreview, 0, 0, previewCanvas.width, previewCanvas.height);
            frameVideo.play();
            ctx.globalAlpha = 1;
            
            // Lanjutkan animasi
            requestAnimationFrame(drawPreview);
        }
        
        // Implementasi drag untuk foto
        previewCanvas.addEventListener('mousedown', (e) => {
            if (!userPhoto) return;
            
            if (!isConverting) {
                photoTransform.isDragging = true;
                photoTransform.dragStartX = e.clientX - photoTransform.x;
                photoTransform.dragStartY = e.clientY - photoTransform.y;
                previewCanvas.style.cursor = 'grabbing';
            }
        });
        
        previewCanvas.addEventListener('mousemove', (e) => {
            if (!photoTransform.isDragging || !userPhoto) return;
            
            if (!isConverting) {
                photoTransform.x = e.clientX - photoTransform.dragStartX;
                photoTransform.y = e.clientY - photoTransform.dragStartY;
            }
        });
        
        previewCanvas.addEventListener('mouseup', () => {
            if (!isConverting) {
                photoTransform.isDragging = false;
                previewCanvas.style.cursor = 'grab';
            }
        });
        
        previewCanvas.addEventListener('mouseleave', () => {
            if (!isConverting) {
                photoTransform.isDragging = false;
                previewCanvas.style.cursor = 'default';
            }
        });
        
        previewCanvas.addEventListener('mouseenter', () => {
            if (userPhoto) {
                if (!isConverting) {
                    previewCanvas.style.cursor = 'grab';
                }
            }
        });
        
        // Event untuk slider zoom
        zoomSlider.addEventListener('input', (e) => {
            photoTransform.scale = parseFloat(e.target.value);
            zoomValue.textContent = `${Math.round(photoTransform.scale * 100)}%`;
        });
        
        // Event untuk slider opacity
        opacitySlider.addEventListener('input', (e) => {
            frameOpacity = parseFloat(e.target.value);
            opacityValue.textContent = `${Math.round(frameOpacity * 100)}%`;
        });
        
        // Reset posisi dan zoom
        resetBtn.addEventListener('click', () => {
            if (!userPhoto) return;
            
            photoTransform.scale = 1;
            photoTransform.x = (previewCanvas.width - userPhoto.width) / 2;
            photoTransform.y = (previewCanvas.height - userPhoto.height) / 2;
            zoomSlider.value = 1;
            zoomValue.textContent = "100%";
            opacitySlider.value = 1;
            opacityValue.textContent = "100%";
            frameOpacity = 1;
        });

        function record(canvas, time) {

        }

        generateBtn.addEventListener('click', async () => {
            if (!webmFrame || !userPhoto) return;
            
            generateBtn.disabled = true;
            zoomSlider.disabled = true
            opacitySlider.disabled = true;
            resetBtn.disabled = true;
            isConverting = true;
            progressContainer.style.display = 'block';
            progressBar.style.width = '0%';

            try {
                var recordedChunks = [];
                const stream = previewCanvas.captureStream(60);
                mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/mp4; codecs=avc1.42E01E' });

                //ondataavailable will fire in interval of `time || 4000 ms`
                frameVideo.currentTime = 0;
                await frameVideo.play();
                mediaRecorder.start(15500); // no timeout needed

                // Update progress bar
                const duration = 15500; // 15 seconds recording
                let progress = 0;
                const totalSteps = 20;
                const interval = duration / totalSteps;

                const progressInterval = setInterval(() => {
                    progress += 100 / totalSteps;
                    progressBar.style.width = `${Math.min(progress, 100)}%`;

                    if (progress >= 100) {
                        clearInterval(progressInterval);
                    }
                }, interval);

                mediaRecorder.ondataavailable = function (event) {
                    recordedChunks.push(event.data);
                    // after stop `dataavilable` event run one more time
                    if (mediaRecorder.state === 'recording') {
                        mediaRecorder.stop();
                    }
                }  

                mediaRecorder.onstop = function (event) {
                    var blob = new Blob(recordedChunks, {type: "video/mp4" });
                    var url = URL.createObjectURL(blob);
                    // res(url);

                    // Display the result
                    outputVideo.src = url;
                    outputSection.style.display = 'flex';
                    progressBar.style.width = '100%';
                    
                    // Setup download button
                    downloadBtn.href = url;
                    downloadBtn.download = `twibbon-${Date.now()}.mp4`;
                    
                    // Scroll to output
                    setTimeout(() => {
                        outputSection.scrollIntoView({ behavior: 'smooth' });
                    }, 500);
                }

            } catch(error) {
                alert(error);
                generateBtn.disabled = false;
                zoomSlider.disabled = false
                opacitySlider.disabled = false;
                resetBtn.disabled = false;
                isConverting = false;
            }
        })
        
        setupUpload(photoUpload, 'image');
        webmFrame = 'assets/twibbon.webm';
        frameVideo.src = webmFrame;
        frameVideo.loop = true;
        frameVideo.muted = true;
        
        frameVideo.onloadedmetadata = () => {
            previewCanvas.width = frameVideo.videoWidth;
            previewCanvas.height = frameVideo.videoHeight;
        };

        pngFrame = 'assets/preview.png';
        framePreview.src = pngFrame;

    </script>
</body>
</html>