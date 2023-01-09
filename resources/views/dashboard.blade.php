<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white text-white dark:bg-gray-800 border-b border-gray-200">
                    {{ __("You're logged in!") }}
                    @if (!is_null($batch))
                        <div>
                            Sending Welcome Messages:
                            <br>
                            {{ $batch->processedJobs() }} completed out of {{ $batch->totalJobs }} ({{ $batch->progress() }}%)
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        @if (!is_null($batch) && $batch->progress() < 100)
            <script>
                window.setInterval('refresh()', 2000);
                function refresh() {
                    window.location.reload();
                }
            </script>
        @endif
    </x-slot>


</x-app-layout>
