@if (session('success'))
    <div class="message__success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="message__error">
        {{ session('error') }}
    </div>
@endif
