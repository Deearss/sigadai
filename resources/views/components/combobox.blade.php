@props(['name', 'options' => [], 'value' => '', 'placeholder' => 'Pilih...', 'spinOnSelect' => false])

<div x-data="{
        open: false,
        loading: false,
        value: '{{ $value }}',
        options: {{ json_encode($options) }},
        spinOnSelect: {{ $spinOnSelect ? 'true' : 'false' }},
        get selectedLabel() {
            const opt = this.options.find(o => o.value == this.value);
            return opt ? opt.label : '{{ $placeholder }}';
        },
        select(val) {
            this.value = val;
            this.open = false;
            if (this.spinOnSelect) {
                this.loading = true;
            }
            $nextTick(() => {
                $refs.hiddenInput.dispatchEvent(new Event('change', {bubbles: true}));
            });
        }
    }" 
    class="relative w-full"
    @click.away="open = false"
>
    <!-- Hidden input for form submission -->
    <input type="hidden" name="{{ $name }}" x-model="value" x-ref="hiddenInput">

    <!-- Trigger Button -->
    <button type="button" @click="open = !open"
        class="flex items-center justify-between w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
        :class="{ 'ring-2 ring-indigo-500 border-indigo-500': open }"
    >
        <span x-text="selectedLabel" class="truncate" :class="{ 'text-gray-500': !value, 'text-gray-900': value }"></span>
        <div class="relative flex items-center justify-center w-4 h-4 shrink-0 opacity-50">
            <!-- Spinner -->
            <svg x-show="loading" class="absolute w-4 h-4 text-indigo-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <!-- Chevron -->
            <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </div>
    </button>

    <!-- Popover Content -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 w-full min-w-[8rem] p-1 mt-1 overflow-hidden text-sm bg-white border border-gray-200 rounded-md shadow-lg text-gray-700 outline-none"
         style="display: none;"
    >
        <div class="w-full max-h-60 overflow-y-auto">
            <template x-for="option in options" :key="option.value">
                <div @click="select(option.value)"
                     class="relative flex items-center w-full py-1.5 pl-8 pr-2 rounded-sm cursor-pointer hover:bg-gray-100 hover:text-gray-900 transition-colors duration-150"
                     :class="{ 'font-medium bg-gray-50': value == option.value }"
                >
                    <!-- Check Icon -->
                    <span x-show="value == option.value" class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                    </span>
                    
                    <span x-text="option.label" class="block truncate"></span>
                </div>
            </template>
        </div>
    </div>
</div>
