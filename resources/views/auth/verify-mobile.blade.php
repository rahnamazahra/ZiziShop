<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your mobile by sms.') }}
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.mobile') }}">
            @csrf
            <!-- hidden mobile -->
                <x-text-input id="mobile" class="block mt-1 w-full" type="hidden" name="mobile" :value="{{ session('mobile') }}"/>
            <!-- code -->
            <div class="mt-4">
                <x-input-label for="verification_code" :value="__('verification_code')" />
                <x-text-input id="verification_code" class="block mt-1 w-full" type="text" name="verification_code" :value="old('verification_code')" required/>
                <x-input-error :messages="$errors->get('verification_code')" class="mt-2" />
            </div>
            <div>
                <x-primary-button>
                    {{ __('Verification Mobile') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
