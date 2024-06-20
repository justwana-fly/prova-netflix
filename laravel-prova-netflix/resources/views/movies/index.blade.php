<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Popular Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Contenuto della pagina dei film popolari -->
                    <h1>Popular Movies</h1>
                    <form action="{{ route('movies.search') }}" method="GET" class="mb-4">
                        <input type="text" name="query" placeholder="Search for a movie" class="p-2 border rounded">
                        <button type="submit" class="p-2 bg-blue-500 text-white rounded">Search</button>
                    </form>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($movies as $movie)
                            <div class="col-span-1 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 cursor-pointer" onclick="showDetails('{{ $movie['id'] }}')">
                                <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" class="h-70 w-full object-cover" alt="{{ $movie['title'] }}">
                                <div class="p-4 ">
                                    <h5 class="text-lg font-bold">{{ $movie['title'] }}</h5>
                                    <p class="text-gray-700 dark:text-gray-300">{{ Str::limit($movie['overview'], 100) }}</p>
                                    <button class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">View Details</button>
                                </div>
                            </div>

                            <!-- Modal per mostrare i dettagli del film -->
                            <div id="modal-{{ $movie['id'] }}" class="fixed z-50 inset-0 hidden overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">{{ $movie['title'] }}</h3>
                                                    <div class="mt-2">
                                                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" class="h-64 w-full object-contain" alt="{{ $movie['title'] }}">
                                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $movie['overview'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('{{ $movie['id'] }}')">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
</x-app-layout>
