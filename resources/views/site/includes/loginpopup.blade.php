<link rel="stylesheet" href="{{ asset("css/site/loginpopup.css") }}">

<div id="login-popup">
    <div id="login-popup-wrapper">
        <img id="login-img" src="https://capricho.abril.com.br/wp-content/uploads/2016/07/02210.jpg?quality=70&strip=all">
        <img id="login-img2" src="https://img.elo7.com.br/product/main/3E9AC85/kit-arco-desconstruido-princesinha-roxo-e-rosa-baloes-festa-roxa-15-anos.jpg">
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
                <div>
                    <label id="cpf_email-lbl">E-mail:</label>
                    <div id="cpf_email-input-wrapper">
                        <input id="cpf_email" type="email" name="email" required>
                        <button id="cpf_email-btn"  type="button">
                            <p id="cpf_email-btn-text">Logar com CPF</p>
                        </button>
                    </div>
                </div>
                <div>
                    <label>Senha:</label>
                    <input type="password" name="senha" required>
                </div>

                <div id="login-bottom">
                    <button id="login-btn" type="submit">Entrar</button>
                    <p class="login-bottom-msg">Ainda não é um cliente? <wbr> <a id="signup-btn">Cadastrar-se</a></p>
                </div>
            </form>
            <form id="signup-popup-form" action="{{ route("login.signup") }}" method="POST">
                @csrf
                <h1 id="login-title">Cadastro</h1>
                <div>
                    <label>Nome:</label>
                    <input type="text" name="nome" required>
                </div>

                <div>
                    <label>Sobrenome:</label>
                    <input type="text" name="sobrenome" required>
                </div>

                <div>
                    <label>Data de nascimento:</label>
                    <input type="date" name="datanasc" required>
                </div>
                
                <div>
                    <label>Telefone:</label>
                    <input id="cad_tel" type="text" name="telefone" required>
                </div>

                <div>
                    <label>CPF:</label>
                    <input id="cad_cpf" type="text" name="cpf" required>
                </div>

                <div>
                    <label>E-mail:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div>
                    <label>Senha:</label>
                    <input type="password" name="senha" required>
                </div>

                <p class="login-subtitle">Endereço</p>

                <div>
                    <label>CEP:</label>
                    <input id="cad_end_cep" type="text" name="end_cep" required>
                </div>

                <div class="login-flex-row">
                    <div>
                        <label>Rua:</label>
                        <input id="cad_end_rua" type="text" name="end_rua" maxlength="50" required>
                    </div>
                    <div style="width: 30%;">
                        <label>Número:</label><br>
                        <input id="cad_end_num" type="text" name="end_num" maxlength="5" required>
                    </div>
                </div>

                <div>
                    <label>Bairro:</label>
                    <input id="cad_end_bairro" type="text" name="end_bairro" maxlength="50" required>
                </div>
                <div class="login-flex-row">
                    <div>
                        <label>Cidade:</label>
                        <input id="cad_end_cidade" type="text" name="end_cidade" maxlength="50" required>
                    </div>
                    <div style="width: 30%;">
                        <label>UF:</label><br>
                        <input id="cad_end_uf" list="uf-list" maxlength="2" name="end_uf" required>
                        <datalist id="uf-list">
                            <option value="">Selecione</option>
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
                        </datalist>
                    </div>
                </div>
                <div>
                    <label>Complemento:</label>
                    <input id="cad_end_complemento" type="text" name="end_complemento">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        $(document).ready(function() {
            checkWrapBtnText();

            $("#login-img").height($("#login-popup-box").outerHeight());
            $("#login-img2").height($("#login-popup-box").outerHeight());

            $("#cad_cpf").inputmask("999.999.999-99");
            $("#cad_tel").inputmask("(99) 99999-9999");

            $("#cad_end_cep").inputmask("99999-999");

            @if (Session::get("login_needed"))
                loginPopupShow();
            @endif
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

        $("#signup-btn").click(() => {
            $("#login-popup-form").hide();
            $("#signup-popup-form").show();
            $("#login-img2").height($("#login-popup-box").outerHeight());
            $("#login-img2").show();
            $("#login-img").hide();
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
