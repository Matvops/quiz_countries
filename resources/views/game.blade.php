<x-main_layout pageTitle="Question">
    <x-slot:content>

        <div class="container">
            <x-question :country="$country" :number="$currentQuestion" :total="$totalQuestions"/>

            <div class="row">
                @foreach ($answers as $answer)
                    <x-answer :answer="$answer"/>
                @endforeach
            </div>

        </div>

        <!-- cancel game -->
        <div class="text-center mt-5">
            <a href="{{ route('start') }}" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
        </div>

    </x-slot:content>
</x-main_layout>