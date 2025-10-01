<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enviar E-mail para: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                  
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('users.email.send', $user) }}">
                        @csrf
                        
                       
                        <input type="hidden" name="recipient_email" value="{{ $user->email }}">
                        <input type="hidden" name="recipient_name" value="{{ $user->name }}">

                        <div>
                            <x-input-label for="subject" :value="__('Assunto')" />
                            <x-text-input 
                                id="subject" 
                                class="block mt-1 w-full" 
                                type="text" 
                                name="subject" 
                                :value="old('subject')" 
                                required 
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>

                      
                        <div class="mt-4">
                            <x-input-label for="message_content" :value="__('Mensagem')" />
                            <textarea 
                                id="message_content" 
                                name="message_content" 
                                rows="8" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                required
                            >{{ old('message_content') }}</textarea>
                            <x-input-error :messages="$errors->get('message_content')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button>
                                {{ __('Enviar E-mail') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
