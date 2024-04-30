<head>
    <style>
        /* Estilo para a barra de navegação */

        /* Estilo para os itens da páginação */
        ul.pagination li {
            display: inline;
            /* Exibe os itens em linha */
            margin: 15 3px;
            /* Margem entre os itens */
        }

        /* Estilo para os links dos itens da páginação */
        ul.pagination li a {
            padding: 5px 10px;
            /* Espaçamento interno */
            text-decoration: none;
            color: #ffffff;
            /* Cor do texto */
            background-color: #ffcc00eb;
            /* Cor de fundo */
            border: 1px solid #000000;
            /* Borda */
            border-radius: 3px;
            /* Borda arredondada */
            transition: background-color 0.3s ease;
            /* Transição suave da cor de fundo */
        }

        /* Estilo para o link ativo */
        ul.pagination li.active a {
            background-color: #000000;
            /* Cor de fundo para o link ativo */
            color: #ffffff;
            /* Cor do texto para o link ativo */
            border-color: #000000;
            /* Cor da borda para o link ativo */
        }

        /* Estilo para a lista de paginação */
        ul.pagination {
            display: flex;
            justify-content: center;
            /* Centraliza os itens */
            list-style-type: none;
            /* Remove os marcadores de lista */
            padding: 0;
            /* Remove o preenchimento padrão */
        }



        .page-item.active .page-link {
            color: #fff !important;
            background: rgb(0, 0, 0) !important;
        }

        /*pagina selecionada*/
        .active>.page-link,
        .page-link.active {
            border-color: rgb(0, 0, 0) !important;
        }

        /* Media query para telas menores que 768px */
        @media screen and (max-width: 768px) {

            /* Estilo para os itens da páginação */
            ul.pagination li {
                margin: 0px;
                /* Ajuste a margem entre os itens conforme necessário */
            }
        }
    </style>
</head>
