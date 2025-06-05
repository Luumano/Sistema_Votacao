
function confirmarVoto() {
  const radios = document.querySelectorAll('input[name="candidato_id"]');
  let candidatoId = null;

  for (const radio of radios) {
    if (radio.checked) {
      candidatoId = radio.value;
      break;
    }
  }

  if (!candidatoId) {
    alert("Por favor, selecione um candidato.");
    return false;
  }

  // Busca os dados do candidato selecionado
  const card = document.querySelector(`input[value="${candidatoId}"]`).closest('.card');
  const presidente = card.querySelector('p:nth-of-type(1)').textContent.replace('Presidente: ', '');
  const chapa = card.querySelector('p:nth-of-type(2)').textContent.replace('chapa: ', '');

  return confirm(`Você tem certeza que deseja votar em:\n\nPresidente: ${presidente}\nChapa: ${chapa}`);
}
