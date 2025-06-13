  async function buscarDados() {
            try {
                const response = await fetch('./dados_apuracao.php');
                const data = await response.json();

                const container = document.getElementById('apuracaoContainer');
                container.innerHTML = ''; // Limpa antes de atualizar

                data.forEach(c => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = `
                        <img src="chapa_img/${c.foto_chapa}" alt="Logo da Chapa">
                        <h3>${c.nome_chapa}</h3>
                        <p><strong>Presidente:</strong> ${c.presidente_nome}</p>
                        <div class="votos">Votos: ${c.votos}</div>
                    `;
                    container.appendChild(card);
                });
            } catch (error) {
                console.error('Erro ao buscar dados:', error);
            }
        }

        // Atualiza a cada 5 segundos
        setInterval(buscarDados, 5000);
        buscarDados();