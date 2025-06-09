# 🗳️ Sistema de Votação Online - UFC

## 📌 Visão Geral

O Sistema de Votação Online tem como objetivo permitir que estudantes da UFC votem em chapas candidatas de forma segura, transparente e simples.

---

## ✅ Funcionalidades

- Autenticação de eleitores com e-mail institucional `@alu.ufc.br`
- Cadastro de chapas com presidente, membros e propostas
- Login das chapas para editar seus dados
- Controle de tempo para inscrição e votação
- Registro e apuração de votos
- Visualização pública das propostas
- Painel administrativo com resultados

---

## 💻 Tecnologias Utilizadas

- **PHP** (Backend)
- **MySQL** (Banco de Dados)
- **HTML/CSS** (Frontend)
- **JavaScript** (Interações)
- **Font Awesome** (Ícones)
- **Google Fonts** (Tipografia)

---

## 🧩 Modelagem do Banco de Dados

### 📁 `eleitores`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Identificador |
| matricula | VARCHAR | Matrícula do aluno |
| nome | VARCHAR | Nome do eleitor |
| email | VARCHAR | E-mail institucional |
| votou | BOOLEAN | Se já votou |

### 📁 `chapas`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Identificador |
| nome_chapa | VARCHAR | Nome da chapa |
| presidente_nome | VARCHAR | Nome do presidente |
| presidente_foto | VARCHAR | Imagem |
| proposta | TEXT | Proposta da chapa |
| foto_chapa | VARCHAR | Imagem da chapa |
| senha | VARCHAR | Senha criptografada |

### 📁 `membros`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Identificador |
| chapa_id | INT | Referência à chapa |
| nome | VARCHAR | Nome do membro |
| foto | VARCHAR | Imagem |
| diretoria | VARCHAR | Cargo na chapa |

### 📁 `votos`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Identificador |
| eleitor_id | INT | Referência ao eleitor |
| chapa_id | INT | Chapa votada |

### 📁 `configuracoes`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | Identificador |
| inicio_inscricao | DATETIME | Período inicial para inscrição |
| fim_inscricao | DATETIME | Período final para inscrição |
| inicio_votacao | DATETIME | Início da votação |
| fim_votacao | DATETIME | Fim da votação |

---

## ⚖️ Regras de Negócio

- Cada eleitor pode votar apenas uma vez
- Votação só é permitida dentro do período configurado
- Apenas e-mails `@alu.ufc.br` podem votar
- Chapa só pode ser editada com senha correta
- Propostas ficam disponíveis publicamente

---

## 🔒 Segurança

- Hash de senha com `password_hash()`
- Sessões PHP para autenticação
- Proteção contra SQL Injection com `prepare()` e `bind_param()`
- Uploads de imagem restritos a tipos válidos

---

## 🛠️ Futuras Implementações

- Recuperação de senha por e-mail
- Integração com sistema acadêmico da UFC
- Responsividade aprimorada
- Exportação de resultados em PDF
- Dashboard com gráficos em tempo real

---

> Desenvolvido para fins acadêmicos e institucionais.

# Sistema de Votação do Centro Acadêmico Instalando Composer e Configurando o GMAIL
## Verifique se tem o composer instalado
No PowerShell ou Prompt de Comando:
  - composer --version
  - Se disser que não é reconhecido, baixe e instale o Composer:
  - https://getcomposer.org/Composer-Setup.exe
### Dentro da pasta do seu projeto
  - c:/wamp64/www/sistema_votacao
  - (Para rodar o sistema localmente coloque ele dentro da pasta do wamp ou do xampp).
### Dentro Visual studio Code na pasta do seu projeto abra o terminal e rode:
  - composer require phpmailer/phpmailer
  - Isso criará a pasta vendor e o autoload.php, necessários para o seu require 'vendor/autoload.php'; funcionar.

# COMO GERAR UMA SENHA DE APLICATIVO NO GMAIL (Google)
## Pré-requisito:
  - Você precisa ativar a verificação em duas etapas na sua conta do Gmail.

### 1. Acesse sua conta Google:
👉 Vá para: https://myaccount.google.com
### 2. No menu à esquerda, clique em Segurança.
### 3. Role até encontrar "Verificação em duas etapas"
  - Se ainda não estiver ativado:

## Clique e siga o processo para ativar.
  - Você precisará confirmar com seu telefone ou aplicativo autenticador.

### 4. Após ativar a verificação em duas etapas, volte para o menu "Segurança".
### 5. Role até "Senhas de app"
🔗 Ou acesse diretamente: https://myaccount.google.com/apppasswords

### 6. Faça login novamente se for solicitado.
### 7. Na página “Senhas de app”:
  - Selecione o app: escolha Email.
  - Selecione o dispositivo: escolha Outro (nome personalizado) e digite por exemplo: Sistema de Votação PHP.
  - Clique em Gerar.
### Será exibida uma senha de 16 caracteres, como
  - abcd efgh ijkl mnop
## Usando essa senha no seu código
  - No seu enviar_email.php (ou similar), configure assim:
      - $mail->Username = 'seuemail@gmail.com';  `seu Gmail`
      - $mail->Password = 'abcdefghijklmnop';  `senha de app gerada`
      - $mail->setFrom('seuemail@gmail.com', 'Sistema de Votação');

