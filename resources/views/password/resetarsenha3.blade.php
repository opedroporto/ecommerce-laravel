@extends("password.layout")

@section("title", "Resetar senha")

@push('styles')
    
@endpush

@section("content")

<div class="container">

    <div class="form-wrapper">
        <h1 class="form-title">Redefinir senha:</h1>

        

        <form class="form" action="{{ route("login.resetarsenha4") }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label>E-mail:</labeL>
                <input class="{{ ($errors->first('email') || $errors->first("email") ? " input-error" : "") }}" value="{{ old("email") }}" type="text" name="email">
                <p class="error-msg">{{ $errors->first('email') ? $errors->first('email') : "" }}</p>
            </div>

            <div>
                <label>Nova senha:</label>
                <input class="{{ ($errors->first('senha') || $errors->first("senha") ? " input-error" : "") }}" type="password" name="senha">
                <p class="error-msg">{{ $errors->first('senha') ? $errors->first('senha') : "" }}</p>
            </div>

            <div>
                <label>Confirmar nova senha:</label>
                <input class="{{ ($errors->first('senha') || $errors->first("senha") ? " input-error" : "") }}" type="password" name="senha_confirmation">
                <p class="error-msg">{{ $errors->first('senha') ? $errors->first('senha') : "" }}</p>
            </div>

            @if ($errors->first("msg"))
                <div class="error-msg">
                    <ul>
                        <li>{{ $errors->first("msg") }}</li>
                    </ul>
                </div>
            @endif

            <button class="form-btn" type="submit">Redefinir senha</button>
        </form>

    </div>

    

</div>

@endsection

@push('scripts')
@endpush


