<x-main-layout pageTitle="Result">
    <x-slot:content>
    <div class="container">

        <x-question country="{{ $country }}" :total="$totalQuestions" :number="$currentQuestion" />

        <div class="text-center fs-3 mb-3">
            Resposta correta: <span class="text-info">{{ $correctAnswer }}</span>
        </div>

        <div class="text-center fs-3 mb-3">
            A sua resposta: <span class="text-info">{{ $choiceAnswer }}</span>
        </div>

        </div>

        <div class="text-center mt-5">
            <a href="{{ route('next') }}" class="btn btn-primary mt-3 px-5">AVANÇAR</a>
        </div>
    </x-slot:content>
</x-main-layout>