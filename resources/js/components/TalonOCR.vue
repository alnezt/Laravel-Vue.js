<template>
    <div class="simple-ocr-container">
        <h2>Scanare Talon Auto</h2>

        <div class="upload-box" @click="triggerFileInput">
            <div v-if="!imagePreview" class="upload-placeholder">
                <span>+</span>
                <p>Click pentru a încărca o poză a talonului</p>
            </div>
            <img v-else :src="imagePreview" class="image-preview" alt="Preview imagine talon">
            <input
                type="file"
                ref="fileInput"
                @change="handleImageUpload"
                accept="image/*"
                class="file-input"
            >
        </div>

        <button
            @click="processImage"
            :disabled="!imageFile || isLoading"
            class="scan-button"
        >
            <span v-if="!isLoading">Scanare</span>
            <span v-else>Se procesează...</span>
        </button>

        <div v-if="isLoading" class="loading">
            <div class="spinner"></div>
            <p>Se procesează imaginea...</p>
        </div>

        <div v-if="error" class="error-message">
            {{ error }}
        </div>

        <div v-if="ocrData" class="results">
            <h3>Date extrase:</h3>
            <pre>{{ ocrData['Text extras'] }}</pre>
            <details v-if="ocrData['Rezultate brute']">
                <summary>Detalii tehnice</summary>
                <pre>{{ ocrData['Rezultate brute'] }}</pre>
            </details>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const fileInput = ref(null);
const imageFile = ref(null);
const imagePreview = ref(null);
const ocrData = ref(null);
const isLoading = ref(false);
const error = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    // Verifică tipul fișierului
    if (!file.type.match('image.*')) {
        error.value = 'Vă rugăm să încărcați doar imagini (JPEG, PNG)';
        return;
    }

    // Verifică dimensiunea fișierului (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        error.value = 'Fișierul este prea mare (maxim 5MB)';
        return;
    }

    imageFile.value = file;
    error.value = null;
    ocrData.value = null;

    // Crează previzualizare
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

const processImage = async () => {
    if (!imageFile.value) return;

    isLoading.value = true;
    error.value = null;

    try {
        const formData = new FormData();
        formData.append('image', imageFile.value);

        // Adaugă timestamp pentru cache busting
        const timestamp = new Date().getTime();
        const url = `/api/process-talon?t=${timestamp}`;

        const response = await axios.post(url, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-Requested-With': 'XMLHttpRequest'
            },
            timeout: 30000 // 30 de secunde timeout
        });

        // Procesează răspunsul
        if (response.data && response.data.text) {
            ocrData.value = {
                'Text extras': response.data.text.join('\n'),
                'Rezultate brute': JSON.stringify(response.data, null, 2)
            };
        } else {
            throw new Error('Răspuns neașteptat de la server');
        }

    } catch (err) {
        console.error('Eroare la procesare:', err);
        error.value = 'Eroare la procesare: ' +
            (err.response?.data?.error ||
                err.response?.data?.message ||
                err.message ||
                'Eroare necunoscută');

        // Log detaliat pentru debugging
        if (err.response) {
            console.error('Detalii răspuns:', {
                status: err.response.status,
                data: err.response.data,
                headers: err.response.headers
            });
        }
    } finally {
        isLoading.value = false;
    }
};
</script>

<style scoped>
.simple-ocr-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.upload-box {
    border: 2px dashed #3498db;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    margin-bottom: 1rem;
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    transition: border-color 0.3s;
}

.upload-box:hover {
    border-color: #2980b9;
}

.upload-placeholder {
    color: #7f8c8d;
}

.upload-placeholder span {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
    color: #3498db;
}

.file-input {
    display: none;
}

.image-preview {
    max-width: 100%;
    max-height: 300px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.scan-button {
    background: #3498db;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    display: block;
    margin: 1rem auto;
    width: 200px;
    transition: background 0.3s;
}

.scan-button:hover:not(:disabled) {
    background: #2980b9;
}

.scan-button:disabled {
    background: #95a5a6;
    cursor: not-allowed;
}

.loading {
    text-align: center;
    margin: 2rem 0;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top: 4px solid #3498db;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-message {
    color: #e74c3c;
    padding: 1rem;
    background: #fdecea;
    border-radius: 4px;
    margin: 1rem 0;
    border-left: 4px solid #e74c3c;
}

.results {
    margin-top: 2rem;
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.results pre {
    white-space: pre-wrap;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    border: 1px solid #eee;
}

details {
    margin-top: 1rem;
}

details summary {
    cursor: pointer;
    color: #3498db;
    font-weight: bold;
}

details pre {
    max-height: 200px;
    overflow-y: auto;
}
</style>
