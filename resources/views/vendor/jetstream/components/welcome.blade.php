<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <x-jet-application-logo class="block h-12 w-auto" />
    </div>

    <div class="mt-8 text-2xl">
        Welcome to your N-Gross Web Portal!
    </div>

    <div class="mt-6 text-gray-500">
        All the Users are requested to access the mobile application for better integreation.
    </div>
    @if (auth()->user()->user_type === 'manager')
        <a href="{{route('manager.user.index')}}" class="mt-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Manage Vendors</a>
    @endif
</div>

