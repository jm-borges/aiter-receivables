# 💳 Altri Receivables – Recebíveis como Garantia

**IMPORTANTE: ANTES DE SEGUIR DESENVOLVENDO, CONFIRA OS CONCEITOS ABAIXO:**

## Conceitos

* Estabelecimento Comercial (EC)

Qualquer varejo que venda produtos ou serviços usando máquinas de cartão

* Arranjo de pagamento

Bandeira/forma de pagamento usado por um comprador no EC (Ex: Mastercard crédito, Visa débito)

* Credenciadora/Subcredenciadora (Adquirente)

São as empresas que fornecem a máquina de cartão para os ECs, e enviam as informações sobre recebíveis para o sistema de pagamentos.

* Recebível ou Unidade Recebível (UR)

Um recebível ou unidade recebível é basicamente a soma de dinheiro a ser recebido por um EC em uma determinada data, relativo a um determinado arranjo de pagamento e um determinado adquirente (Ex: Mercado do João tem um recebível com previsão para 12/12/2026, da Cielo com Mastercard crédito). Pode aumentar ou diminuir de valor ao longo do tempo. 

* UR constituida x UR a constituir

Um recebível constituido é um valor que de fato existe (ocorreu uma transação), enquanto um recebível a constituir é uma "expectativa" de que aquele valor venha a existir no futuro.

* Agenda de recebíveis

É a lista de quais recebíveis existem em quais datas e os seus valores.

* Registradora

Entidade que possui e gerencia um ecossistema de negociação de recebíveis. Nesse caso, a NUCLEA.

* Instituição financeira/não-financeira

No contexto da registradora Núclea, a instituição financeira/não-financeira nada mais é que a empresa que vai participar das negociações de recebíveis.

* Opt-in/Opt-out (anuência)

Opt-in: Quando uma instituição solicita para a registradora o recebimento diário dos recebíveis de um determinado EC. Opt-out: Quando é cancelado esse recebimento.

* Titular

Detentor de uma unidade recebível ou parte dela.

* Recebedor final

Empresa que de fato iria receber o valor da unidade recebível no momento da liquidação (pagamento).

* Arquivos e mensagens

Dentro do ecossistema da registradora Núclea, a comunicação pode ser realizada entre os participantes na forma de arquivos (XML) e mensagens (JSON), cada uma com seu layout especifico (Ex: RRC0019 é uma mensagem para registro de operações, ARRC018 é um arquivo contendo as informações da agenda de recebíveis)

## Quem é quem

### ALTRI

Empresa dona do sistema, que realiza as operações e participa do ecossistema da Nuclea (Instituição Financeira/Não Financeira)

### NUCLEA

Empresa que gerencia o ecossistema de negociação de recebíveis (Registradora)

### RTM

Empresa que fornece o serviço de intermediário de comunicação entre a Altri e a Nuclea para comunicações específicas (Envios de arquivos e retornos assíncronos da Núclea)

## Exemplo de fluxo básico do ecossistema

1. Um comprador (pessoa física ou jurídica) vai até um estabelecimento ou compra pela internet algum produto ou serviço de uma loja (o "Estabelecimento Comercial - EC")

2. O comprador pagou com um cartão de crédito Visa.

3. A loja usou a máquina de cartão da Cielo.

4. A loja vai ter disponivel esse dinheiro na conta apenas daqui 30 dias.

5. A Cielo envia as informações dessa transação (junto com as demais que foram feitas com Visa crédito nesse dia) para a Registradora Núclea

6. A Núclea envia no dia seguinte a lista de valores a receber e quando dessa loja, para todas as empresas que solicitaram receber essas informações diárias.

7. Com base nessas informações, a Altri pode solicitar que um determinado valor em recebíveis fique como garantia para ela, enviando as informações sobre essa operação para a Núclea.

## Fluxo básico do modelo de negócios Altri

1. **Compra pelo EC**

   * EC compra produtos de fornecedor com prazo (ex.: 30 dias).

2. **Contrato com Altri**

   * Altri paga a dívida do EC, que passa a dever **X** para Altri com prazo maior (ex.: 60 dias).
   * Pagamento via:

     * Recebíveis de cartão de crédito como garantia
     * Ou liquidação até a data limite

3. **Opt-in e marcação de recebíveis**

   * Altri solicita opt-in para todos os adquirentes.
   * Sistema marca diariamente os recebíveis da agenda do EC.

4. **Execução de garantias**

   * Recebíveis marcados são usados como garantia para Altri.

5. **Liquidação**

   * Processo até atingir o valor **X**.

---

## Sistema de Recebíveis – Visão Geral e Modelo de Negócio

### 📝 Pendências

* Atualizar o tratamento do webhook dos retornos da RRC0019 com base no layout da RTM
* Fazer testes do recebimento de informações da ARRC018
* Fazer testes da operação RRC0019

### 📝 Dúvidas

* Onde no retorno da ARC0018 da RTM é encontrado o CNPJ da credenciadora?
* Imaginando que a operação seja registrada com sucesso, com valor por exemplo de 20.000, e no dia seguinte, uma ou mais URs reduzem o valor disponivel, o que acontece com a operação? é cancelada, fica em um estado diferente, etc?

### 🔄 Fluxos Principais do Sistema

#### 🔹 Fluxo 1 – **Agenda de Recebíveis** 📅

**Objetivo:** Capturar, autorizar e disponibilizar as agendas de recebíveis de ECs (Estabelecimentos Comerciais).

1. **Credenciadora → Nuclea**

   * Envia **ARRC001** (agenda constituída) 📝
   * Caso haja baixa, envia **ARRC002** ⬇️

2. **Nuclea → IF/NIF**

   * Disponibiliza **ARRC018** (agenda consolidada) 📊
   * Se participante tiver opt-in, envia **CRRC039** ✅

3. **IF/NIF ou Credenciadora → Nuclea** (sob demanda)

   * Consulta agenda: **RRC0010** 🔍
   * Autoriza envio: **RRC0011** ou cancela autorização: **RRC0013** ❌

4. **Nuclea confirma**

   * Autorização: **RRC0028** ✔️
   * Cancelamento: **RRC0029** ❌

**Arquivos/Mensagens envolvidas:**

* ARRC001 – Credenciador informa a agenda de recebíveis com as unidades de recebíveis constituídas, os valores pré-contratados e as informações sobre a liquidação dos recebíveis.
* ARRC002 – Credenciador informa a baixa de unidades de recebíveis.
* ARRC018 – Registradora NÚCLEA informa a agenda de recebíveis.
* CRRC039 – Registadora NÚCLEA informa opt-in para conciliação
* RRC0010 – Credenciadora / Instituição Financeira / Não Financeira realiza a consulta de recebíveis.
* RRC0011 – Credenciadora / Instituição Financeira / Não Financeira realiza a inclusão da autorização de envio de agenda.
* RRC0013 – Credenciadora / Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da autorização de envio de agenda.
* RRC0028 – Registradora NÚCLEA informa a inclusão da autorização de envio de agenda.
* RRC0029 – Registradora NÚCLEA informa a inclusão do cancelamento da autorização de envio de agenda.

---

#### 🔹 Fluxo 2 – **Troca de Titularidade / Negociação** 🔄💰

**Objetivo:** Registrar negociações, alterações e conciliações de recebíveis.

1. **IF/NIF → Nuclea**

   * Inclusão ou alteração: **ARRC022** / **RRC0019** ✏️
   * Alteração de domicílio bancário: **ARRC036** / **RRC0035** 🏦
   * Cadastro de identificador IPOC: **ARRC033** 🆔

2. **Nuclea → IF/NIF**

   * Confirma negociações a constituir: **ARRC031** 📑
   * Conciliação e inconsistências: **CRRC034**, **CRRC037** ⚠️
   * Baixa automatizada: **CRRC043** 🔄

3. **IF/NIF → Nuclea**

   * Cancelamento de negociação: **ARRC023** / **RRC0020** ❌

4. **Nuclea → IF/NIF**

   * Posição atualizada da negociação: **RRC0009**, **RRC0021** 🔄

**Arquivos/Mensagens envolvidas:**
* ARRC022 – Instituição Financeira / Não Financeira realiza a inclusão e alteração da negociação de recebíveis em lote.
* ARRC023 – Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da negociação de recebíveis em lote.
* ARRC031 – Registradora NÚCLEA informa negociação de recebíveis a constituir.
* ARRC033 – Instituição Financeira / Não Financeira realiza a inclusão e alteração do identificador IPOC
* ARRC036 – Instituição Financeira / Não Financeira realiza a alteração do domicílio bancário da negociação de recebíveis em lote.
* CRRC034 – Registradora NÚCLEA informa negociações para conciliação
* CRRC037 – Registradora NÚCLEA informa negociações inconsistentes para conciliação do credenciador
* CRRC043 – Registradora Núclea informa processo de baixa de contratos automatizada para IF/NIF
* RRC0009 – Registradora NÚCLEA informa a alteração da negociação de recebíveis às Instituição Financeira / Não Financeira.
* RRC0019 – Instituição Financeira / Não Financeira realiza a inclusão ou alteração da negociação de recebíveis. 
* RRC0020 – Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da negociação de recebíveis.
* RRC0021 – Instituição Financeira / Não Financeira realiza a consulta de negociação de recebíveis.
* RRC0035 – Instituição Financeira / Não Financeira realiza a alteração do domicílio bancário da negociação de recebíveis.

---

#### 🔹 Fluxo 3 – **Direito de Preferência / Inadimplência** ⚖️

**Objetivo:** Garantir prioridade de recebíveis em caso de inadimplência.

1. **Venda registrada pelo fornecedor** (fora do escopo da Nuclea) 🛒

2. **Na falta de pagamento:** IF/NIF consulta contratos

   * Precedência: **RRC0026** 📌
   * Última posição válida: **RRC0038** 🔎

3. **IF/NIF → Nuclea**

   * Exercício do direito: **RRC0012** (resilição / liberação de excedente) 📤

4. **Nuclea → IF/NIF e Credenciadora**

   * Confirmação: **RRC0014**, **RRC0024** ✅
   * Caso rejeite: **RRC0025** ❌

5. **Recebíveis redirecionados até quitação** 💳➡️🏦

**Arquivos/Mensagens envolvidas:**
* RRC0012 – Credenciadora / Instituição Financeira / Não Financeira realiza a comunicação de resilição ou liberação de excedente de garantia.
* RRC0014 – Registradora NÚCLEA informa a comunicação de resilição ou liberação de excedente de garantia às Instituições Financeiras / Não Financeiras / Credenciadora.
* RRC0024 – Registradora NÚCLEA informa o retorno da comunicação de resilição ou liberação de excedente de garantia às Credenciadoras / Instituição Financeira / Não Financeira.
* RRC0025 – Instituição Financeira / Não Financeira realiza o retorno de negativa da comunicação de resilição ou liberação de excedente de garantia.
* RRC0026 – Credenciador consulta existência de negociação para análise de precedência de contrato
* RRC0038 – Credenciador consulta negociação de recebíveis na última posição válida do contrato.

---

#### 🔹 Fluxo 4 – **Administrativos / Operacionais** ⚙️

**Objetivo:** Gerenciar participantes, janelas de negociação e conciliações.

* **Nuclea → Todos**

  * Lista participantes ativos: **ARRC017** 👥
  * Janelas de negociação: **RRC0015**, **RRC0016** 🕒
  * Início/fim envio de arquivos: **ARRC032** 📤📥
  * Atualiza ECs vinculados e fecha conciliações: **CRRC040**, **CRRC041** ✅

* **Credenciadora → Nuclea**

  * Lista de credenciados ativos: **ARRC030** 📝

**Arquivos/Mensagens envolvidas:**
* ARRC017 – Registradora NÚCLEA informa a lista de Participantes ativos.
* ARRC030 – Credenciador informar a lista de credenciados ativos.
* ARRC032 – Registradora NÚCLEA informa início e término do envio de arquivos
* RRC0015 – Registradora NÚCLEA informa a abertura da janela de negociações.
* RRC0016 – Registradora NÚCLEA informa o fechamento da janela de negociações.
* CRRC040 – Registradora NÚCLEA informa estabelecimentos comerciais vinculados ao credenciador para conciliação
* CRRC041 – Registradora NÚCLEA informa fechamento da conciliação

---



---

# 📌 Estado Atual do Projeto (Informações técnicas)

## ⚙️ Stack Atual do Protótipo

* **Framework:** Laravel
* **Banco de Dados:** MySQL
* **Frontend:** Blade Engine + TailwindCSS
* **Template:** [Aastera Laravel Template](#sobre-o-template)

O protótipo utiliza **rotas web** (`routes/web.php`) para exibir telas simples de gerenciamento de:

* Parceiros de Negócio (ECs, Credenciadoras/Subcredenciadoras, Fornecedores)
* Contratos
* Opt-ins
* Recebíveis
* Operações

---

## ▶️ Como Rodar o Projeto

### 🔧 Pré-requisitos

* **PHP 8.3+**
* **Composer**
* **MySQL** ou outro banco configurado no `.env`

### 🚀 Passos de Instalação

1. **Clonar o repositório**

   ```bash
   git clone <url-do-repo>
   cd dix_receivables
   ```

2. **Criar o arquivo de configuração `.env`**

   * Copiar o exemplo:

     ```bash
     cp .env.example .env
     ```
   * Editar o `.env` e configurar:

     * Conexão com o banco de dados (`DB_*`)
     * Serviços externos (Nuclea, RTM, Bugsnag, etc.)

3. **Instalar dependências PHP**

   ```bash
   composer install
   ```

4. **Gerar chave da aplicação**

   ```bash
   php artisan key:generate
   ```

5. **Executar as migrations**

   ```bash
   php artisan migrate --seed
   ```

6. **Rodar o servidor local**

   ```bash
   php artisan serve
   ```

   O sistema ficará disponível em: [http://localhost:8000](http://localhost:8000)

---

## 🗂️ Estrutura de Pastas e Responsabilidades

### 1. **Ações (`app/Actions`)**

Contém classes que representam **cada comunicação via arquivo/mensagem com a Nuclea ou RTM**.
Exemplos:

* `ARRC022Action.php`, `ARRC023Action.php`, `ARRC033Action.php`, `ARRC036Action.php`
* `RRC0010Action.php`, `RRC0011Action.php`, `RRC0013Action.php`, `RRC0019Action.php`, `RRC0020Action.php`

### 2. **Clientes de API (`app/ApiClients`)**

* Estruturados por serviço externo:

  * **Nuclea:** `NucleaApiClient`, `NucleaAuthApiClient`
  * **RTM:** `RtmApiClient`, `RtmAuthApiClient`
* Baseados em `ApiClient.php` e `ApiClientContract.php` (contrato para padronização).

### 3. **Models Core (`app/Models/Core`)**

Representam as principais entidades do negócio:

* `Receivable` (Recebível)
* `OptIn`, `OptOut`
* `BusinessPartner` (parceiros de negócio – EC, Credenciadora/Subcredenciadora, Fornecedor)
* `Contract` (contratos entre Altri, fornecedor e EC)
* `PaymentArrangement` (arranjos de pagamento)
* `Operation` (Operações)

Incluem também **pivots** de relacionamento entre contratos e adquirentes/arranjos.

### 4. **Camada Web e API (`app/Http`)**

* **Controllers Core (API REST):** CRUD para contratos, recebíveis, opt-ins, opt-outs, arranjos de pagamento etc.
* **Controllers Web:** Interfaces simples para navegação no protótipo (Blade).
* **Webhooks:** Estrutura para integração com notificações da RTM.

### 5. **Validação e Transformação**

* **Requests:** Classes de validação para cada recurso (ex.: `StoreContractRequest`, `UpdateReceivableRequest`).
* **Resources:** Serialização padronizada de saída (ex.: `ContractResource`, `ReceivableResource`).

### 6. **Serviços (`app/Services`)**

* Encapsulam regras de negócio (ex.: `ContractService`, `ReceivableService`, `OptInService`).
* Auxiliares de integração (`ApiRequestService`, `ApiResponseService`).

### 7. **Jobs Assíncronos (`app/Jobs`)**

* `DispatchOptInJob`, `GetContractReceivablesJob`, `RequestOptInJob`
* Estrutura para orquestrar chamadas de opt-in e consultas à agenda de recebíveis.

### 8. **Migrations**

Estrutura de dados já preparada:

* Usuários, autenticação e permissões
* Contratos, parceiros de negócio e arranjos de pagamento
* Recebíveis, opt-ins e opt-outs
* Operações e logs de integração (requests/responses)

---

## Árvore do projeto atual

```markdown
.
├── README.md
├── app
│   ├── Actions
│   │   ├── ARRC022Action.php
│   │   ├── ARRC022RetAction.php
│   │   ├── ARRC023Action.php
│   │   ├── ARRC023RetAction.php
│   │   ├── ARRC033Action.php
│   │   ├── ARRC033RetAction.php
│   │   ├── ARRC036Action.php
│   │   ├── ARRC036RetAction.php
│   │   ├── RRC0010Action.php
│   │   ├── RRC0011Action.php
│   │   ├── RRC0013Action.php
│   │   ├── RRC0019Action.php
│   │   └── RRC0020Action.php
│   ├── ApiClients
│   │   ├── ApiClient.php
│   │   ├── Nuclea
│   │   │   ├── NucleaApiClient.php
│   │   │   └── NucleaAuthApiClient.php
│   │   └── Rtm
│   │       ├── RtmApiClient.php
│   │       └── RtmAuthApiClient.php
│   ├── Auxiliary
│   │   └── UpdatedContractInfo.php
│   ├── Console
│   │   └── Commands
│   │       ├── CleanOldRecords.php
│   │       ├── MakeFullController.php
│   │       ├── MakeFullModel.php
│   │       ├── MakeFullResource.php
│   │       ├── MakeRequests.php
│   │       ├── MakeRestApiResource.php
│   │       └── MakeService.php
│   ├── Contracts
│   │   └── ApiClientContract.php
│   ├── DataTransferObjects
│   │   └── Nuclea
│   │       ├── CancelOperationPartialRequest.php
│   │       ├── CancelOperationRequest.php
│   │       ├── CancelOperationTotalRequest.php
│   │       ├── ConfirmOperationEntidadeRequest.php
│   │       ├── ConfirmOperationEntidadeSemAlcanceRequest.php
│   │       ├── ConfirmOperationParticipanteRequest.php
│   │       └── ConfirmOperationRequest.php
│   ├── Enums
│   │   ├── ActionInvolvedPartyType.php
│   │   ├── ActionType.php
│   │   ├── BusinessPartnerType.php
│   │   ├── OperationStatus.php
│   │   ├── OptInStatus.php
│   │   └── OptOutStatus.php
│   ├── Helpers
│   │   └── global.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── AttachmentController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Controller.php
│   │   │   ├── Core
│   │   │   │   ├── ActionController.php
│   │   │   │   ├── BusinessPartnerController.php
│   │   │   │   ├── ContractController.php
│   │   │   │   ├── Files
│   │   │   │   │   └── ARRC018ResponseController.php
│   │   │   │   ├── OperationController.php
│   │   │   │   ├── OptInController.php
│   │   │   │   ├── OptOutController.php
│   │   │   │   ├── PaymentArrangementController.php
│   │   │   │   ├── Pivots
│   │   │   │   │   ├── ContractHasAcquirerController.php
│   │   │   │   │   ├── ContractHasPaymentArrangementController.php
│   │   │   │   │   └── ContractHasReceivableController.php
│   │   │   │   └── ReceivableController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── UserController.php
│   │   │   ├── Web
│   │   │   │   ├── BusinessPartnerController.php
│   │   │   │   ├── ContractController.php
│   │   │   │   ├── GeneralController.php
│   │   │   │   ├── OperationController.php
│   │   │   │   ├── OptInController.php
│   │   │   │   └── ReceivableController.php
│   │   │   └── Webhooks
│   │   │       ├── RtmWebhookController.php
│   │   │       └── RtmWebhookSubService.php
│   │   ├── Middleware
│   │   │   ├── LogRequest.php
│   │   │   └── LogResponse.php
│   │   ├── Requests
│   │   │   ├── ARRC018Responses
│   │   │   │   ├── GetARRC018ResponsesRequest.php
│   │   │   │   ├── StoreARRC018ResponseRequest.php
│   │   │   │   └── UpdateARRC018ResponseRequest.php
│   │   │   ├── Actions
│   │   │   │   ├── GetActionsRequest.php
│   │   │   │   ├── StoreActionRequest.php
│   │   │   │   └── UpdateActionRequest.php
│   │   │   ├── Attachments
│   │   │   │   ├── AddAttachmentRequest.php
│   │   │   │   └── DestroyAttachmentRequest.php
│   │   │   ├── Auth
│   │   │   │   ├── LoginRequest.php
│   │   │   │   ├── RedefinePasswordRequest.php
│   │   │   │   ├── RegisterRequest.php
│   │   │   │   └── StartPasswordResetRequest.php
│   │   │   ├── BusinessPartners
│   │   │   │   ├── GetBusinessPartnersRequest.php
│   │   │   │   ├── StoreBusinessPartnerRequest.php
│   │   │   │   └── UpdateBusinessPartnerRequest.php
│   │   │   ├── ContractHasAcquirers
│   │   │   │   ├── GetContractHasAcquirersRequest.php
│   │   │   │   ├── StoreContractHasAcquirerRequest.php
│   │   │   │   └── UpdateContractHasAcquirerRequest.php
│   │   │   ├── ContractHasPaymentArrangements
│   │   │   │   ├── GetContractHasPaymentArrangementsRequest.php
│   │   │   │   ├── StoreContractHasPaymentArrangementRequest.php
│   │   │   │   └── UpdateContractHasPaymentArrangementRequest.php
│   │   │   ├── ContractHasReceivables
│   │   │   │   ├── GetContractHasReceivablesRequest.php
│   │   │   │   ├── StoreContractHasReceivableRequest.php
│   │   │   │   └── UpdateContractHasReceivableRequest.php
│   │   │   ├── Contracts
│   │   │   │   ├── GetContractsRequest.php
│   │   │   │   ├── StoreContractRequest.php
│   │   │   │   └── UpdateContractRequest.php
│   │   │   ├── Operations
│   │   │   │   ├── GetOperationsRequest.php
│   │   │   │   ├── StoreOperationRequest.php
│   │   │   │   └── UpdateOperationRequest.php
│   │   │   ├── OptIns
│   │   │   │   ├── GetOptInsRequest.php
│   │   │   │   ├── StoreOptInRequest.php
│   │   │   │   └── UpdateOptInRequest.php
│   │   │   ├── OptOuts
│   │   │   │   ├── GetOptOutsRequest.php
│   │   │   │   ├── StoreOptOutRequest.php
│   │   │   │   └── UpdateOptOutRequest.php
│   │   │   ├── PaymentArrangements
│   │   │   │   ├── GetPaymentArrangementsRequest.php
│   │   │   │   ├── StorePaymentArrangementRequest.php
│   │   │   │   └── UpdatePaymentArrangementRequest.php
│   │   │   ├── ProfileUpdateRequest.php
│   │   │   ├── Receivables
│   │   │   │   ├── GetReceivablesRequest.php
│   │   │   │   ├── StoreReceivableRequest.php
│   │   │   │   └── UpdateReceivableRequest.php
│   │   │   └── Users
│   │   │       ├── GetUsersRequest.php
│   │   │       ├── StoreUserRequest.php
│   │   │       └── UpdateUserRequest.php
│   │   └── Resources
│   │       ├── ARRC018ResponseResource.php
│   │       ├── ActionResource.php
│   │       ├── BusinessPartnerResource.php
│   │       ├── ContractHasAcquirerResource.php
│   │       ├── ContractHasPaymentArrangementResource.php
│   │       ├── ContractHasReceivableResource.php
│   │       ├── ContractResource.php
│   │       ├── OperationResource.php
│   │       ├── OptInResource.php
│   │       ├── OptOutResource.php
│   │       ├── PaymentArrangementResource.php
│   │       ├── ReceivableResource.php
│   │       └── UserResource.php
│   ├── Jobs
│   │   ├── DispatchOptInJob.php
│   │   ├── GetContractReceivablesJob.php
│   │   ├── RequestOptInJob.php
│   │   └── VerifyReceivablesToOperateJob.php
│   ├── Models
│   │   ├── Core
│   │   │   ├── Action.php
│   │   │   ├── BusinessPartner.php
│   │   │   ├── Contract.php
│   │   │   ├── Files
│   │   │   │   └── ARRC018Response.php
│   │   │   ├── Operation.php
│   │   │   ├── OptIn.php
│   │   │   ├── OptOut.php
│   │   │   ├── PaymentArrangement.php
│   │   │   ├── Pivots
│   │   │   │   ├── ContractHasAcquirer.php
│   │   │   │   ├── ContractHasPaymentArrangement.php
│   │   │   │   └── ContractHasReceivable.php
│   │   │   └── Receivable.php
│   │   ├── Rtm
│   │   │   ├── CancelOperationResponse.php
│   │   │   ├── CipMessage.php
│   │   │   ├── Error.php
│   │   │   ├── HolderReceivableUnit.php
│   │   │   ├── Merchant.php
│   │   │   ├── MerchantResponse.php
│   │   │   ├── OperationCancelNotification.php
│   │   │   ├── OperationNotification.php
│   │   │   ├── OperationResponse.php
│   │   │   ├── OperationSummary.php
│   │   │   ├── OperationSummaryControl.php
│   │   │   ├── OptInNotification.php
│   │   │   ├── OptOutResponse.php
│   │   │   ├── Participant.php
│   │   │   ├── Payment.php
│   │   │   ├── PaymentInformation.php
│   │   │   ├── ReceivableSchedule.php
│   │   │   ├── ReceivableScheduleHolder.php
│   │   │   ├── ReceivableScheduleReceivingFinalUser.php
│   │   │   ├── ReceivableUnit.php
│   │   │   ├── ReceivableUnitCancel.php
│   │   │   ├── ReceivableUnitDomicile.php
│   │   │   ├── ReceivableUnitDomicileOperation.php
│   │   │   ├── ReceivableUnitFinalUser.php
│   │   │   ├── ReceivableUnitFinalUserHolder.php
│   │   │   ├── ReceivableUnitOtherInstitution.php
│   │   │   ├── ReceivableUnitResponse.php
│   │   │   ├── ReceivingFinalUserReceivableUnit.php
│   │   │   ├── RtmAccessToken.php
│   │   │   └── Timetable.php
│   │   ├── Support
│   │   │   ├── ApiRequest.php
│   │   │   ├── ApiResponse.php
│   │   │   ├── ClientRequest.php
│   │   │   └── ServerResponse.php
│   │   └── User.php
│   ├── Providers
│   │   ├── AppServiceProvider.php
│   │   └── HelperServiceProvider.php
│   ├── Services
│   │   ├── Core
│   │   │   ├── ActionService.php
│   │   │   ├── BusinessPartnerService.php
│   │   │   ├── ContractService.php
│   │   │   ├── Files
│   │   │   │   └── ARRC018ResponseService.php
│   │   │   ├── OperationService.php
│   │   │   ├── OptInService.php
│   │   │   ├── OptOutService.php
│   │   │   ├── PaymentArrangementService.php
│   │   │   ├── Pivots
│   │   │   │   ├── ContractHasAcquirerService.php
│   │   │   │   ├── ContractHasPaymentArrangementService.php
│   │   │   │   └── ContractHasReceivableService.php
│   │   │   └── ReceivableService.php
│   │   ├── Support
│   │   │   ├── ApiRequestService.php
│   │   │   └── ApiResponseService.php
│   │   └── UserService.php
├── config
│   ├── altri.php
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   └── session.php
├── database
│   ├── factories
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_02_23_151531_create_client_requests_table.php
│   │   ├── 2024_02_23_151922_create_server_responses_table.php
│   │   ├── 2024_09_02_114618_create_api_requests_table.php
│   │   ├── 2024_09_02_114623_create_api_responses_table.php
│   │   ├── 2025_02_26_054506_create_media_table.php
│   │   ├── 2025_07_13_203506_create_personal_access_tokens_table.php
│   │   ├── 2025_09_08_231151_create_receivables_table.php
│   │   ├── 2025_09_10_233623_create_opt_ins_table.php
│   │   ├── 2025_09_11_212831_create_opt_outs_table.php
│   │   ├── 2025_09_16_193344_create_operations_table.php
│   │   ├── 2025_09_17_121858_create_business_partners_table.php
│   │   ├── 2025_09_17_122402_create_contracts_table.php
│   │   ├── 2025_09_17_123524_create_contract_has_acquirers_table.php
│   │   ├── 2025_09_17_123719_create_payment_arrangements_table.php
│   │   ├── 2025_09_17_124458_create_contract_has_payment_arrangements_table.php
│   │   ├── 2025_09_26_124907_create_a_r_r_c018_responses_table.php
│   │   ├── 2025_09_26_141905_create_contract_has_receivables_table.php
│   │   └── 2025_10_14_131728_create_actions_table.php
│   └── seeders
│       ├── ActionSeeder.php
│       ├── BusinessPartnerSeeder.php
│       ├── DatabaseSeeder.php
│       ├── PaymentArrangementSeeder.php
│       └── UserSeeder.php
├── public
│   ├── build
│   │   ├── assets
│   │   │   ├── app-Bk1NQbSf.css
│   │   │   └── app-CXDpL9bK.js
│   │   └── manifest.json
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
├── resources
│   ├── css
│   │   └── app.css
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views
│       ├── auth
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── business-partners
│       │   ├── form.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── components
│       │   ├── application-logo.blade.php
│       │   ├── auth-session-status.blade.php
│       │   ├── danger-button.blade.php
│       │   ├── dropdown-link.blade.php
│       │   ├── dropdown.blade.php
│       │   ├── input-error.blade.php
│       │   ├── input-label.blade.php
│       │   ├── modal.blade.php
│       │   ├── nav-link.blade.php
│       │   ├── primary-button.blade.php
│       │   ├── responsive-nav-link.blade.php
│       │   ├── secondary-button.blade.php
│       │   └── text-input.blade.php
│       ├── contracts
│       │   ├── form.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── dashboard.blade.php
│       ├── index.blade.php
│       ├── layouts
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── operations
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── optins
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── profile
│       │   ├── edit.blade.php
│       │   └── partials
│       │       ├── delete-user-form.blade.php
│       │       ├── update-password-form.blade.php
│       │       └── update-profile-information-form.blade.php
│       └── receivables
│           ├── index.blade.php
│           └── show.blade.php
├── routes
│   ├── api.php
│   ├── auth.php
│   ├── console.php
│   └── web.php
```

---

## 📊 Funcionalidades Atuais do Protótipo

* **Gerenciamento básico via Web (Blade):** contratos, parceiros, opt-ins, operações e recebíveis.
* **API REST estruturada:** baseada no template, com controllers/resources/requests já padronizados.
* **Integração preparada com Nuclea e RTM:** via `ApiClients` + `Actions`.
* **Jobs assíncronos:** para opt-in e consulta de recebíveis.
* **Logs estruturados:** requests/responses salvos no banco.
* **Estrutura escalável:** já adaptada para lidar com múltiplos arranjos/adquirentes.



---

## 🌐 Sobre o Template

O projeto foi criado a partir do **Aastera Laravel Template**, que adiciona recursos além do Laravel padrão:

* Logging automático de requests/responses.
* Comando `make:rest-api-resource` para scaffolding rápido de novos módulos REST.
* Autenticação pronta (cadastro, login, reset de senha).
* Integrações configuradas com **Bugsnag** (erros) e **Spatie Media Library** (uploads).
* Helpers globais + estrutura limpa (`Controllers`, `Models`, `Services`, `Contracts`).

