function adicionarMembro() {
    const div = document.createElement('div');
    div.className = 'membro';
    div.innerHTML = `
        <label>Nome do Membro:</label>
        <input type="text" name="membro_nome[]" placeholder="Nome do Membro" required>
        <label for="foto">Foto do membro da equipe</label>
        <input type="file" name="membro_foto[]" accept="image/*" required>
        <select name="membro_diretoria[]" required>
          <option value="">Selecione a Diretoria</option>
          <option value="Vice-Presidente">Vice-Presidente</option>
          <option value="Secretário">Secretário</option>
          <option value="Diretor Financeiro">Diretor Financeiro</option>
          <option value="Diretor de Comunicação">Diretor de Comunicação</option>
          <option value="Diretor de Eventos">Diretor de Eventos</option>
          <option value="Diretor Acadêmico">Diretor Acadêmico</option>
        </select>
    `;
    document.getElementById('membros').appendChild(div);
    alert('Membro adicionado!');
}