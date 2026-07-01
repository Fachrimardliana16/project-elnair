<div 
    x-data="{ showModal: false, activeImageUrl: '' }"
    @open-image-modal.window="showModal = true; activeImageUrl = $event.detail.url"
>
    <!-- Modal Backdrop -->
    <div 
        x-show="showModal" 
        style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keyup.escape.window="showModal = false"
    >
        <!-- Modal Content (Image & Close button) -->
        <div 
            class="relative max-w-5xl w-full flex justify-center items-center"
            @click.outside="showModal = false"
        >
            <!-- Close Button -->
            <button 
                @click="showModal = false" 
                class="absolute -top-12 right-0 text-white hover:text-gray-300 focus:outline-none transition-colors"
                aria-label="Close image modal"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image -->
            <img 
                :src="activeImageUrl" 
                alt="Gallery Image Zoom" 
                class="max-h-[85vh] w-auto object-contain rounded-md shadow-2xl"
                x-show="showModal"
                x-transition:enter="ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
        </div>
    </div>
</div>
