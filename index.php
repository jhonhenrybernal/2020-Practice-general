<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog/Noticiero</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h1 class="my-4">Blog/Noticiero</h1>
  <div id="noticiasContainer"></div>
  <nav aria-label="Page navigation" id="paginationContainer">
    <ul class="pagination justify-content-center">
    </ul>
  </nav>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    const apiKey = '5aee7f686b394aafbd12e09db1dadcbd';
    const noticiasPorPagina = 10;
    let paginaActual = 1;

    function cargarNoticias() {
      const newsUrl = `https://newsapi.org/v2/top-headlines?country=us&pageSize=${noticiasPorPagina}&page=${paginaActual}&apiKey=${apiKey}`;
      $.get(newsUrl, function(data) {
        $('#noticiasContainer').empty();
        if (data.status === 'ok') {
          data.articles.forEach(function(article) {
            $.get('https://randomuser.me/api/', function(userData) {
              const author = userData.results[0].name.first + ' ' + userData.results[0].name.last;
              $('#noticiasContainer').append(`
                <div class="card my-3">
                  <div class="card-body">
                    <h5 class="card-title">${article.title}</h5>
                    <p class="card-text">${article.description}</p>
                    <p class="card-text">Autor: ${author}</p>
                    <a href="${article.url}" class="btn btn-primary">Leer Más</a>
                  </div>
                </div>
              `);
            });
          });
          mostrarPaginacion(data.totalResults);
        } else {
          $('#noticiasContainer').html('<p>No se pudieron cargar las noticias.</p>');
        }
      });
    }

    function mostrarPaginacion(totalNoticias) {
      const totalPaginas = Math.ceil(totalNoticias / noticiasPorPagina);
      $('#paginationContainer ul').empty();
      for (let i = 1; i <= totalPaginas; i++) {
        $('#paginationContainer ul').append(`
          <li class="page-item ${paginaActual === i ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
          </li>
        `);
      }
    }

    $('#paginationContainer').on('click', 'a.page-link', function(e) {
      e.preventDefault();
      paginaActual = parseInt($(this).data('page'));
      cargarNoticias();
    });

    cargarNoticias();
  });
</script>

</body>
</html>
