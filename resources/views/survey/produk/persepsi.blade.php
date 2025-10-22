<x-guest-layout title="Penilaian Persepsi - Survei Kepuasan Produk">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
	<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Progress Bar -->
		<div class="mb-8">
			@include('survey.partials.progress-bar')
		</div>

		<!-- Form -->
		<div class="bg-white shadow-lg rounded-lg overflow-hidden">
			<div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
				<h2 class="text-2xl font-bold text-white">III. Penilaian Persepsi Produk</h2>
				<p class="text-purple-100 mt-1">Berikan penilaian sesuai dengan pengalaman Anda terhadap kinerja kualitas produk</p>
			</div>

			<form method="POST" action="{{ route('survey.produk.store', ['step' => 'persepsi']) }}" class="p-6">
				@csrf

				@if(session('success'))
					<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
						{{ session('success') }}
					</div>
				@endif

				@if($errors->any())
					<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
						<ul class="list-disc list-inside">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<!-- Sections copied from original template -->
				@php $reliabilityData = $survey->getAnswers('persepsi', 'reliability') ?? []; @endphp
				@php
				// Helper: render select for persepsi. Default to '0' to avoid empty value issues
				function renderPersepsiSelect($name, $data, $key, $default = null) {
					$selected = $data[$key] ?? old($name) ?? $default ?? '0';
					$options = [
						'0' => '0 - Tidak Relevan',
						'1' => '1 - Sangat Tidak Setuju',
						'2' => '2 - Tidak Setuju',
						'3' => '3 - Netral',
						'4' => '4 - Setuju',
						'5' => '5 - Sangat Setuju'
					];

					$html = '<select name="' . $name . '" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>';
					foreach ($options as $value => $label) {
						$selectedAttr = ((string)$selected === (string)$value) ? ' selected' : '';
						$html .= '<option value="' . $value . '"' . $selectedAttr . '>' . $label . '</option>';
					}
					$html .= '</select>';
					return $html;
				}
				@endphp

				<div class="grid md:grid-cols-2 gap-4">
					@php $counter = 1; @endphp
					@if(!empty($questions['persepsi_answers']['reliability']))
						@foreach($questions['persepsi_answers']['reliability'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('reliability[' . $key . ']', $reliabilityData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					@else
						<div class="col-span-2 text-sm text-gray-500">Tidak ada pertanyaan untuk bagian Reliability.</div>
					@endif
				</div>

				<!-- Assurance, Tangible, Empathy, Responsiveness, Applicability sections -->
				@php $assuranceData = $survey->getAnswers('persepsi', 'assurance') ?? []; @endphp
				@if(!empty($questions['persepsi_answers']['assurance']))
					<div class="mt-6 grid md:grid-cols-2 gap-4">
						@php $counter = 1; @endphp
						@foreach($questions['persepsi_answers']['assurance'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('assurance[' . $key . ']', $assuranceData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					</div>
				@endif

				@php $tangibleData = $survey->getAnswers('persepsi', 'tangible') ?? []; @endphp
				@if(!empty($questions['persepsi_answers']['tangible']))
					<div class="mt-6 grid md:grid-cols-2 gap-4">
						@php $counter = 1; @endphp
						@foreach($questions['persepsi_answers']['tangible'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('tangible[' . $key . ']', $tangibleData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					</div>
				@endif

				@php $empathyData = $survey->getAnswers('persepsi', 'empathy') ?? []; @endphp
				@if(!empty($questions['persepsi_answers']['empathy']))
					<div class="mt-6 grid md:grid-cols-2 gap-4">
						@php $counter = 1; @endphp
						@foreach($questions['persepsi_answers']['empathy'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('empathy[' . $key . ']', $empathyData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					</div>
				@endif

				@php $responsivenessData = $survey->getAnswers('persepsi', 'responsiveness') ?? []; @endphp
				@if(!empty($questions['persepsi_answers']['responsiveness']))
					<div class="mt-6 grid md:grid-cols-2 gap-4">
						@php $counter = 1; @endphp
						@foreach($questions['persepsi_answers']['responsiveness'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('responsiveness[' . $key . ']', $responsivenessData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					</div>
				@endif

				@php $applicabilityData = $survey->getAnswers('persepsi', 'applicability') ?? []; @endphp
				@if(!empty($questions['persepsi_answers']['applicability']))
					<div class="mt-6 grid md:grid-cols-2 gap-4">
						@php $counter = 1; @endphp
						@foreach($questions['persepsi_answers']['applicability'] as $key => $question)
						<div>
							<label class="block text-sm font-medium text-gray-700 mb-2">{{ $counter }}. {{ $question }}</label>
							{!! renderPersepsiSelect('applicability[' . $key . ']', $applicabilityData, $key) !!}
						</div>
						@php $counter++; @endphp
						@endforeach
					</div>
				@endif

				<!-- Navigation Buttons -->
				<div class="mt-8 flex justify-between">
					<div>
						@if($canGoBack)
							<a href="{{ route('survey.produk.step', ['step' => \App\Http\Controllers\ProdukSurveyController::getPreviousStep($step)]) }}"
							   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
								<i class="fas fa-arrow-left mr-1"></i>Kembali
							</a>
						@endif
					</div>
					<div>
						<button type="submit" name="action" value="next" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
							Lanjut <i class="fas fa-arrow-right ml-2"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
// localStorage management similar to harapan
document.addEventListener('DOMContentLoaded', function() {
	const sessionToken = '{{ $survey->session_token }}';
	const step = '{{ $step }}';
	const storageKey = `survey_${sessionToken}_${step}`;
	// load and save functions omitted for brevity (same as harapan)
});
</script>
</x-mylayout>
