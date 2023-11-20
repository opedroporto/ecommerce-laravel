@extends("password.layout")

@section("title", "Resetar senha")

@push('styles')
    
@endpush

@section("content")

<div class="container">

    <div class="form-wrapper">
        @if ($msg = Session::get("success_msg"))
            <p class="success-msg">{{ $msg }}</p>
        @else
                <h1 class="form-title">Redefinir senha:</h1>
                <form class="form" action="{{ route("login.resetarsenha2") }}" method="POST">
                    @csrf
                    <div>
                        <label>E-mail:</labeL>
                        <input class="{{ ($errors->first('email') || $errors->first("email") ? " input-error" : "") }}" value="{{ old("email") }}" type="text" name="email">
                        <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
                    </div>

                    <button class="form-btn" type="submit">Enviar link de redefinição</button>
                </form>
        @endif
    </div>

</div>

@endsection

@push('scripts')
@endpush

