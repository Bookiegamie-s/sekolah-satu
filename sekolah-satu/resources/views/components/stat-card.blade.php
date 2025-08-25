@props([
    'title',
    'value',
    'icon',
    'color' => 'blue',
    'change' => null,
    'changeType' => null
])

<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-{{ $color }}-500 rounded-full flex items-center justify-center">
                {!! $icon !!}
            </div>
        </div>
        <div class="ml-4 flex-1">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <div class="flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
                @if($change && $changeType)
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($changeType === 'increase') bg-green-100 text-green-800
                        @elseif($changeType === 'decrease') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        @if($changeType === 'increase')
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L10 4.414 6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($changeType === 'decrease')
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L10 15.586l3.293-3.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ $change }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
