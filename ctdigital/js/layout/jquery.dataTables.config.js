$(function () {
    $('.tabela_com_busca').DataTable({
        "language": {
            "decimal": "",
            "emptyTable": "Sem itens na tabela",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ itens",
            "infoEmpty": "Mostrando 0 a 0 de 0 itens",
            "infoFiltered": "(Filtro de _MAX_ itens no total)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ itens",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Buscar:",
            "zeroRecords": "Nenhum item encontrado",
            "paginate": {
                "first": "Primeiro",
                "last": "Ultimo",
                "next": "Proximo",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Ordenação de colunas crescente ",
                "sortDescending": ": Ordenação de colunas decrescente "
            }
        }

    })
})