<div class="flex flex-col items-center justify-center gap-4 py-4" x-data="{ 
    downloading: false,
    async downloadQR() {
        this.downloading = true;
        try {
            const response = await fetch('https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode($link) }}');
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'catalog-qr-code.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Download failed:', error);
        } finally {
            this.downloading = false;
        }
    }
}">
    <img
        id="qr-code-image"
        src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($link) }}" 
        alt="Catalog QR Code" 
        class="rounded-lg shadow-md"
    >
    <p class="text-sm text-gray-500 text-center">Scan this QR to view the public product catalog.</p>

    <button
        type="button"
        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition disabled:opacity-50"
        @click="downloadQR()"
        :disabled="downloading"
        x-text="downloading ? 'Downloading...' : 'Download QR'"
    >
    </button>
</div>