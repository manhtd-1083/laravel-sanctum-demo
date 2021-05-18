<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <div class="table w-full">
                            <div class="table-row-group bg-gray-800 text-white text-center font-bold">
                                <div class="table-cell border p-3">
                                    Token name
                                </div>
                                <div class="table-cell border p-3">
                                    Ability
                                </div>
                            </div>
                            @forelse (Auth::user()->tokens as $token )
                                <div class="table-row-group text-center">
                                    <div class="table-cell border p-3">
                                        {{ $token->name }}
                                    </div>
                                    <div class="table-cell border p-3">
                                        @forelse ($token->abilities as $ability)
                                            <span class="bg-blue-500 text-center text-white p-2 m-2 rounded-md text-xs">
                                                @if ($ability != '*')
                                                    {{ $ability }}
                                                @else
                                                    All Abilities Enabled
                                                @endif
                                            </span>
                                        @empty
                                            No ability for this token
                                        @endforelse
                                    </div>
                                </div>
                            @empty
                                <div class="table-row-group text-center">
                                    <div class="table-cell border p-3">
                                        _______
                                    </div>
                                    <div class="table-cell border p-3">
                                        <span class="bg-gray-500 text-center text-white p-2 m-2 rounded-md text-xs">
                                            _____
                                        </span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
