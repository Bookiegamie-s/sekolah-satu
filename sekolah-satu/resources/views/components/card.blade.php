@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'blue',
    'actions' => null
])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @if($title || $icon)
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($icon)
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 bg-{{ $iconColor }}-500 rounded-full flex items-center justify-center">
                                {!! $icon !!}
                            </div>
                        </div>
                    @endif
                    <div>
                        @if($title)
                            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                        @endif
                        @if($subtitle)
                            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
                @if($actions)
                    <div class="flex space-x-2">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
