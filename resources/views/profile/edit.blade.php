<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="p-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400">👤</span>
            <h1 class="font-bold text-xl sm:text-2xl font-serif text-gray-900 dark:text-white leading-tight">
                {{ __('Profile') }}
            </h1>
        </div>
    </x-slot>

    <div class="py-10" dir="rtl">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Update Profile Info Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-red-100 dark:border-red-950/40 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
