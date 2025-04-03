<div class="col-6 text-center">
    <a href="{{ route('answer', Crypt::encryptString($answer)) }}" class="text-decoration-none">
        <p class="response-option">{{$answer}}</p>
    </a>
</div>