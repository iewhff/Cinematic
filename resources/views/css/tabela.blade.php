<head>
    <style>
        /* Estilos para a tabela */
        table {
            margin: 20px auto;
            /* Margem de 20px nas laterais e centraliza horizontalmente */
            border-collapse: collapse;
            /* Mescla as bordas da tabela */
            border-radius: 10px;
            /* Borda arredondada */
            overflow: hidden;
            /* Oculta qualquer conteúdo que ultrapasse os limites da tabela */
        }

        td {
            padding: 10px;
            /* Espaçamento interno */
            border-bottom: 1px solid #ddd;
            /* Borda inferior para as células */
        }

        tr:last-child td {
            border-bottom: none;
            /* Remove a borda inferior da última linha */
        }

        /* Estilos para as células do cabeçalho */
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Estilos para as células dos dados */
        td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }

        /* Estilos para as células dos dados nas linhas ímpares */
        tr:nth-child(odd) td {
            background-color: #f9f9f9;
        }

        /* Estilos para as células dos dados nas linhas pares */
        tr:nth-child(even) td {
            background-color: #fff;
        }

        /* Estilos para a imagem do cartaz */
        td img {
            max-width: 100px;
            height: auto;
        }

        /* Estilos para realçar a linha ao passar o cursor */
        tr:hover {
            background-color: #ffcc00eb !important;
            /* Cor de fundo ao passar o cursor */
        }
    </style>
</head>
