<x-filament::page>
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-semibold">Ativos disponíveis para venda</h2>
            <p class="text-sm text-gray-600">Veja ativos disponíveis no mercado.</p>
        </div>

        {{ $this->table }}
    </div>
</x-filament::page>
