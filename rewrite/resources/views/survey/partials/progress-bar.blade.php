<!-- Progress Bar -->
<div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Progress Survei</h3>
        <span class="text-sm text-gray-600">{{ $stepNumber }} dari {{ $totalSteps }} langkah</span>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
    </div>

    <!-- Step Indicators -->
    <div class="grid grid-cols-6 gap-2">
        @php
            $steps = [
                'profile' => 'Profil',
                'importance' => 'Harapan',
                'performance' => 'Persepsi',
                'satisfaction' => 'Kepuasan',
                'loyalty' => 'Loyalitas',
                'feedback' => 'Saran'
            ];
        @endphp

        @foreach($steps as $stepKey => $stepName)
            <div class="text-center">
                <div class="relative">
                    <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center text-xs font-bold
                        @if($stepKey === $step)
                            bg-blue-600 text-white
                        @elseif(array_search($stepKey, array_keys($steps)) < array_search($step, array_keys($steps)))
                            bg-green-600 text-white
                        @else
                            bg-gray-300 text-gray-600
                        @endif">
                        {{ array_search($stepKey, array_keys($steps)) + 1 }}
                    </div>
                    <div class="text-xs mt-1 text-gray-600">{{ $stepName }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>