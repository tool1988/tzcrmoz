<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ZOHO integration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <p style="color: green">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p style="color: red">{{ session('error') }}</p>
            @endif

            @if($errors->any())
                <ul style="color: red;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
                <h3>Create Account</h3>
                <form action="{{ route('createAccount') }}" method="POST">
                    @csrf
                    <label for="field1">acc:</label>
                    <input type="text" id="account_name" name="account_name" value="account test" required>
                    <br>

                    <label for="field2">Поле 2:</label>
                    <input type="text" id="field2" name="website" value="https://example.com" required>
                    <br>

                    <label for="field2">Поле 2:</label>
                    <input type="text" id="field2" name="phone" value="111111111" required>
                    <br>

                    <button type="submit">Create</button>
                </form>

                <h3>Create Deal</h3>
                <form action="{{ route('createDeal') }}" method="POST">
                    @csrf
                    <label for="field1">Name</label>
                    <input type="text" id="account_name" name="deal_name" value="account test" required>
                    <br>

                    <label for="field2">Satage</label>
                    <input type="text" id="field2" name="deal_stage" value="https://example.com" required>
                    <br>

                    <button type="submit">Create</button>
                </form>


        </div>
    </div>
</x-app-layout>
