<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-gray-700">Langkah 2 dari 3</span>
                    <span class="text-sm font-medium text-gray-700">67%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 67%"></div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Asesmen Prioritas Kepentingan</h2>
                <p class="text-gray-600 mb-6">Silahkan melakukan pembobotan kelipatan 5 untuk item yang ingin
                    diprioritaskan. Total bobot dari item yang diisi harus sama dengan 100.</p>

                <!-- Total Display -->
                <div class="bg-gray-100 p-4 rounded-lg mb-6 sticky top-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Total Bobot</h3>
                        <span id="total-display"
                            class="text-2xl font-bold {{ collect($data['priority'] ?? [])->sum() == 100 ? 'text-green-600' : 'text-red-600' }}">
                            {{ collect($data['priority'] ?? [])->sum() }}/100
                        </span>
                    </div>
                </div>

                <form id="priority-form"
                    action="{{ route('customer-management-evaluation.store-priority', ['token' => request()->route('token')]) }}"
                    method="POST">
                    @csrf

                    <!-- Priority Items -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $priorityItems = app(\App\Services\SurveyQuestionService::class)->getPriorityItems();
                        @endphp

                        @foreach($priorityItems as $key => $item)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $item['label'] }}
                                </label>
                                <p class="text-xs text-gray-500 mb-3">{{ $item['description'] }}</p>
                                <input type="number" name="{{ $key }}" min="0" max="100" step="5"
                                    value="{{ $data['priority'][$key] ?? '' }}"
                                    class="priority-input mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Opsional, kelipatan 5">
                                @error($key)
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    @error('total')
                        <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Navigation Buttons -->
                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('customer-management-evaluation.maturity', ['token' => request()->route('token')]) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        <button type="submit" id="submit-btn"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white {{ collect($data['priority'] ?? [])->sum() == 100 ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-400 cursor-not-allowed' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            {{ collect($data['priority'] ?? [])->sum() != 100 ? 'disabled' : '' }}>
                            Selanjutnya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.priority-input');
            const totalDisplay = document.getElementById('total-display');
            const submitBtn = document.getElementById('submit-btn');

            function updateTotal() {
                let total = 0;
                let filledCount = 0;
                inputs.forEach(input => {
                    const value = parseInt(input.value) || 0;
                    if (input.value !== '' && input.value !== '0') {
                        if (value % 5 !== 0) {
                            input.style.borderColor = 'red';
                        } else {
                            input.style.borderColor = '#d1d5db';
                        }
                        total += value;
                        filledCount++;
                    } else {
                        input.style.borderColor = '#d1d5db';
                    }
                });

                totalDisplay.textContent = total + '/100';
                if (filledCount > 0 && total === 100) {
                    totalDisplay.className = 'text-2xl font-bold text-green-600';
                    submitBtn.className = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
                    submitBtn.disabled = false;
                } else if (filledCount === 0) {
                    totalDisplay.className = 'text-2xl font-bold text-gray-600';
                    submitBtn.className = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed';
                    submitBtn.disabled = true;
                } else {
                    totalDisplay.className = 'text-2xl font-bold text-red-600';
                    submitBtn.className = 'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed';
                    submitBtn.disabled = true;
                }
            }

            inputs.forEach(input => {
                input.addEventListener('input', updateTotal);
            });

            updateTotal(); // Initial calculation
        });
    </script>
</x-guest-layout>