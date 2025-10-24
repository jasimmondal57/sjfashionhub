@php
    $headerSettings = \App\Models\HeaderSetting::getActiveSettings();
@endphp

@if($headerSettings->logo_image)
    <img src="{{ Storage::url($headerSettings->logo_image) }}" alt="SJ Fashion Hub" {{ $attributes->merge(['class' => 'max-w-full h-auto']) }} />
@else
    <!-- Fallback text logo if no image is uploaded -->
    <div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center bg-gradient-to-br from-purple-600 to-pink-600 text-white rounded-lg shadow-lg']) }}>
        <div class="text-center p-4">
            <div class="text-2xl font-bold mb-1">👗</div>
            <div class="text-lg font-bold">SJ</div>
            <div class="text-sm font-medium">FASHION</div>
            <div class="text-xs">HUB</div>
        </div>
    </div>
@endif
