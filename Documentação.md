# Documentação do Sistema de Votação Online

## 📌 Índice
1. Visão Geral
2. Funcionalidades
3. Tecnologia Utilizada
4. Modelagem do Banco de Dados
5. Fluxo do Sistema
6. Telas do Sistema
7. Regras de Négocio
8. Segurança
9. To-Do/Futuras Implementações

## 📌 Visão Geral
O sistena de votação online tem como objetivo permitir que estudantes da UFC votem em
chapas candidatas de forma segura, transparente e simples. Ele permite:
  * Registro de chapas com presidente, membros e proposta
  * Autenticação de eleitores via e-mail institucional
  * Controle de tempo da votação
  * Área de administração

## ✅ Funcionalidades
### 🔐 Acesso e Autenticação
  * Login de eleitor com e-mail institucional @alu.ufc.br
  * Login de administradores
  * Login da chapa para edição com senha criptografada

### 📥 Cadastro
  * Cadastro de chapas (feito pelo presidente)
  * Inclusão de presidente e membros com fotos e cargos
  * Registro da proposta

### 📊 Votação
  * Liberação do período de votação
  * Um voto por eleitor
  * Registro do voto no banco de dados

### 📈 Apuração
  * Contagem em tempo real dos votos por chapa
  * Exibição dos resultados em gráficos

### 📄 Visualização
  * Tela pública para ver as propostas das chapas
  * Exibição dos membros da chapa com cargos e imagens

### 💻 Tecnologias Utilizadas
  * Tecnologia	    |Função
  * PHP	            |Backend
  * MySQL	          |Banco de Dados
  * HTML/CSS	      |Frontend
  * JavaScript	    |Interações
  * Font Awesome	  |Ícones
  * Google Fonts	  |Tipografia

## 🧩 Modelagem do Banco de Dados
### 📁 Tabela eleitores
Campo      |	  Tipo	  |  Descrição
id	       |    INT	    | Identificador
matricula	 |  VARCHAR	  | Matrícula do aluno
nome	     |  VARCHAR  	| Nome do eleitor
email	     |  VARCHAR	  | E-mail institucional
votou	     |  BOOLEAN	  | Se já votou

### 📁 Tabela chapas
Campo	          |    Tipo    |	Descrição
id	            |    INT	   |  Identificador
nome_chapa	    |  VARCHAR	 |  Nome da chapa
presidente_nome	|  VARCHAR	 |  Nome do presidente
presidente_foto	|  VARCHAR	 |  Imagem
proposta	      |    TEXT	   |  Proposta da chapa
foto_chapa	    |   VARCHAR	 |  Imagem da chapa
senha	          |   VARCHAR	 |  Senha criptografada para login/edição

### 📁 Tabela membros
Campo      |  	Tipo	    |  Descrição
id	       |    INT	      |  Identificador
chapa_id   |  	INT	      |  Referência à chapa
nome	     |  VARCHAR	    |  Nome do membro
foto	     |  VARCHAR	    |  Imagem
diretoria	 |  VARCHAR	    |  Cargo na chapa

### 📁 Tabela votos
Campo	      |    Tipo      |	Descrição
id	        |    INT	     |  Identificador
eleitor_id	|    INT	     |  Referência ao eleitor
chapa_id	  |    INT	     |  Chapa votada

### 📁 Tabela configuracoes
Campo	            |  Tipo	     |  Descrição
id	              |  INT	     |  Identificador
inicio_inscricao	|  DATETIME  |	Período inicial para inscrição
fim_inscricao	    |  DATETIME	 |  Período final para inscrição
inicio_votacao	  |  DATETIME	 |  Início da votação
fim_votacao	      |  DATETIME	 |  Fim da votação

### 🔄 Fluxo do Sistema
graph LR
A[Eleitor acessa login] --> B{E-mail institucional válido?}
B -- Sim --> C[Verifica se já votou]
C -- Não --> D[Exibe chapas e vota]
D --> E[Registra voto]
E --> F[Fim]
B -- Não --> G[Mensagem de erro]
C -- Já votou --> H[Mensagem de já votou]

## 🖥️ Telas do Sistema
  * Login do Eleitor
  * Login da Chapa para Edição
  * Cadastro de Nova Chapa
  * Visualização das Propostas
  * Votação
  * Administração (resultado, tempo, chapas)

## ⚖️ Regras de Negócio
  * Cada eleitor só pode votar uma vez
  * Votação e inscrição ocorrem apenas dentro dos períodos definidos
  *  Apenas e-mails que terminam em @alu.ufc.br podem votar
  * Uma chapa pode ser editada apenas com senha correta e dentro do período
  * Propostas são públicas e acessíveis a todos
  * Votos não podem ser alterados após submissão

## 🔒 Segurança
  * Hash de senhas com password_hash() e password_verify()
  * Verificação de domínio de e-mail institucional
  * Sessões PHP para proteger páginas sensíveis
  * Proteção contra SQL Injection com prepare() e bind_param()
  * Uploads de imagens restritos a image/* e armazenados em pastas separadas

## 🛠️ To-Do / Futuras Implementações
  * Recuperação de senha da chapa via e-mail
  * Validação de imagens (tamanho e extensão)
  * Integração com API da UFC para validação de matrícula
  * Exportação de resultados em PDF
  * Responsividade aprimorada para celulares
  * Tela para apuração com gráficos em tempo real
  * Auditoria de votos para segurança adicional

