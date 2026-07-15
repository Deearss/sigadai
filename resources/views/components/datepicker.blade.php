@props(['name', 'value' => '', 'placeholder' => 'Pilih tanggal...'])

<div x-data="{
        open: false,
        value: '{{ $value }}',
        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        
        initDate() {
            let today = new Date();
            if (this.value) {
                today = new Date(this.value);
            }
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
            this.getNoOfDays();
        },
        
        formatDateForDisplay(date) {
            let formattedDay = ('0' + date.getDate()).slice(-2);
            let formattedMonth = ('0' + (date.getMonth() + 1)).slice(-2);
            let formattedYear = date.getFullYear();
            return formattedDay + '/' + formattedMonth + '/' + formattedYear;
        },
        
        get formattedDate() {
            if (!this.value) return '{{ $placeholder }}';
            let d = new Date(this.value);
            return this.formatDateForDisplay(d);
        },

        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month, date);
            return today.toDateString() === d.toDateString();
        },
        
        isSelected(date) {
            if (!this.value) return false;
            const d = new Date(this.year, this.month, date);
            const selected = new Date(this.value);
            return selected.toDateString() === d.toDateString();
        },

        getDateValue(date) {
            let selectedDate = new Date(this.year, this.month, date);
            let formattedDay = ('0' + selectedDate.getDate()).slice(-2);
            let formattedMonth = ('0' + (selectedDate.getMonth() + 1)).slice(-2);
            let formattedYear = selectedDate.getFullYear();
            this.value = formattedYear + '-' + formattedMonth + '-' + formattedDay;
            this.open = false;
            
            // Dispatch event to hidden input
            $nextTick(() => {
                $refs.hiddenInput.dispatchEvent(new Event('change', {bubbles: true}));
            });
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            let dayOfWeek = new Date(this.year, this.month).getDay();
            
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            
            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
        },
        
        prevMonth() {
            if (this.month === 0) {
                this.month = 11;
                this.year--;
            } else {
                this.month--;
            }
            this.getNoOfDays();
        },
        
        nextMonth() {
            if (this.month === 11) {
                this.month = 0;
                this.year++;
            } else {
                this.month++;
            }
            this.getNoOfDays();
        },
        
        getMonthName(monthIndex) {
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return monthNames[monthIndex];
        }
    }" 
    x-init="initDate()"
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
        <span x-text="formattedDate" :class="{ 'text-gray-500': !value, 'text-gray-900': value }"></span>
        <div class="relative flex items-center justify-center w-4 h-4 shrink-0 opacity-50 text-gray-500">
            <!-- Calendar Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" x2="16" y1="2" y2="6"/>
                <line x1="8" x2="8" y1="2" y2="6"/>
                <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
        </div>
    </button>

    <!-- Popover Calendar -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 w-64 p-3 mt-1 bg-white border border-gray-200 rounded-md shadow-lg outline-none"
         style="display: none;"
    >
        <!-- Header -->
        <div class="flex items-center justify-between mb-2">
            <div>
                <span x-text="getMonthName(month)" class="text-sm font-semibold text-gray-900"></span>
                <span x-text="year" class="ml-1 text-sm text-gray-600 font-medium"></span>
            </div>
            <div class="flex space-x-1">
                <button type="button" class="p-1 rounded-md hover:bg-gray-100 transition focus:outline-none" @click="prevMonth()">
                    <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>  
                </button>
                <button type="button" class="p-1 rounded-md hover:bg-gray-100 transition focus:outline-none" @click="nextMonth()">
                    <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Days Header -->
        <div class="grid grid-cols-7 mb-1">
            <template x-for="(day, index) in days" :key="index">
                <div class="px-1 text-center">
                    <div x-text="day" class="text-xs font-medium text-gray-500 uppercase"></div>
                </div>
            </template>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-1">
            <template x-for="blankday in blankdays">
                <div class="p-1 text-center border border-transparent"></div>
            </template>
            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                <div class="px-1 mb-1 text-center">
                    <div @click="getDateValue(date)"
                         x-text="date"
                         class="cursor-pointer text-center text-sm w-7 h-7 rounded-md flex items-center justify-center transition-colors duration-150"
                         :class="{
                            'bg-indigo-600 text-white hover:bg-indigo-700': isSelected(date),
                            'bg-gray-100 text-gray-900 hover:bg-gray-200': isToday(date) && !isSelected(date),
                            'text-gray-700 hover:bg-gray-100': !isToday(date) && !isSelected(date)
                         }">
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
