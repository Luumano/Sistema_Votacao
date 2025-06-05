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
      - $mail->Username = 'seuemail@gmail.com'; // seu Gmail
      - $mail->Password = 'abcdefghijklmnop'; // senha de app gerada
      - $mail->setFrom('seuemail@gmail.com', 'Sistema de Votação');

