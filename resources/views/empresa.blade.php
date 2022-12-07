@extends('layouts.main')

@section('title', 'Empresa')

@section('content')

    <div class="modal fade" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">    
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Cadastrar Empresa</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="POST" name="formEmpresa" id="formEmpresa" action="#" class="row g-3">
                    <input type="hidden" name="_method" id="formEmpresaMethod" value="">
                    @csrf
                        <input type="hidden" name="id_empresa" id="id_empresa">
                        <div class="col-lg-8">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="empresa"  name="empresa" placeholder="Nome da empresa">
                        </div>
                        <div class="col-lg-4">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="xx.xxx.xxx/xxxx-xx">
                        </div>
                        <div class="col-md-2">
                            <label for="ddd" class="form-label">DDD</label>
                            <input type="text" class="form-control" id="ddd" name="ddd" maxlength="2" minlength="2" placeholder="xx">
                        </div>
                        <div class="col-md-6">
                            <label for="num_municipal" class="form-label">Número Municipal</label>
                            <input type="text" class="form-control" id="num_municipal" name="num_municipal" maxlength="4" placeholder="xxxx">
                        </div>
                        <div class="col-md-4">
                            <label for="num_externo" class="form-label">Número Externo</label>
                            <input type="text" class="form-control" id="num_externo" name="num_externo" maxlength="1" placeholder="x">
                        </div>
                        <div class="col-sm-6">
                            <label for="ramal_inicial" class="form-label">Ramal Inicial</label>
                            <input type="text" class="form-control" id="ramal_inicial"  name="ramal_inicial" maxlength="3" placeholder="Informe o ramal inicial (Ex: 200)">
                        </div>
                        <div class="col-sm-6">
                            <label for="ramal_final" class="form-label">Ramal Final</label>
                            <input type="text" class="form-control" id="ramal_final" name="ramal_final" maxlength="3" placeholder="Informe o ramal final (Ex: 299)">
                        </div>
                        <div class="col-sm-12">
                            <span id="obs_ramal" class="obs_ramal"><b>Obs:</b> Os ramais serão gerados automaticamente após o cadastro da empresa.</span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="submit" class="btn btn-outline-success"><i class="fa-solid fa-check"></i> Salvar</button>
                </div>
                </form>
            </div>
        </div>  
    </div> 

    <h4>Empresas</h4>
    <div class="card card-body col-12"> 
        <div class="row d-flex justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center">
            <button type="button" class="btn btn-outline-primary col-lg-4 col-md-6 col-sm-12 col-12" data-bs-toggle="modal" data-bs-target="#modalEmpresa" data-whateverid="0">
                <i class="fas fa-plus"></i><b>  Cadastrar Empresa</b>
            </button>
        </div>
    </div>

    <div class="table-responsive pt-5 pb-5">
        <table id="tabelaEmpresas" class="table table-hover .col-12.col-sm-12 .col-md-12 .col-lg-10 .col-xl-11" style="width:100%">
            <thead>
                <tr class="align-middle">
                    <th>#</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
            </thead>
        </table>   
    </div>

    <script type="text/javascript">

        $(document).ready(function(){

            $("#cnpj").mask("99.999.999/9999-99");

            $('#tabelaEmpresas').DataTable({
                language: { 
                    url : "/assets/js/language.json",
                },
                processing: true,  
                ajax: {
                    url: "{{route('empresas.ajaxEmpresas')}}",
                    type: "GET",
                    dataSrc: ""
                },
                columns: [
                    {data: 'id_empresa'},
                    {data: 'nome'},
                    {data: 'CNPJ'},
                    {data: 'id_empresa',
                        render : function(data) {

                            <?php
                                $rota = route('ramal.index', '#id#');
                                
                                print "var rota = \"{$rota}\";";
                            ?> 

                            rota = rota.replace("#id#", data);

                            return '<div class="btn-toolbar" role="toolbar">'+
                                    '<div class="btn-group mr-2" role="group"">'+
                                        '<button type="submit" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalEmpresa"'+
                                        'data-whateverid="'+data+'"><i class="fas fa-edit"></i></button>'+
                                        '<a href="'+rota+'" class="btn btn-outline-dark"><i class="fa-solid fa-phone"></i></a>'+
                                        '<button type="button" class="btn btn-outline-dark btn-excluir" title="Excluir empresa"'+
                                        'style="border-top-right-radius: 0;border-bottom-right-radius: 0;" data-id="'+data+'">'+
                                            '<i class="fa-solid fa-trash"></i>'+
                                        '</button>'+
                                    '</div></div>';
                        },
                    }
                ]
            });

            $(document).on("click", ".btn-excluir", function () {
                var id = $(this).attr("data-id");

                var rota = "{{ route('empresas.delete', ':id') }}";
                rota = rota.replace(':id', id);    

                Swal.fire({
                    position: 'center',
                    title: 'Deseja realmente excluir essa empresa e todos os seus ramais?',
                    icon: 'warning', 
                    showCancelButton: true,
                    confirmButtonText: 'Sim!',
                    cancelButtonText: 'Não!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: rota,
                            dataType: "json",
                            data:{
                                'id': id,
                                '_token': '{{ csrf_token() }}',
                            },
                            encode: true,
                            success: function(data){
                                if(data.status == true){
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: data.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((result) => {
                                        window.location.replace(data.url);
                                        // tableServer.ajax.reload();
                                    });   
                                } else if(data.status == false){
                                    Swal.fire({
                                        title: 'Atenção',
                                        text: data.msg,
                                        icon: 'warning',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    })
                                }
                            },  error: function (request, status, error) {
                                alert(request.responseText);
                            }
                        });
                    } 
                }); // end then result
            });

            $('#modalEmpresa').on('show.bs.modal', function (event) {
                var modal = this;
                var button = $(event.relatedTarget)
                var id = button.data('whateverid')
    
                $(this).find('#ramal_inicial').attr('disabled', false);
                $(this).find('#ramal_final').attr('disabled', false);
                $(this).find('#obs_ramal').show();

                if (parseInt(id) > 0) {
                    $(this).find('#ramal_inicial').attr('disabled', true);
                    $(this).find('#ramal_final').attr('disabled', true);
                    $(this).find('#obs_ramal').hide();
                    $(this).find('h5#myModalLabel').text("Atualizar empresa");            
                } else {
                    $(this).find('h5#myModalLabel').text("Cadastrar empresa");  
                }

                var rota = "{{ route('empresas.show', ':id') }}";
                rota = rota.replace(':id', id);
 
                $.ajax( 
                    {
                        url: rota , 
                        method : "GET",
                        dataType: "json",
                        data : null,
                        success : function (data) {                        
                            modal = $(modal);
                            modal.find('#id_empresa').val(data.id_empresa);
                            modal.find('#empresa').val(data.nome);
                            modal.find('#cnpj').val(data.cnpj);
                            modal.find('#ddd').val(data.ddd);
                            modal.find('#num_municipal').val(data.num_municipal);
                            modal.find('#num_externo').val(data.num_externo);
                            modal.find('#ramal_inicial').val(data.ramal_inicial);       
                            modal.find('#ramal_final').val(data.ramal_final);  
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert("Ocorreu um erro ao carregar as informações!");
                        }
                    }
                );
            });

            $('#formEmpresa').validate({
                rules: {
                    empresa: {
                        required: true
                    },
                    cnpj: {
                        required: true,
                        minlength: 18,
                        maxlength: 18
                    },
                    ddd: {
                        required: true,
                        minlength: 2,
                        maxlength: 2
                    },
                    num_municipal: {
                        required: true,
                        minlength: 4,
                        maxlength: 4
                    },
                    num_externo: {
                        required: true,
                        minlength: 1,
                        maxlength: 1
                    },
                    ramal_inicial: {
                        required: true,
                        minlength: 3,
                        maxlength: 3
                    },
                    ramal_final: {
                        required: true,
                        minlength: 3,
                        maxlength: 3
                    },
                },
                messages:{                
                    empresa: {
                        required: "Esse campo é obrigatório."
                    },
                    cnpj: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira o CNPJ corretamente.",
                        maxlength: "Insira o CNPJ corretamente."
                    },
                    ddd: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira 2 números.",
                        maxlength: "Insira somente 2 números."
                    },
                    num_municipal: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira 4 números.",
                        maxlength: "Insira somente 4 números."
                    },
                    num_externo: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira 1 número.",
                        maxlength: "Insira somente 1 número."
                    },
                    ramal_inicial: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira 3 números.",
                        maxlength: "Insira somente 3 números."
                    },
                    ramal_final: {
                        required: "Esse campo é obrigatório.",
                        minlength: "Insira 3 números.",
                        maxlength: "Insira somente 3 números."
                    },
                }
            });

            $("#formEmpresa").submit(function (event) {
                event.preventDefault();
                
                var formData = $("#formEmpresa").serialize();

                var rota = "{{ route('empresas.store') }}";
                var id = $("#id_empresa").val();

                var titulo1 = "Deseja confirmar o cadastro dessa empresa?";

                if (parseInt(id) > 0) {
                    rota = "{{ route('empresas.update', ':id') }}";
                    rota = rota.replace(':id', id);
                    titulo1 = "Deseja confirmar a edição dessa empresa?";
                }

                if($("#formEmpresa").valid() == true ){
                    Swal.fire({
                        position: 'center',
                        title: titulo1,
                        icon: 'warning', 
                        showCancelButton: true,
                        confirmButtonText: 'Sim!',
                        cancelButtonText: 'Não!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: rota,
                                data: formData,
                                dataType: "json",
                                encode: true,
                                beforeSend: function () {
                                    Swal.fire({
                                        position: 'center',
                                        title: 'Aguarde',
                                        text: 'Processando informações...',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        showCloseButton: false,
                                        allowEnterKey: false,
                                        allowEscapeKey: false,
                                        allowOutsideClick: false
                                    });
                                },
                                success: function(data){
                                    if(data.status == true){
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: data.msg,
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then((result) => {
                                            window.location.replace(data.url);
                                        });   
                                    } else if(data.status == false){
                                        Swal.fire({
                                            title: 'Atenção',
                                            text: data.msg,
                                            icon: 'warning',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        })
                                    }
                                },  error: function (request, status, error) {
                                    alert(request.responseText);
                                }
                            });
                        }
                    }); 
                }
            });

        });

    </script>

@endsection