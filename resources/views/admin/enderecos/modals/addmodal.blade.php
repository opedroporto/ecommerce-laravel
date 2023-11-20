<span>

<input type="checkbox" id="addmodal" class="modal-checkbox">
<label for="addmodal" class="btn btn-add"><p><i class="fa-solid fa-plus"></i> <span>Novo endereço</span></p></label>

<label for="addmodal" class="modal-background"></label>

<div id="modal-popup-box" class="modal">
    <div id="top-bar">
        <label for="addmodal"><i id="close-btn" class="fa-solid fa-xmark"></i></label>
    </div>
    <form id="modal-popup-form" action="{{ route("admin.enderecos.add") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 id="modal-title">Novo Endereço</h1>
        {{-- @if ($errors->any())
            <div class="error-msg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div>
            <label>CEP:</label>
            <input class="{{ ($errors->first('cep') ? "input-error" : "") }}" type="text" name="cep" value="{{ format_cep(old("cep")) }}" required>
            <p class="error-msg">{{ $errors->first('cep') ? $errors->first('cep') : "" }}</p>
        </div>

        <div>
            <label>Rua:</label>
            <input class="{{ ($errors->first('rua') ? "input-error" : "") }}" type="text" name="rua" maxlength="50" value="{{ old("rua") }}" required>
            <p class="error-msg">{{ $errors->first('rua') ? $errors->first('rua') : "" }}</p>
        </div>

        <div>
            <label>Número:</label><br>
            <input class="{{ ($errors->first('num') ? "input-error" : "") }}" type="text" name="num" maxlength="5" value="{{ old("num") }}" required>
            <p class="error-msg">{{ $errors->first('num') ? $errors->first('num') : "" }}</p>
        </div>

        <div>
            <label>Bairro:</label>
            <input class="{{ ($errors->first('bairro') ? "input-error" : "") }}" type="text" name="bairro" maxlength="50" value="{{ old("bairro") }}" required>
            <p class="error-msg">{{ $errors->first('bairro') ? $errors->first('bairro') : "" }}</p>
        </div>

        <div>
            <label>Cidade:</label>
            <input class="{{ ($errors->first('cidade') ? "input-error" : "") }}" type="text" name="cidade" maxlength="50" value="{{ old("cidade") }}" required>
            <p class="error-msg">{{ $errors->first('cidade') ? $errors->first('cidade') : "" }}</p>
        </div>

        <div>
            <label>UF:</label><br>
            <select class="{{ ($errors->first('uf') ? "input-error" : "") }}" name="uf" required>
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
            </select>
            <p class="error-msg">{{ $errors->first('uf') ? $errors->first('uf') : "" }}</p>
        </div>

        <div>
            <label>Complemento:</label>
            <input class="{{ ($errors->first('complemento') ? "input-error" : "") }}" type="text" name="complemento" value="{{ old("complemento") }}">
            <p class="error-msg">{{ $errors->first('complemento') ? $errors->first('complemento') : "" }}</p>
        </div>

        <div>
            <label>Usuário:</label><br>
            <select class="{{ ($errors->first('id_usuario') ? "input-error" : "") }}" name="id_usuario" required>
                <option disabled selected value="">Selecione:</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nome }}</option>
                @endforeach
            </select>
            <p class="error-msg">{{ $errors->first('id_usuario') ? $errors->first('id_usuario') : "" }}</p>
        </div>

        <div id="modal-bottom">
            <button class="modal-btn modal-main-btn" type="submit">Criar novo endereço</button>
        </div>
    </form>
</div>

</span>