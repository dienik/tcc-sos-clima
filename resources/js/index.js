document.addEventListener('DOMContentLoaded', function () {
     const registerButton = document.getElementById('registerButton');
     const containerIndex = document.querySelector('.container-index');
     const dynamicContent = document.getElementById('dynamicContent');

     registerButton.addEventListener('click', function () {
          containerIndex.style.display = 'none'; // Esconde o conteúdo inicial

          fetch('/register') // Se estiver usando Laravel, use a rota correta
               .then(response => response.text())
               .then(html => {
                    dynamicContent.innerHTML = html; // Insere o conteúdo carregado
               })
               .catch(error => console.error('Erro ao carregar o formulário:', error));
     });
});
