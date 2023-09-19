{{-- This file is used for menu items by any Backpack v6 theme --}}

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<x-backpack::menu-item title="Usuarios" icon="la la-users" :link="backpack_url('usuario')" />
<x-backpack::menu-item title="Produtos" icon="la la-box" :link="backpack_url('produto')" />
<x-backpack::menu-item title="Colecaos" icon="la la-boxes" :link="backpack_url('colecao')" />
<x-backpack::menu-item title="Enderecos" icon="la la-map-marker" :link="backpack_url('endereco')" />