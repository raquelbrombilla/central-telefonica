@extends('layouts.main')

@section('title', 'Ramais')

@section('content')

    <div class="modal fade" id="modalRamal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">    
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Atualizar Ramal</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bi bi-x-lg"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="POST" name="formRamal" id="formRamal" action="#" class="row g-3">
                    <input type="hidden" name="_method" id="formRamalMethod" value="">
                    @csrf
                        <input type="hidden" name="id_ramal" id="id_ramal">
                        <div class="col-lg-12 ">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ativo" name="ativo">
                                <label class="form-check-label" for="ativo">Ativo</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" disabled name="numero">
                        </div>
                        <div class="col-lg-9">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao">
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

    <h4>Ramais <i class="fa-solid fa-arrow-right-long"></i>  {{$empresa->nome}}</h4>
    <div class="card card-body col-12"> 
        <div class="row d-flex justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center">
            <p>
                <b>Padrão do número:</b> ({{$empresa->DDD}}) {{$empresa->num_municipal}}-{{$empresa->num_externo}}xxx
            </p>           
        </div>
    </div>

    <div class="table-responsive pt-5 pb-5">
        <table id="tabelaRamais" class="table table-hover .col-12.col-sm-12 .col-md-12 .col-lg-10 .col-xl-11" style="width:100%">
            <thead>
                <tr class="align-middle">
                    <th>Número</th>
                    <th>Ativo</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
        </table>   
    </div>

    <script type="text/javascript">
        
        $(document).ready(function(){

            id_empresa = "{{$empresa->id_empresa}}";

            var route = "{{ route('ramal.ajaxRamal', ':id') }}";
            route = route.replace(':id', id_empresa);

            $('#tabelaRamais').DataTable({
                language: { 
                    url : "/assets/js/language.json",
                },
                processing: true,  
                ajax: {
                    url: route,
                    type: "GET",
                    dataSrc: ""
                },
                columns: [
                    {data: 'numero'},
                    {data: 'ativo',
                        render : function(data){
                            if(data == 1){
                                return '<span class="badge bg-success">Sim</span>';
                            } else if(data == 0){
                                return '<span class="badge bg-danger">Não</span>';
                            }
                        }
                    },
                    {data: 'descricao'},
                    {data: 'id_ramal',
                        render : function(data) {
                            return '<div class="btn-toolbar" role="toolbar">'+
                                    '<div class="btn-group mr-2" role="group"">'+
                                        '<button type="submit" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalRamal"'+
                                        'data-whateverid="'+data+'"><i class="fas fa-edit"></i></button>'+
                                    '</div></div>';
                        },
                    }
                ]
            });

            $('#modalRamal').on('show.bs.modal', function (event) {
                var modal = this;
                var button = $(event.relatedTarget)
                var id = button.data('whateverid')
    
                var rota = "{{ route('ramal.show', ':id') }}";
                rota = rota.replace(':id', id);
 
                $.ajax( 
                    {
                        url: rota , 
                        method : "GET",
                        dataType: "json",
                        data : null,
                        success : function (data) {                        
                            modal = $(modal);
                            modal.find('#id_ramal').val(data.id_ramal);
                            modal.find('#numero').val(data.numero);
                            modal.find('#descricao').val(data.descricao);

                            if(data.ativo == 1){                        
                                modal.find('#ativo').prop('checked', true);
                            } else {
                                modal.find('#ativo').prop('checked', false);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert("Ocorreu um erro ao carregar as informações!");
                        }
                    }
                );
            });

            $('#formRamal').validate({
                rules: {
                    descricao: {
                        required: true
                    },
                },
                messages:{                
                    descricao: {
                        required: "Esse campo é obrigatório."
                    },
                }
            });

            $('#formRamal').submit(function (event) {
                event.preventDefault();

                var formData = $("#formRamal").serialize();
                var id = $("#id_ramal").val();

                rota = "{{ route('ramal.update', ':id') }}";
                rota = rota.replace(':id', id);
                
                if($("#formRamal").valid() == true ){
                    Swal.fire({
                        position: 'center',
                        title: 'Deseja confirmar a edição dessa empresa?',
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
                                },  
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert("Ocorreu um erro ao carregar as informações!");
                                }
                            });
                        }
                    }); 
                }

            });
            
        });

    </script>

@endsection