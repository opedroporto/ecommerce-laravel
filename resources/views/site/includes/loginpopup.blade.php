<link rel="stylesheet" href="{{ asset("css/site/loginpopup.css") }}">

<div id="login-popup">
    <div id="login-popup-wrapper">
        {{-- <img id="login-img" src="https://capricho.abril.com.br/wp-content/uploads/2016/07/02210.jpg?quality=70&strip=all">
        <img id="login-img2" src="https://img.elo7.com.br/product/main/3E9AC85/kit-arco-desconstruido-princesinha-roxo-e-rosa-baloes-festa-roxa-15-anos.jpg"> --}}
        <div id="login-popup-box">
            <div id="top-bar">
                <i id="close-btn" class="fa-solid fa-xmark"></i>
            </div>
            <form id="login-popup-form" action="{{ route("login.login") }}" method="POST">
                @csrf
                <h1 id="login-title">Login</h1>
                @if ($msg = Session::get("login_msg"))
                    <p class="login-flash-msg">{{ $msg }}</p>
                @endif
                {{-- @if ($errors->login->any())
                    <div class="error-msg">
                        <ul>
                            @foreach ($errors->login->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                @if ($errors->login->first("invalid"))
                    <div class="error-msg">
                        <ul>
                            <li>{{ $errors->login->first("invalid") }}</li>
                        </ul>
                    </div>
                @endif
                <div>
                    <label id="cpf_email-lbl">E-mail:</label>
                    <div id="cpf_email-input-wrapper">
                        {{-- @if (old("cpf"))
                            {{ $old_cpf_email = old("cpf") }}
                        @elseif(old("email"))
                            {{ $old_cpf_email = old("email") }}
                        @else
                            {{ $old_cpf_email = "" }}
                        @endif --}}
                        @php
                            if (old("cpf")) {
                                $old_cpf_email = old("cpf");
                            }
                            elseif(old("email")) {
                                $old_cpf_email = old("email");
                            }
                            else {
                                $old_cpf_email = "";
                            }
                        @endphp
                        <input id="cpf_email" class="{{ ($errors->login->first('cpf') || $errors->login->first("email") ? " input-error" : "") }}" type="email" name="email" value="{{ $old_cpf_email }}" tabindex="1" required>
                        <button id="cpf_email-btn" type="button" tabindex="3">
                            <p id="cpf_email-btn-text">Logar com CPF</p>
                        </button>
                    </div>
                    <p class="error-msg">{{ $errors->login->first('cpf') ? $errors->login->first('cpf') : "" }}</p>
                    <p class="error-msg">{{ $errors->login->first('email') ? $errors->login->first('email') : "" }}</p>
                </div>
                <div>
                    <label>Senha:</label>
                    <input class="{{ ($errors->login->first('senha') ? "input-error" : "") }}" type="password" name="senha" minlength="8" maxlength="255" value="{{ old("senha") }}" tabindex="2" required>
                    <p class="error-msg">{{ $errors->login->first('senha') ? $errors->login->first('senha') : "" }}</p>
                    <a href="{{ route("login.resetarsenha") }}">Esqueceu sua senha?</a>
                </div>

                <div id="login-bottom">
                    <button id="login-btn" type="submit">Entrar</button>
                    <p class="login-bottom-msg">Ainda não é um cliente? <wbr> <a id="signup-btn">Cadastrar-se</a></p>
                </div>
            </form>
            <form id="signup-popup-form" action="{{ route("login.signup") }}" method="POST">
                @csrf
                <h1 id="login-title">Cadastro</h1>
                {{-- @if ($errors->signup->any())
                    <div class="error-msg">
                        <ul>
                            @foreach ($errors->signup->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <div>
                    <label>Nome:</label>
                    <input class="{{ ($errors->signup->first('nome') ? "input-error" : "") }}" type="text" name="nome" value="{{ old('nome') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('nome') ? $errors->signup->first('nome') : "" }}</p>
                </div>

                <div>
                    <label>Sobrenome:</label>
                    <input class="{{ ($errors->signup->first('sobrenome') ? "input-error" : "") }}" type="text" name="sobrenome" value="{{ old('sobrenome') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('sobrenome') ? $errors->signup->first('sobrenome') : "" }}</p>
                </div>

                <div>
                    <label>Data de nascimento:</label>
                    <input class="{{ ($errors->signup->first('datanasc') ? "input-error" : "") }}" type="date" name="datanasc" value="{{ old('datanasc') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('datanasc') ? $errors->signup->first('datanasc') : "" }}</p>
                </div>
                
                <div>
                    <label>Telefone:</label>
                    <input id="cad_tel" class="{{ ($errors->signup->first('telefone') ? "input-error" : "") }}" type="text" name="telefone" value="{{ old('telefone') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('telefone') ? $errors->signup->first('telefone') : "" }}</p>
                </div>

                <div>
                    <label>CPF:</label>
                    <input id="cad_cpf" class="{{ ($errors->signup->first('cpf') ? "input-error" : "") }}" type="text" name="cpf" value="{{ old('cpf') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('cpf') ? $errors->signup->first('cpf') : "" }}</p>
                </div>

                <div>
                    <label>E-mail:</label>
                    <input class="{{ ($errors->signup->first('email') ? "input-error" : "") }}" type="email" name="email" value="{{ old('email') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('email') ? $errors->signup->first('email') : "" }}</p>
                </div>
                
                <div>
                    <label>Senha:</label>
                    <input class="{{ ($errors->signup->first('senha') ? "input-error" : "") }}" type="password" name="senha"  minlength="8" maxlength="255" required>
                    <p class="error-msg">{{ $errors->signup->first('senha') ? $errors->signup->first('senha') : "" }}</p>
                </div>

                <p class="login-subtitle">Endereço</p>

                <div>
                    <label>CEP:</label>
                    <input id="cad_end_cep" class="{{ ($errors->signup->first('end_cep') ? "input-error" : "") }}" type="text" name="end_cep" value="{{ old('end_cep') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('end_cep') ? $errors->signup->first('end_cep') : "" }}</p>
                </div>

                <div class="login-flex-row">
                    <div>
                        <label>Rua:</label>
                        <input id="cad_end_rua" class="{{ ($errors->signup->first('end_rua') ? "input-error" : "") }}" type="text" name="end_rua" maxlength="50" value="{{ old('end_rua') }}" required>
                        <p class="error-msg">{{ $errors->signup->first('end_rua') ? $errors->signup->first('end_rua') : "" }}</p>
                    </div>
                    <div style="width: 30%;">
                        <label>Número:</label><br>
                        <input id="cad_end_num" class="{{ ($errors->signup->first('end_num') ? "input-error" : "") }}" type="text" name="end_num" maxlength="5" value="{{ old('end_num') }}" required>
                        <p class="error-msg">{{ $errors->signup->first('end_num') ? $errors->signup->first('end_num') : "" }}</p>
                    </div>
                </div>

                <div>
                    <label>Bairro:</label>
                    <input id="cad_end_bairro" class="{{ ($errors->signup->first('end_bairro') ? "input-error" : "") }}" type="text" name="end_bairro" maxlength="50" value="{{ old('end_bairro') }}" required>
                    <p class="error-msg">{{ $errors->signup->first('end_bairro') ? $errors->signup->first('end_bairro') : "" }}</p>
                </div>
                <div class="login-flex-row">
                    <div>
                        <label>Cidade:</label>
                        <input id="cad_end_cidade" class="{{ ($errors->signup->first('end_cidade') ? "input-error" : "") }}" type="text" name="end_cidade" maxlength="50" value="{{ old('end_cidade') }}" required>
                        <p class="error-msg">{{ $errors->signup->first('end_cidade') ? $errors->signup->first('end_cidade') : "" }}</p>
                    </div>
                    <div style="width: 30%;">
                        <label>UF:</label><br>
                        <select id="cad_end_uf" class="{{ ($errors->signup->first('end_uf') ? "input-error" : "") }}" name="end_uf" value="{{ old('end_uf') }}" required>
                            <option disabled selected value="">Selecione</option>
                            <option value="AC">AC (Acre)</option>
                            <option value="AL">AL (Alagoas)</option>
                            <option value="AP">AP (Amapá)</option>
                            <option value="AM">AM (Amazonas)</option>
                            <option value="BA">BA (Bahia)</option>
                            <option value="CE">CE (Ceará)</option>
                            <option value="DF">DF (Distrito Federal)</option>
                            <option value="ES">ES (Espirito Santo)</option>
                            <option value="GO">GO (Goiás)</option>
                            <option value="MA">MA (Maranhão)</option>
                            <option value="MS">MS (Mato Grosso do Sul)</option>
                            <option value="MT">MT (Mato Grosso)</option>
                            <option value="MG">MG (Minas Gerais)</option>
                            <option value="PA">PA (Pará)</option>
                            <option value="PB">PB (Paraíba)</option>
                            <option value="PR">PR (Paraná)</option>
                            <option value="PE">PE (Pernambuco)</option>
                            <option value="PI">PI (Piauí)</option>
                            <option value="RJ">RJ (Rio de Janeiro)</option>
                            <option value="RN">RN (Rio Grande do Norte)</option>
                            <option value="RS">RS (Rio Grande do Sul)</option>
                            <option value="RO">RO (Rondônia)</option>
                            <option value="RR">RR (Roraima)</option>
                            <option value="SC">SC (Santa Catarina)</option>
                            <option value="SP">SP (São Paulo)</option>
                            <option value="SE">SE (Sergipe)</option>
                            <option value="TO">TO (Tocantins)</option>
                        </select>
                        <p class="error-msg">{{ $errors->signup->first('end_uf') ? $errors->signup->first('end_uf') : "" }}</p>
                    </div>
                </div>
                <div>
                    <label>Complemento:</label>
                    <input id="cad_end_complemento" class="{{ ($errors->signup->first('end_complemento') ? "input-error" : "") }}" type="text" name="end_complemento" value="{{ old('complemento') }}">
                    <p class="error-msg">{{ $errors->signup->first('end_complemento') ? $errors->signup->first('end_complemento') : "" }}</p>
                </div>

                <div id="login-bottom">
                    <button id="login-btn" type="submit">Cadastrar-se</button>
                    <p class="login-bottom-msg">Já é um cliente? <wbr> <a id="signin-btn">Entrar</a></p>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script src="{{ asset("js/jquery/jquery.inputmask.min.js") }}"></script>
<script>
        {{-- @if (Session::get("black_bg"))
            blackBg();
        @endif
        function blackBg() {
            $("#login-popup-wrapper").css("background-color", "black")
        } --}}

        @if (Session::get("login_needed"))
                loginPopupShow();
        @endif

        @if ($errors->login->any())
            loginPopupShow();
        @elseif ($errors->signup->any())
            loginPopupShow();
            goToSignup();
        @endif


        $(document).ready(function() {
            checkWrapBtnText();

            $("#login-img").height($("#login-popup-box").outerHeight());
            $("#login-img2").height($("#login-popup-box").outerHeight());

            $("#cad_cpf").inputmask("999.999.999-99");
            $("#cad_tel").inputmask("(99) 99999-9999");

            $("#cad_end_cep").inputmask("99999-999");
        });

        $(window).resize(function() {
            checkWrapBtnText();
        });

        function checkWrapBtnText() {
            if ($(window).width() > 960) {
                if ($("#cpf_email-btn-text").text() == "E-mail") {
                    $("#cpf_email-btn-text").text("Logar com E-mail");
                }
                if ($("#cpf_email-btn-text").text() == "CPF") {
                    $("#cpf_email-btn-text").text("Logar com CPF");
                }
            }
            else {
                if ($("#cpf_email-btn-text").text() == "Logar com E-mail") {
                    $("#cpf_email-btn-text").text("E-mail");
                }
                if ($("#cpf_email-btn-text").text() == "Logar com CPF") {
                    $("#cpf_email-btn-text").text("CPF");
                }
            }
        }

        $("#cad_end_cep").change(() => {
            checkCep();
        });
        
        async function checkCep() {
            let cep = $("#cad_end_cep").val();

            if (cep.match(/^[0-9]{5}-[0-9]{3}$/)) {
                let url = "https://viacep.com.br/ws/" + cep + "/json/";
                let response = await fetch(url);
                let end = await response.json();
    
                if (!$("#cad_end_cidade").val()) {
                    $("#cad_end_cidade").val(end["localidade"]);   
                }
                if (!$("#cad_end_bairro").val()) {
                    $("#cad_end_bairro").val(end["bairro"]);   
                }
                if (!$("#cad_end_rua").val()) {
                    $("#cad_end_rua").val(end["logradouro"]);   
                }
                if (!$("#cad_end_complemento").val()) {
                    $("#cad_end_complemento").val(end["complemento"]);   
                }
                if (!$("#cad_end_uf").val()) {
                    $("#cad_end_uf").val(end["uf"]);   
                }
                console.log(end);
            }
        }


        $("#nav-login-btn").click(() => {
            $("#signup-popup-form").hide();
            $("#login-popup-form").show();
            $("#login-img").height($("#login-popup-box").outerHeight());
            loginPopupShow();
        });

        function loginPopupShow() {
            $("#login-img").show();
            $("#login-img2").hide();
            $("#login-img2").show();
            $("#login-img").hide();
            $("#login-popup").css("visibility","visible");
            $("#login-popup").css("visibility","visible");
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
        }

        function loginPopupClose() {
            $("#login-popup").css("visibility","hidden");
            $('html, body').css({
                overflow: 'auto',
                height: 'auto'
            });

            $(".login-flash-msg").remove();
        }

        $("#close-btn").click(() => {
            loginPopupClose();
        })
        
        $("#login-popup").click(() => {
            if (event.target.id == "login-popup-wrapper") {
                // loginPopupClose();
            }
        });

        function goToSignup() {
            $("#login-popup-form").hide();
            $("#signup-popup-form").show();
            $("#login-img2").height($("#login-popup-box").outerHeight());
            $("#login-img2").show();
            $("#login-img").hide();
            
        }

        $("#signup-btn").click(() => {
            goToSignup();
        })

        $("#signin-btn").click(() => {
            $("#signup-popup-form").hide();
            $("#login-popup-form").show();
            $("#login-img").height($("#login-popup-box").outerHeight());
            $("#login-img").show();
            $("#login-img2").hide();
        })


        $old_email_val = "";
        $old_cpf_val = "";
        $("#cpf_email-btn").click(() => {
            if ($("#cpf_email").attr("name") == "email") {
                $old_email_val = $("#cpf_email").val();
                $("#cpf_email").attr("name", "cpf");
                $("#cpf_email").attr("type", "text");
                $("#cpf_email").inputmask("999.999.999-99");
                $("#cpf_email-lbl").text("CPF:");
                
                if ($(window).width() > 960) {
                    $("#cpf_email-btn-text").text("Logar com E-mail");
                }
                else {
                    $("#cpf_email-btn-text").text("E-mail");
                }

                $("#cpf_email").val($old_cpf_val);

            } else {
                $old_cpf_val = $("#cpf_email").val();
                $("#cpf_email").val($old_email_val);
                $("#cpf_email").attr("name", "email");
                $("#cpf_email").attr("type", "email");
                $("#cpf_email").inputmask("remove");
                $("#cpf_email-lbl").text("E-mail:");

                if ($(window).width() > 960) {
                    $("#cpf_email-btn-text").text("Logar com CPF");
                }
                else {
                    $("#cpf_email-btn-text").text("CPF");
                }

                $("#cpf_email").val($old_email_val);
            }

        });
</script>

@endpush
