<?php

namespace Database\Seeders;

use App\Enums\BusinessPartnerType;
use App\Enums\ContractStatus;
use App\Enums\NegotiationType;
use App\Enums\OperationStatus;
use App\Enums\ReceivableStatus;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use App\Models\Core\Receivable;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // ====== CONFIG ======
        $clientsCount = 3;
        $receivablesPerClient = [10, 20];
        $operationsPerClient = [3, 6];

        // ====== BASE PARTNERS ======
        $suppliers = collect([BusinessPartner::find('0199e442-a78f-70dc-8847-19a3d226460d')]);
        $acquirers = $this->createAcquirers(2);

        $fixedUser = User::findOrFail('019b329f-265e-70c1-9705-de91ae9db0f6');

        // ====== CLIENTES + DADOS ======
        for ($c = 1; $c <= $clientsCount; $c++) {
            $this->createClientScenario(
                index: $c,
                user: $fixedUser,
                suppliers: $suppliers,
                acquirers: $acquirers,
                receivablesPerClient: $receivablesPerClient,
                operationsPerClient: $operationsPerClient,
            );
        }
    }

    // ======================================================
    // ================ CENÁRIO COMPLETO ====================
    // ======================================================

    private function createClientScenario(
        int $index,
        User $user,
        Collection $suppliers,
        Collection $acquirers,
        array $receivablesPerClient,
        array $operationsPerClient,
    ): void {
        $client = $this->createClient($index, $user);

        $supplier = $suppliers->random();
        $acquirer = $acquirers->random();

        $receivables = $this->createReceivables(
            client: $client,
            acquirer: $acquirer,
            countRange: $receivablesPerClient,
        );

        $this->createOperations(
            client: $client,
            supplier: $supplier,
            receivables: $receivables,
            countRange: $operationsPerClient,
        );
    }


    // ======================================================
    // ================= BUSINESS PARTNERS ==================
    // ======================================================

    private function createAcquirers(int $count): Collection
    {
        return collect(range(1, $count))->map(
            fn($i) =>
            $this->createBusinessPartner("Acquirer {$i}", BusinessPartnerType::ACQUIRER, "acquirer{$i}@test.com")
        );
    }

    private function createClient(int $index, User $user): BusinessPartner
    {
        $client = $this->createBusinessPartner(
            "Empresa {$index}",
            BusinessPartnerType::CLIENT,
            "cliente{$index}@test.com"
        );

        // 🔗 associa com o usuário no pivot
        $client->users()->attach($user->id, [
            'opt_in_start_date' => now(),
            'opt_in_end_date' => null,
        ]);

        return $client;
    }

    private function createBusinessPartner(string $name, BusinessPartnerType $type, string $email): BusinessPartner
    {
        return BusinessPartner::create([
            'name' => $name,
            'fantasy_name' => $name,
            'description' => "{$name} fake",
            'type' => $type,
            'document_number' => str_pad((string) rand(1, 99999999999999), 14, '0', STR_PAD_LEFT),
            'base_document_number' => null,
            'email' => $email,
            'phone' => '54999999999',
            'postal_code' => '99000000',
            'address' => 'Rua Teste',
            'address_number' => '123',
            'address_neighborhood' => 'Centro',
            'address_city' => 'Passo Fundo',
            'address_state' => 'RS',
            'address_state_code' => 'RS',
        ]);
    }

    // ======================================================
    // ===================== CONTRACT ========================
    // ======================================================

    private function createContract(BusinessPartner $client, BusinessPartner $supplier): Contract
    {
        return Contract::create([
            'client_id' => $client->id,
            'supplier_id' => $supplier->id,
            'value' => rand(100_000, 500_000) / 100,
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonths(10),
            'status' => ContractStatus::ACTIVE,
            'uses_registrar_management' => true,
            'negotiation_type' => NegotiationType::CESSAO,
        ]);
    }

    // ======================================================
    // ==================== RECEIVABLES ======================
    // ======================================================

    private function createReceivables(
        BusinessPartner $client,
        BusinessPartner $acquirer,
        array $countRange,
    ): Collection {
        $count = rand(...$countRange);

        $receivables = collect();

        for ($i = 1; $i <= $count; $i++) {
            $total = rand(1_000, 20_000) / 100;

            $receivables->push(
                Receivable::create([
                    'status' => ReceivableStatus::AVAILABLE,
                    'client_id' => $client->id,
                    'acquirer_id' => $acquirer->id,
                    'payment_arrangement_id' => null,
                    'tpObj' => '1',
                    'cnpjER' => $client->document_number,
                    'cnpjCreddrSub' => null,
                    'codInstitdrArrajPgto' => '123',
                    'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
                    'dtPrevtLiquid' => now()->addDays(rand(5, 90)),
                    'indrDomcl' => 'A',
                    'vlrLivreUsuFinalRecbdr' => $total,
                    'vlrTot' => $total,
                    'available_value' => $total,
                    'amount_locked_by_others' => 0,
                    'is_to_be_constituted' => false,
                ])
            );
        }

        return $receivables;
    }

    // ======================================================
    // ===================== OPERATIONS ======================
    // ======================================================

    private function createOperations(
        BusinessPartner $client,
        BusinessPartner $supplier,
        Collection $receivables,
        array $countRange,
    ): void {
        $count = rand(...$countRange);

        for ($i = 1; $i <= $count; $i++) {

            $contract = $this->createContract($client, $supplier);

            $operation = Operation::create([
                'action_id' => null,
                'contract_id' => $contract->id,
                'client_id' => $client->id,
                'supplier_id' => $supplier->id,
                'status' => OperationStatus::ACCEPTED,
                'identdOp' => Str::uuid(),
                'sitRet' => 'PENDING',
                'operation_href' => null,
                'scheduled_at' => now()->addDays(rand(1, 30)),
                'request_payload' => [
                    'fake' => true,
                    'index' => $i,
                ],
            ]);

            $this->attachReceivablesToOperation($operation, $receivables);
        }
    }


    private function attachReceivablesToOperation(Operation $operation, Collection $receivables): void
    {
        $picked = $receivables->random(rand(1, min(5, $receivables->count())));

        foreach ($picked as $receivable) {
            $max = min($receivable->available_value, $receivable->vlrTot);

            if ($max <= 0) {
                continue;
            }

            $amount = rand(1, (int)($max * 100)) / 100;

            $operation->receivables()->attach($receivable->id, [
                'amount' => $amount,
            ]);

            // trava valores
            $receivable->amount_locked_by_others += $amount;
            $receivable->available_value -= $amount;
            $receivable->save();
        }
    }
}
