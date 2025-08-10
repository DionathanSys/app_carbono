<x-filament::page>
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold">Instrumentos disponíveis para venda</h2>
            <p class="text-sm text-gray-600">Veja itens de outros usuários disponíveis no mercado.</p>
        </div>

        {{ $this->table }}
    </div>
</x-filament::page>
