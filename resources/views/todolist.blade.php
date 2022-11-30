<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">

    <!--BootStrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!--BootStrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <title>TodoList Estoque</title>
</head>

<body onload="getTasks()">


    <form class="form" onsubmit="adicionar()">
        <label>
            <p>TodoList Estoque</p>
        </label>
        <input type="text" id="novaTarefa" placeholder="Digite aqui">
        <button type="submit" class="btn btn-success">Adicionar</button>
    </form>
    <div class="tarefas">
        <h2>Tarefas</h2>
        <ul id="items">
            <!-- Aqui vão as Tasks -->
        </ul>
    </div>
    <div class="atualizar show">
        <input type="text" id="atualizarTarefa" placeholder="Digite aqui">
        <button class="botaoAtualizar btn btn-success" onclick="atualizar()">Salvar</button>
        <button class="botaoAtualizar btn btn-secondary" onclick="fechar()">Fechar</button>
    </div>
    <script>
        function getTasks() {
            $.ajax({
                type: "GET",
                url: "todolist",
                success: function(data) {
                    if (data.length === 0) {
                        const ul = document.getElementById('items')
                        const li = document.createElement('li')
                        const p = document.createElement('p')
                        p.style.textAlign = 'center'
                        p.innerText = 'Novas Tarefas Aparecerão Aqui'
                        li.appendChild(p)
                        ul.appendChild(li)
                        return;
                    }

                    data.forEach((element, index) => {
                        //console.log(element)
                        createElements(element, index)

                    });

                },
            })
        }

        function createElements(element, index) {
            const ul = document.getElementById('items')
            const li = document.createElement('li')
            const p = document.createElement('p')
            const btnEdit = document.createElement('button')
            const btnDelete = document.createElement('button')

            p.innerText = (index + 1) + 'º  ' + element.name
            btnEdit.innerText = 'Editar'
            btnEdit.classList.add('btn')
            btnEdit.classList.add('btn-primary')
            btnEdit.classList.add('editar')
            btnEdit.setAttribute('onclick', `showModal(${element.id}, ${JSON.stringify(element.name)})`)

            btnDelete.innerText = 'Apagar'
            btnDelete.classList.add('btn')
            btnDelete.classList.add('btn-danger')
            btnDelete.classList.add('excluir')
            btnDelete.setAttribute('onclick', `deletar(${element.id})`)


            li.appendChild(p)
            li.appendChild(btnEdit)
            li.appendChild(btnDelete)
            ul.appendChild(li)

        }


        function adicionar() {
            const todo = document.getElementById('novaTarefa').value
            if (todo.trim().length === 0) {
                return alert('Digite uma Tarefa')
            }
            $.ajax({
                type: "POST",
                url: "todolist/",
                data: {
                    name: todo
                },
                success: function() {
                    getTasks()
                },
                error: function(data) {
                    return alert(`Error ${JSON.stringify(data)}`)
                }
            });


        }

        function deletar(id) {
            window.location.reload()
            $.ajax({
                type: "DELETE",
                url: `/todolist/${id}`,
                success: function() {
                    getTasks()
                },
                error: function(data) {
                    alert(`Error ${JSON.stringify(data)}`)
                }
            })
        }

        function showModal(id, name) {
            let show = document.querySelector('.atualizar')
            show.classList.toggle('show')
            show.setAttribute('id', `${id}`)
            console.log(`NOME: ${name}`);
            let texto = name


            show.querySelector('input').value = texto

        }

        function atualizar(e) {
            const todo = document.getElementById('atualizarTarefa').value
            if (todo.trim().length === 0) {
                return alert('Insira uma atualização!')
            }
            let show = document.querySelector('.atualizar')
            let id = parseInt(show.id)
            let texto = show.querySelector('input').value
            console.log(`TEXTO: ${texto}`);
            console.log('ID ', id);


            $.ajax({
                type: "PUT",
                url: `/todolist/${id}`,
                data: {
                    name: texto
                },
                success: function(data) {
                    getTasks()
                    alert('Tarefa atualizada com sucesso')
                },
                error: function(data) {
                    alert(`Error ${JSON.stringify(data)}`)
                }
            })
            window.location.reload()
        }

        function fechar() {
            let show = document.querySelector('.atualizar')
            show.classList.toggle('show')
        }
    </script>
</body>

</html>